<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class AuthController extends Controller
{
    /**
     * Authenticate user from Electron app.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciales inválidas.'
            ], 401);
        }

        // Generate or update API token
        if (!$user->api_token) {
            $user->api_token = Str::random(80);
            $user->save();
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'email' => $user->email,
                'rol' => $user->rol, // Roles handled by Shinobi
            ],
            'api_token' => $user->api_token,
        ]);
    }

    /**
     * Validate or link MAC address.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateMac(Request $request)
    {
        $request->validate([
            'mac_address' => 'required',
        ]);

        $user = $request->user();

        if ($user->is_blocked) {
            return response()->json([
                'success' => false,
                'message' => 'Tu cuenta ha sido bloqueada temporalmente por políticas de seguridad.',
                'is_blocked' => true
            ], 403);
        }

        // Check if user has "alumno" role
        if (!$user->hasRole('alumno')) {
             return response()->json([
                'success' => true,
                'message' => 'Acceso libre para administradores/soporte.'
            ]);
        }

        if (!$user->mac_address) {
            // Link MAC address for the first time
            $user->mac_address = $request->mac_address;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Dirección MAC vinculada con éxito.'
            ]);
        }

        if ($user->mac_address !== $request->mac_address) {
            return response()->json([
                'success' => false,
                'message' => 'Este dispositivo no está autorizado para esta cuenta. Por favor contacta a soporte.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Dispositivo validado.'
        ]);
    }

    /**
     * Register a security strike for the authenticated user from Electron.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerStrike(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $action = $request->input('action', 'Unknown');
            $details = $request->input('details', 'Electron App');
            $points = 10; // Default

            $isFeedbackMode = ($details === 'Feedback Mode');

            // Map actions to severity points (Threshold = 100)
            if (in_array($action, ['Copy', 'Cut', 'Paste', 'PrintScreen', 'Save', 'View Source', 'Snipping Tool', 'Mac Screenshot'])) {
                $points = 34;
            }
            elseif (in_array($action, ['DevTools', 'F12'])) {
                $points = 50;
            }
            elseif ($action === 'Right Click') {
                $points = 20;
            }
            elseif (in_array($action, ['Shift', 'Restricted Key / Modifier'])) {
                $points = 5;
            }
            elseif (strpos($action, 'Volume') !== false) {
                $points = 0;
            }

            if ($isFeedbackMode && $points > 0) {
                $points = 100;
                $details = "se tocaron teclas prohibidas en la retro y es un bloqueo grabe";
            }

            $user->strikes += $points;

            $status = 'warning';
            if ($user->strikes >= 100) {
                $user->is_blocked = true;
                $status = 'blocked';
            }

            $user->save();

            \App\Models\UserStrikeHistory::create([
                'user_id' => $user->id,
                'action' => $action,
                'details' => $details,
            ]);

            return response()->json([
                'status' => $status,
                'strikes' => $user->strikes,
                'max_strikes' => 100,
                'points_added' => $points
            ]);
        }
        return response()->json(['status' => 'error'], 400);
    }

    /**
     * Get recent strikes and severity metrics for the locked view.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLockedDetails(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No autorizado.'], 401);
        }

        $history = \App\Models\UserStrikeHistory::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $recentHistory = \App\Models\UserStrikeHistory::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $totalSeverity = 0;
        $itemsCount = 0;

        foreach ($recentHistory as $h) {
            $act = $h->action;
            $pts = 10; // BASE

            if (in_array($act, ['Copy', 'Cut', 'Paste', 'PrintScreen', 'Save', 'View Source', 'DevTools', 'F12'])) {
                $pts = 100;
            } elseif ($act === 'Right Click') {
                $pts = 50;
            } elseif (in_array($act, ['Shift', 'Restricted Key / Modifier'])) {
                $pts = 10;
            } elseif (strpos($act, 'Volume') !== false) {
                $pts = 0;
            }

            $totalSeverity += $pts;
            $itemsCount++;
        }

        $avgSeverity = $itemsCount > 0 ? $totalSeverity / $itemsCount : 0;

        $isGraveBlock = $recentHistory->contains(function ($h) {
            return strpos($h->details, 'retro') !== false && strpos($h->details, 'grabe') !== false;
        });

        if ($isGraveBlock) {
            $avgSeverity = 100;
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'nombre_completo' => $user->nombre_completo,
                'is_blocked' => $user->is_blocked,
                'strikes' => $user->strikes,
            ],
            'avg_severity' => $avgSeverity,
            'is_grave_block' => $isGraveBlock,
            'history' => $history
        ]);
    }
}
