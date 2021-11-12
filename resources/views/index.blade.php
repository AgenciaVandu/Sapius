@extends('layouts.landing')
@section('content')
<header class="bg-blue">
    <div class="container pad">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 pad-1">
                <h1 style="color: #fff;">Prepárate con Sapius <br>
                    Cursos online para el <span class=color-lowblue>EGEL</span> 
                </h1>
                <p style="color: #fff;">"Tu formación, es nuestra pasión"</p>
                <a href="" class="btn btn-primary">Comenzar</a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <img src="{{asset ('img/v1/morritos.png')}}" class="w-100 img-fluid" alt="...">
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  </div>
            </div>
        </div>
    </div>
</header>
<section id="orgullos-sapius">
    <div class="bg-naranja pt-5">
      <div class="container">
        <div class="row orgullo-sapius">
          <div class="col-md-6 col-lg-6 col-sm-12">
            <div class="orgullo-txt">
              <h1 class="color-gray">
                  <strong>Conoce nuestros <br>
                orgullos Sapius.
                  </strong>
              </h1>
                <p class="color-gray">Selecciona el objetivo que quieras conseguir</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-6 col-sm-12 text-center">
            <div class="orgullo-card">
              <div class="card">
                <div class="cabecera-orgullo">
                  <img src="{{asset('img/v1/penelope-quintanar-Gracia.png')}}" class=" img-fluid" alt="">
                </div>
                <h4 class="color-gray">Penelope Quintanar G.</h4>
                <p class="color-gray">Pasante de nutrición 
                  <span class="color-orange">
                    <br>Premio Nacional a la 
                    <br> Excelencia EGEL
                  </span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
<section id="nuestra-plataforma">
    <div class="container pt-5 pb-5">
      <h2 class="color-gray text-center pt-5 pb-4">La plataforma diferente para ser excelente</h2>
      <div class="row">
        <div class="col-md-4 col-lg-4 col-sm-12">
          <div class="row">
            <div class="col-2">
              <img src="{{asset('img/v1/icon/1.svg')}}" width="37" alt="">
            </div>
            <div class="col-10">
                <h5 class="color-gray">El 99.1% de nuestros estudiantes acreditan</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
          <div class="row">
            <div class="col-2">
              <img src="{{asset('img/v1/icon/1.svg')}}" width="37" alt="">
            </div>
            <div class="col-10">
              <h5 class="color-gray">Nuestro método SUMA
                maximiza tus resultados</h5>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-lg-4 col-sm-12">
          <div class="row">
            <div class="col-2">
              <img src="{{asset('img/v1/icon/1.svg')}}" width="37" alt="">
            </div>
            <div class="col-10">
              <h5 class="color-gray">El curso más <br class="d-none d-sm-none d-md-block">
                completo del mercado</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="maestros">
    <div class="bg-blue mt-5">
      <div class="container"> <!--Slider-->
        <h2 class="text-center pt-5 pb-4" style="color: #fff;">Conoce a nuestros docentes</h2>
        <div class="row text-center maestros pb-5">
          <div class="col-md-3 col-lg-3 col-sm-6">
            <div class="maestro-img">
              <img src="{{asset('img/v1/maestros.png')}}" class="img-fluid pb-3" alt="">
            </div>
            <h4 style="color: #fff;">Verónica G.</h5>
            <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
            <a href="" class="btn btn-secondary">Enviar Mensaje</a>
          </div>
          <div class="col-md-3 col-lg-3 col-sm-6">
            <div class="maestro-img">
              <img src="{{asset('img/v1/maestros.png')}}" class="img-fluid pb-3" alt="">
            </div>
            <h4 style="color: #fff;">Verónica G.</h5>
            <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
            <a href="" class="btn btn-secondary">Enviar Mensaje</a>
          </div>
          <div class="col-md-3 col-lg-3 col-sm-6">
            <div class="maestro-img">
              <img src="{{asset('img/v1/maestros.png')}}" class="img-fluid pb-3" alt="">
            </div>
            <h4 style="color: #fff;">Verónica G.</h5>
            <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
            <a href="" class="btn btn-secondary">Enviar Mensaje</a>
          </div>
          <div class="col-md-3 col-lg-3 col-sm-6">
            <div class="maestro-img">
              <img src="{{asset('img/v1/maestros.png')}}" class="img-fluid pb-3" alt="">
            </div>
            <h4 style="color: #fff;">Verónica G.</h5>
            <p class="lead" style="color: #fff;">¿Quieres contactar a <br> algún docente?</p>
            <a href="" class="btn btn-secondary">Enviar Mensaje</a>
          </div>
        </div>
      </div> <!--END Slider-->
    </div>
  </section>
  <section id="modalidades">
    <div class="container pt-5 pb-5">
      <div class="row text-center">
        <div class="col-md-6 col-sm-12 p-info">
          <h2>¿Quieres más información?</h5>
          <p class="color-gray ">Nuestros asesores están felices de ayudarte <br><br></p>
          <a href="" class="btn btn-primary">Enviar mensaje</a>
        </div>
        <div class="col-md-6 col-sm-12 p-info">
          <h2>Modalidad Presencial</h5>
          <p class="color-gray">Nuestro cuerpo docente esta disponible para consultas, asesorías, clases, pláticas, conferencias y ponencias.</p>
          <a href="" class="btn btn-primary">Más información</a>
        </div>
      </div>
    </div>
  </section>

@endsection