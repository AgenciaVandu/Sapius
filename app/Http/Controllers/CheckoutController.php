<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Openpay\Data\Openpay;
use Openpay\Data\OpenpayApiRequestError;

class CheckoutController extends Controller
{
    public function createCheckout()
    {
        return view('checkout');
    }


    public function processPay(Request $request)
    {
        /* return $request->token_id;*/
        $openpay = Openpay::getInstance('m4gx48zqyw8xs4en1z1u','sk_d70ffc17846544e39488869d11fac3dc','MX','127.0.0.1');

        $customer = [
            'name' => 'Alfredo',
            'last_name' => 'Gonzalez Marenco',
            'phone_number' => '9993629936',
            'email' => 'marencocode@gmail.com',
        ];

        $chargeData = [
            'method' => 'card',
            'source_id' => $request->token_id,
            'amount' => 100.00, // formato númerico con hasta dos dígitos decimales.
            'currency' => 'MXN',
            'description' => 'Pago de pruebas',
            'device_session_id' => $request->deviceIdHiddenFieldName,
            'order_id' => 'ORD00012000',
            'customer' => $customer
        ];
        /* return $chargeData; */

        try {
            $charge = $openpay->charges->create($chargeData);
        } catch (OpenpayApiRequestError $e) {
            dd([
                'message' => $e->getMessage(),
                'httpCode' => $e->getHttpCode(),
                'errorCode' => $e->getErrorCode(),
                'description' => $e->getDescription(),
                'requestId' => $e->getRequestId()
            ]);
            }

    }
}