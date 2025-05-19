<!DOCTYPE html>
<html>
<head>
    <title>Checkout Mercado Pago</title>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h1>Checkout Pro</h1>

    <div id="wallet_container"></div>

    <script>
        const mp = new MercadoPago("{{ config('services.mercadopago.public_key') }}", {
            locale: 'es-AR'
        });

        mp.checkout({
            preference: {
                id: '{{ $preference->id }}'
            },
            render: {
                container: '#wallet_container',
                label: 'Pagar',
            }
        });
    </script>
</body>
</html>
