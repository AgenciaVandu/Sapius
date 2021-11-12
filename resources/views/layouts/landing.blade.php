<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sapius v1</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{asset('img/v1/logo-sapius.svg')}}" width="130" alt="">
            </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">INICIO<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">EXANI-I</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">EXANI-II</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">EXANI-III</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">EGEL</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">ENARM</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <li class="nav-item p-link">
                <a class="nav-link" href="{{ route('register') }}">Registrarme</a>
              </li>
              <form class="form-inline my-2 my-lg-0">
                <a class="btn btn-primary my-2 my-sm-0"  href="{{ route('login') }}">Iniciar sesión</a>
              </form>
            </li>
          </ul>
        </div>
        </div>
    </nav>

    @yield('content')

    <footer>
        <div class="bg-blue">
          <div class="container pt-5">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-12">
                <img src="/img/icono-sapius.png" class="img-fluid" alt="">
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12 pt-2">
                <h3 class="lead" style="color: #fff;">Contáctanos</h3>
                  <li>Teléfono</li>
                  <li><a href="tel:529992988744">+52 999 298 8744</a></li>
                  <li>Email:</li>
                  <li><a href="">contacto@sapius.com</a></li>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12 pt-2">
                <h3 class="lead" style="color: #fff;">Mapa del sitio</h3>
                <div class="row">
                  <div class="col-6">
                    <li><a href="#">INICIO</a></li>
                    <li><a href="#">EXANI-I</a></li>
                    <li><a href="#">EXANI-II</a></li>
                    <li><a href="#">EXANI-III</a></li>
                  </div>
                  <div class="col-6">
                    <li><a href="#">ENARM</a></li>
                    <li><a href="#">BLOG</a></li>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12 pt-2">
                <h3 class="lead" style="color: #fff;">Síguenos</h3>
                <li>
                  <div class="row">
                    <a href=""><i class="fab fa-facebook pl-3 pr-3 icono"></i></a>
                    <a href=""><i class="fab fa-instagram pr-3 icono"></i></a>
                    <a href=""><i class="fab fa-twitter pr-3 icono"></i></a>
                    <a href=""><i class="fab fa-tiktok icono"></i></a>
                  </div>
                  <a href="" class="btn btn-light mt-2">ENVIANOS UN WHATSAPP</a>
                </li>
              </div>
            </div>
            <div class="row text-center">
              <div class="col-md-12">
                <div class="pt-5" style="color: #fff;">
                  <p class="copyright" style="text-align: center;">
                    <span class="pr-2"><a href="">Términos y condiciones</a><span class="pl-2">|</span></span> 
                    <span class="pr-2"><a href="">Política de privacidad</a><span class="pl-2">|</span></span>  <br class="d-block d-sm-block d-md-none d-lg-none">
                    <span class="pr-2"><a href="">Política de cookies</a></span> 
                    <br>
                    <small>
                    Sapius.®  Todos los derechos reservados &copy;<script>document.write(new Date().getFullYear()); 
                     </script>. Desarrollado por <a href="https://agenciavandu.com">Agencia Vandu.</a>
                    
                </div>
              </div>
              
            </div>
          </div>
        </div>
      </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
</body>
</html>