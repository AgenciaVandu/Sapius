<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Net\MPRequestOptions;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function createCheckout()
    {
        // Configurar token de acceso
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.access_token'));

        // Inicializar el cliente de preferencias
        $client = new PreferenceClient();

        // Crear encabezado de idempotencia (opcional pero recomendable)
        $request_options = new MPRequestOptions();
        $request_options->setCustomHeaders([
            'X-Idempotency-Key: ' . Str::uuid()
        ]);

        // Crear la preferencia
        $preference = $client->create([
            "items" => [
                [
                    "title" => "Producto de ejemplo",
                    "quantity" => 1,
                    "unit_price" => 2000
                ]
            ],
            "back_urls" => [
                "success" => url('/checkout/success'),
                "failure" => url('/checkout/failure'),
                "pending" => url('/checkout/pending'),
            ],
            "auto_return" => "approved",
        ], $request_options);

        return view('checkout', ['preference' => $preference]);
    }
}