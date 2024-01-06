@extends('layouts.landing')
@push('title')
<title>Cursos presenciales para el EXANI y EGEL PLUS en Mérida - Sapius®</title>
@endpush
@push('css')
<link rel="stylesheet" href="{{asset('css/presencial.css')}}">
@endpush
@section('content')
<header class="bg-blue">
    <div class="container text-center">
        <div class="col-12 exani-titular">
            <h1 style="color: #fff;">Forma parte de nuestra comunidad Sapius.<br class="d-none d-sm-none d-md-block d-lg-block">
                Vive la experiencia en modo<span class=color-lowblue> Presencial</span> 
            </h1>
            <p style="color: #fff;">"Tu formación, nuestra pasión"</p>
            <a href="" class="btn btn-primary">Comenzar</a>
        </div>
        
    </div>
</header>
<section id="incluido" class="bg-naranja-3">
    <div class="container">
        <div class="row pt-5 align-items-center">
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Tasa de aprobados <br> del 99.1%</h2>
                <p>Contamos con la tasa de aprobados más alta a nivel nacional,<br> con una acreditación del 99.1%, con resultados de excelencia.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/1.png')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/2.png')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Más de 1200 <br>
                    estudiantes nos avalan</h2>
                <p>En la modalidad presencial contamos con más de 1200 estudiantes, satisfechos con sus resultados.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Profesores expertos en el área
                    con programas actualizados</h2>
                <p>Nuestros profesores cuentan con la máxima experiencia en docencia, cuentan con un amplio conocimiento teórico – practico de la especialidad.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/3.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/4.jpg')}}" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <h2>Contamos con descuentos por 
                    grupos y pago anticipado</h2>
                <p>Programa de descuentos por grupos de estudiantes (Descuento dependiendo el número) y descuento por pago anticipado.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 align-items-center pt-5">
                <h2>Cupo limitado</h2>
                <p>Nuestros programas educativos cuentan con un grupo limitado de estudiantes con la finalidad de brindar atención personalizada a cada estudiante, para la obtención de excelentes resultados.</p>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 pt-5">
                <img src="{{asset('img/v1/estudiantes/5.jpg')}}" class="img-fluid" alt="">
            </div>
        </div>
    </div>
</section>
<section id="experiencia">
    <div class="bg-2 mt-5">
        <div class="container text-center">
            <div class="posicion">
                <h1 style="color: #fff;">Más de 10 años de excelencia nos respaldan</h1>
                <a href="" class="btn btn-primary">COMENZAR</a>
            </div>
        </div>
    </div>
</section>
<section class="prueba">
    <div class="container">
        <div class="titular">
            <h2 class="color-gray">Acredita a la primera y logra tus metas <br>
                <span class="color-gray">Conoce nuestro método de enseñanza</span>
            </h2>
        </div>
        <div class="row pt-4">
            <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/calendario.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Contamos con diferentes <br> horarios disponibles</h2>
                            <p class="color-gray">Lorem, ipsum dolor sit amet consectetur adipisicing elit. At recusandae eius earum et explicabo obcaecati modi tempore excepturi eligendi ut!</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12 mt-5">
                <div class="row">
                    <div class="col-3">
                        <img src="{{asset('img/v1/icon/exni/alumno.png')}}" class="img-fluid" alt="">
                    </div>
                    <div class="col-9">
                        <h4 class="color-gray">Grupos <br> reducidos</h2>
                            <p class="color-gray">Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis a maxime voluptatum eos ullam nesciunt ea. Perferendis blanditiis laboriosam eveniet!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="orgullos-sapius">
    <div class="bg-naranja">
      <div class="container text-center">
       
        <div class="row">
            
          <div class="col-lg-12">
            <figure>
                <img src="{{asset('img/webp/entregables.webp')}}" class="entregables" alt="Entregables Sapius">
            </figure>
          </div>
        </div>
        <div class="titular pt-2 pb-5">
            <h5 class="color-gray">Maximiza tus oportunidades complementando tu preparación con nuestro <br class="d-none d-sm-none d-md-block d-lg-block"> paquete escolar + el acceso al contenido digital</span>
            </h2>
        </div>
      </div>
    </div>
</section>
@include('components.info')
@endsection