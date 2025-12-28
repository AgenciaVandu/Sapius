<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

class N8nTestController extends Controller
{
    public function send()
    {
        //enviar json a una consulta https request desde un cron de n8n omite el webhook
        $data = [
            'status' => 'success',
            'message' => 'Conexión exitosa',
            'timestamp' => now()->toDateTimeString(),
        ];

        return response()->json($data);
    }
}
