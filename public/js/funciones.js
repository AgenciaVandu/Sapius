var validadoEstatusModal = false;

$(document).on('click', 'a[class ~= "btn-detalle"]', function(e){

    btn = $(this);
    liga = '' + btn.attr( "id");

    $('.modal-body').load(liga,function(){
        $('#' + 'myModal').modal({show:true});
    });

});

$('#myModal').on('hidden.bs.modal', function (e) {
    if(validadoEstatusModal){
        location.reload();
    }
    validadoEstatusModal = false;
})

$(document).on('click','.pagination a, a[class ~= "final"]',function(e){
    e.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    var route = $('#liga').val();
    var _token = $('input[name="_token"]').val();
    var prueba_id = $('#prueba_id').val();
    var inscripcion_id = $('#inscripcion_id').val();
    var selected = [];

    $('#preguntas input[type=radio]:checked').each(function(){
            var pr = new Object();
            pr.name = $(this).attr('name');
            pr.value = $(this).val();
            selected.push(pr);
    });

    $.ajax({
        url: route,
        data: {page: page,_token:_token,prueba_id:prueba_id,inscripcion_id:inscripcion_id,respuestas:JSON.stringify(selected)},
        type: 'POST',
        dataType: 'json',
        success: function(data){
            $("#preguntas").html(data);
        }
    });
});

/*************************/
//Param timer = {
//      minutes = value, //minutos que se van a sumar a la hora actual
//      div_show = value, //referencia al elemento div donde se mostrará el timer
//      form_redirect = value //referencia al form de redireccion
//}
/*************************/
function ShowTime(timer) {

    // Set the date we're counting down to
    var countDownDate = new Date();

    countDownDate.setMinutes( countDownDate.getMinutes() + parseInt(timer.minutes) );

    countDownDate = countDownDate.getTime()

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();

      // Find the distance between now and the count down date
      var distance = countDownDate - now;

      // Time calculations for days, hours, minutes and seconds
      //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Display the result in the element with id="demo"
      timer.div_show.html(hours + "h " + minutes + "m " + seconds + "s ");

      // If the count down is finished, write some text
      if (distance < 0) {
        clearInterval(x);
        timer.div_show.html( "EL TIEMPO SE HA AGOTADO" );
        timer.form_redirect.submit();
      }
    }, 1000);

}

function classByClass(_class,_another_class){
    $('.' + _class).addClass(_another_class).removeClass(_class);
}

function textColor(text_color){
    $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').css('color',text_color);
}

function mostrarInformacionTecla(evObject) {
    if(evObject.keyCode == 27){
        $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').bind('mouseover',cardBlack);
        $("#mensaje").modal('hide');
        return 0;
    }
    //shift + teclas especiales + tecla 3 + tecla 4
    _t = [16,17,18,44,51,52,91,93]
    if ( $.inArray(evObject.keyCode,_t) > -1) {
        $("#myInput").show();
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        $("#myInput").hide();
        textColor('white');
        $('div.card .card-body, div.card .card-body .card-title, div.card .card-footer').unbind('mouseover');
        //$("#mensaje").modal('show');

        var route =  $('#liga-finalizar').val();
        var _token = $('input[name="_token"]').val();
        var id = $('#examen_id').val();

        $.ajax({
            url: route,
            data: {examen_id: id,_token:_token},
            type: 'POST',
            dataType: 'json',
            success: function(data){
                $("#preguntas").html(data);
            }
        });
    }
}

function cardBlack(){
        textColor('black');
        classByClass('alert-success1','alert-success');
        classByClass('alert-danger1','alert-danger');
        $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').show();
}

function cardWhite() {
    textColor('white');
    classByClass('alert-success','alert-success1');
    classByClass('alert-danger','alert-danger1');
    $('div.card .card-body img, div.card .card-body .card-title img, div.card .card-footer img').hide();
}

window.mobileAndTabletCheck=function(){let e=!1;var i;return i=navigator.userAgent||navigator.vendor||window.opera,(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(i)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(i.substr(0,4)))&&(e=!0),e},mobileAndTabletCheck()&&(document.getElementById("clases").style.display="none",document.getElementById("otrasclases").style.display="none");
