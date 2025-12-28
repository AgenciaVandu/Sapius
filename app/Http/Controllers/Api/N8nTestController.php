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
            [
            'email' => 'test1@test.com',
            'name' => 'Name 1',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test2@test.com',
            'name' => 'Name 2',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test3@test.com',
            'name' => 'Name 3',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test4@test.com',
            'name' => 'Name 4',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test5@test.com',
            'name' => 'Name 5',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test6@test.com',
            'name' => 'Name 6',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test7@test.com',
            'name' => 'Name 7',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test8@test.com',
            'name' => 'Name 8',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test9@test.com',
            'name' => 'Name 9',
            'timestamp' => now()->toDateTimeString()
            ],
            [
            'email' => 'test10@test.com',
            'name' => 'Name 10',
            'timestamp' => now()->toDateTimeString()
            ],

        ];

        return response()->json($data);
    }
}
