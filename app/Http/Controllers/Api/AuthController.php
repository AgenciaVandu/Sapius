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
}
