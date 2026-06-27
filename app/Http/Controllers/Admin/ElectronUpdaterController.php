<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ElectronUpdaterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $updateDir = public_path('updates/detector');
        
        // Crear directorio si no existe
        if (!File::exists($updateDir)) {
            File::makeDirectory($updateDir, 0755, true);
        }

        $files = [];
        $currentVersion = 'No registrada';
        
        $latestYmlPath = $updateDir . '/latest.yml';
        if (File::exists($latestYmlPath)) {
            $ymlContent = File::get($latestYmlPath);
            if (preg_match('/version:\s*([^\s\n]+)/', $ymlContent, $matches)) {
                $currentVersion = $matches[1];
            }
        }

        // Listar todos los archivos en la carpeta de actualizaciones
        $dirFiles = File::files($updateDir);
        foreach ($dirFiles as $file) {
            $files[] = [
                'name' => $file->getFilename(),
                'size' => $this->formatBytes($file->getSize()),
                'last_modified' => date('d/m/Y H:i:s', $file->getMTime()),
            ];
        }

        return view('admin.electron.updater', compact('files', 'currentVersion'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'latest_yml' => 'nullable|file',
            'installer_exe' => 'nullable|file',
            'blockmap_file' => 'nullable|file',
        ]);

        $updateDir = public_path('updates/detector');
        
        if (!File::exists($updateDir)) {
            File::makeDirectory($updateDir, 0755, true);
        }

        $uploadedCount = 0;

        // 1. Guardar latest.yml
        if ($request->hasFile('latest_yml')) {
            $file = $request->file('latest_yml');
            if ($file->getClientOriginalName() === 'latest.yml' || $file->getClientOriginalExtension() === 'yml') {
                $file->move($updateDir, 'latest.yml');
                $uploadedCount++;
            } else {
                return redirect()->back()->with('error', 'El archivo latest.yml debe llamarse exactamente "latest.yml".');
            }
        }

        // 2. Guardar el instalador .exe
        if ($request->hasFile('installer_exe')) {
            $file = $request->file('installer_exe');
            if ($file->getClientOriginalExtension() === 'exe') {
                $file->move($updateDir, $file->getClientOriginalName());
                $uploadedCount++;
            } else {
                return redirect()->back()->with('error', 'El instalador debe ser un archivo ejecutable (.exe).');
            }
        }

        // 3. Guardar el archivo .blockmap
        if ($request->hasFile('blockmap_file')) {
            $file = $request->file('blockmap_file');
            if ($file->getClientOriginalExtension() === 'blockmap') {
                $file->move($updateDir, $file->getClientOriginalName());
                $uploadedCount++;
            } else {
                return redirect()->back()->with('error', 'El archivo blockmap debe terminar en .blockmap.');
            }
        }

        if ($uploadedCount > 0) {
            return redirect()->route('admin.electron.updater.index')->with('success', "Se subieron {$uploadedCount} archivos con éxito.");
        }

        return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir.');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
