<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;

class N8nTestController extends Controller
{
    public function send()
    {
        $client = new Client();

        $response = $client->post('https://marencocode.app.n8n.cloud/webhook-test/laravel-test', [
            'json' => [
                'name' => 'Alfredo',
                'email' => 'alfredomarenco@boletea.com',
                'source' => 'Laravel 5.8',
            ],
            'headers' => [
                'X-API-KEY' => 'mi-token-secreto',
            ]
        ]);

        return response()->json([
            'status' => 'ok',
            'n8n_response' => json_decode($response->getBody(), true),
        ]);
    }
}
