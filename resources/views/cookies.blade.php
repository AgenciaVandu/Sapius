@extends('layouts.landing')
@push('title')
    <title>Cursos online para aprobar el EGEL PLUS - Sapius®</title>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush
@section('content')
    <header class="header__terms">
        <div class="container mt-5">
            <h1 style="color:white;">POLÍTICA DE COOKIES</h1>
        </div>
    </header>
    <div class="objetivos">
        <div class="container">
            <section class="mt-5">
                <p>Una cookie se refiere a un fichero que es enviado con la finalidad de solicitar permiso para almacenar en
                    su ordenador, al aceptar dicho fichero se crea y la cookie sirve entonces para tener información
                    respecto al tráfico web, y también facilita las futuras visitas a una web recurrente. Otra función que
                    tienen las cookies es que con ellas la web pueden reconocerte individualmente y por tanto brindarte el
                    mejor servicio personalizado de su web.</p>

                <p>Nuestro sitio web emplea las cookies para poder identificar las páginas que son visitadas y su
                    frecuencia. Esta información es empleada únicamente para análisis estadístico y la información se
                    elimina de forma permanente. Usted puede eliminar las cookies en cualquier momento desde su ordenador.
                    Sin embargo, las cookies ayudan a proporcionar un mejor servicio de los sitios web, estas no dan acceso
                    a información de su ni de usted, a menos de que usted así lo quiera y la proporcione directamente. Usted
                    puede aceptar o negar el uso de cookies, sin embargo, la mayoría de los navegadores aceptan cookies
                    automáticamente pues sirven para tener un mejor servicio web. También puede cambiar la configuración de
                    su ordenador para declinar las cookies. Si se declinan es posible que no pueda utilizar algunos de
                    nuestros servicios.</p>

                <h3>Enlaces a Terceros</h3>
                <p>Este sitio web podría contener enlaces a otros sitios que podrían ser de su interés. Una vez que usted
                    haga clic en estos enlaces y abandone nuestra página, ya no tenemos control sobre el sitio al que es
                    redirigido y por lo tanto no somos responsables de los términos o privacidad ni de la protección de sus
                    datos en esos otros sitios terceros. Dichos sitios están sujetos a sus propias políticas de privacidad
                    por lo que es recomendable que los consulte para confirmar que usted está de acuerdo con estas.</p>

                <h3>Control de su información personal</h3>
                <p>En cualquier momento usted puede restringir la recopilación o el uso de la información personal que se
                    proporciona a nuestro sitio web. Cada vez que se le solicite rellenar un formulario, como el de alta de
                    usuario, puede marcar o desmarcar la opción de recibir información por correo electrónico. En caso de
                    que haya marcado la opción de recibir nuestro boletín o publicidad, usted puede cancelarla en cualquier
                    momento.</p>

                <p>Sapius no venderá, cederá ni distribuirá la información personal que es recopilada sin su consentimiento,
                    salvo que sea requerido por un juez con una orden judicial. Sapius se reserva el derecho de cambiar los
                    términos de la presente Política de Privacidad en cualquier momento.</p>
            </section>

        </div>
    </div>
@section('cta')
@endsection
