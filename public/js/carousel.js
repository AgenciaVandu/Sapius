window.addEventListener('load', function(){
    new Glider(document.querySelector('.carousel__lista1'),{
        slidesToShow: 1,
        slidesToScroll: 1,
        draggable: true,
        dots: '.carousel__indicadores2',
        arrows: {
            prev: '.carousel__anterior',
            next: '.carousel__siguiente'
        },
        responsive: [
            {
              // screens greater than >= 775px
              breakpoint: 900,
              settings: {
                // Set to `auto` and provide item width to adjust to viewport
                slidesToShow: '2',
                slidesToScroll: '1',
              }
            },{
              // screens greater than >= 1024px
              breakpoint: 992,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                itemWidth: 150,
                duration: 1
              }
            }
          ]
    });

});

