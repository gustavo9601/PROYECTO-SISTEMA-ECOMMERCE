/*================================
 * VARIABLES
 * ===============================*/
var item = 0;
var itemPaginacion = $('#paginacion li');
var interrumpirCiclo = false;
var imgProducto = $('.imgProducto');
var titulos1 = $('#slide h1');
var titulos2 = $('#slide h2');
var titulos3 = $('#slide h3');
var btnVerProducto = $('#slide button');
var detenerIntervalo = false;
var toogle = false;  // variable que controla si esta minimizado o no el slide



/*RESTEAMOS VALORES DINAMICAMENTE con JS, los css*/
$('#slide ul li').css({
    'width': 100 / $('#slide ul li').length + "%"
});

$('#slide ul').css({
    'width': $('#slide ul li').length * 100 + "%"
});

/*================================
 * ANIMACION INICIAL
 * ===============================*/
$(imgProducto[item]).animate({
    "top": '-10%',
    "opacity": "0"
}, 100);

$(imgProducto[item]).animate({
    "top": '-30px',
    "opacity": "1"
}, 600);


$(titulos1[item]).animate({
    "top": '-10%',
    "opacity": "0"
}, 100);

$(titulos1[item]).animate({
    "top": '-30px',
    "opacity": "1"
}, 600);


$(titulos2[item]).animate({
    "top": '-10%',
    "opacity": "0"
}, 100);

$(titulos2[item]).animate({
    "top": '-30px',
    "opacity": "1"
}, 600);


$(titulos3[item]).animate({
    "top": '-10%',
    "opacity": "0"
}, 100);

$(titulos3[item]).animate({
    "top": '-30px',
    "opacity": "1"
}, 600);

$(btnVerProducto[item]).animate({
    "top": '-30px',
    "opacity": "1"
}, 600);


/*================================
 * PAGINACION
 * ===============================*/


$('#paginacion li').click(function () {
    //capturando el valor de item y le restamos -1 .
    // para que el al multiplicar por 100 quede bien
    item = $(this).attr("item") - 1;
    //console.log(item);

    movimientoSlide(item);

});


/*================================
 * AVANZAR
 * ===============================*/
$('#slide #avanzar').click(function () {
    avanzar();
});


//FUNCION AVANZAR
function avanzar() {
    //validamos la logica de avanzar
    //capturamos dinamicamente la cantidad de slide -1
    if (item == $('#slide ul li').length - 1) {
        item = 0;
    } else {
        item++;
    }
    movimientoSlide(item);
}


/*================================
 * RETROCEDER
 * ===============================*/

$('#slide #retroceder').click(function () {
    //validamos la logica de avanzar
    if (item == 0) {
        item = $('#slide ul li').length - 1;
    } else {
        item--;
    }
    movimientoSlide(item);

});


/*================================
 * MOVIMEIENTO DEL SLIDE
 * ===============================*/
function movimientoSlide(item) {

    //modificmoas el css, en vace al item que se sleccione
    $('#slide ul').animate({
        'left': (item * -100) + "%"
    }, 500, "easeOutQuart");  //la animacion easy, proviene de la libreria easey

    //cambiamos la opacidad a los bootnes ciruclistos
    $('#paginacion li').css({'opacity': '.5'});
    //dejamos solo sin opacticadad el item oprimido
    $(itemPaginacion[item]).css({'opacity': 1});

    interrumpirCiclo = true;


    //generando la animacion
    $(imgProducto[item]).animate({
        "top": '-10%',
        "opacity": "0"
    }, 100);

    $(imgProducto[item]).animate({
        "top": '-30px',
        "opacity": "1"
    }, 600);


    $(titulos1[item]).animate({
        "top": '-10%',
        "opacity": "0"
    }, 100);

    $(titulos1[item]).animate({
        "top": '-30px',
        "opacity": "1"
    }, 600);


    $(titulos2[item]).animate({
        "top": '-10%',
        "opacity": "0"
    }, 100);

    $(titulos2[item]).animate({
        "top": '-30px',
        "opacity": "1"
    }, 600);


    $(titulos3[item]).animate({
        "top": '-10%',
        "opacity": "0"
    }, 100);

    $(titulos3[item]).animate({
        "top": '-30px',
        "opacity": "1"
    }, 600);

    $(btnVerProducto[item]).animate({
        "top": '-30px',
        "opacity": "1"
    }, 600);

}


/*================================
 * INTERVALO DE TIEMPO
 * ===============================*/


setInterval(function () {

    //logica para que el intervlo ejecue la funcion solo si no se ha oprimido algun otro boton
    if (interrumpirCiclo) {
        interrumpirCiclo = false;
    } else {
        //solo si deterner intevarlo esta en falso que avance, es decir que no este el mouse sobre el slide
        if (detenerIntervalo == false) {
            avanzar();
        }
    }
}, 3000);


/*================================
 * APARECER FLECHAS
 * ===============================*/
$('#slide').mouseover(function () {
    $('#slide #retroceder').css({'opacity': 1});
    $('#slide #avanzar').css({'opacity': 1});

    detenerIntervalo = true;
});

$('#slide').mouseout(function () {
    $('#slide #retroceder').css({'opacity': 0});
    $('#slide #avanzar').css({'opacity': 0});

    detenerIntervalo = false;
});


/*================================
 * ESCONDER SLIDE
 * ===============================*/

$('#btnSlide').click(function () {
    if (!toogle) {
        toogle = true;
        $('#slide').slideUp("fast");
        $('#btnSlide').html('<i class="fa fa-angle-down"></i>');
    } else {
        toogle = false;
        $('#slide').slideDown("fast");
        $('#btnSlide').html('<i class="fa fa-angle-up"></i>');
    }
});

