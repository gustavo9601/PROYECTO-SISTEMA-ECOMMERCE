/*=============================================
 CARRUSEL
 =============================================*/


//varaible que trae toda la rua del servidor
//var rutaOculta = $('#rutaOculta').val();  // la variabl eya esta creada en un archivo superor


$(".flexslider").flexslider({

    animation: "slide",
    controlNav: true,
    animationLoop: false,
    slideshow: false,
    itemWidth: 100,
    itemMargin: 5

});


//evento click sobre los productos para que se visualicen grandes
$(".flexslider ul li img").click(function () {


    var capturaIndice = $(this).attr('value');

    //cambio de imagenes en el slide a la imagen grande
    $(".infoproducto figure.visor img").hide();
    $('#lupa' + capturaIndice).show();

});


/*=============================================
 EFECTO LUPA
 =============================================*/
//capturando el evento de movimiento sobre la imagen grande
$(".infoproducto figure.visor img").mouseover(function () {
    var capturaImg = $(this).attr("src"); // capturo la imagen

    $('.lupa img').attr("src", capturaImg);
    $('.lupa').fadeIn("fast");
    console.log(capturaImg);


    $('.lupa').css({
        "height": $("visorImg").height() + "px",
        "width": "100%"
    });

});

$(".infoproducto figure.visor img").mouseout(function () {

    $('.lupa').fadeOut("fast");
});

$(".infoproducto figure.visor img").mousemove(function (event) {
    //capturamos la posicion del mouse sobre la imagen frande al hacer hover
    var posX = event.offsetX;
    var posY = event.offsetY;

    $('.lupa img').css({
        "margin-left": -posX + "px",
        "margin-top": -posY + "px   "
    });

});


/*=============================================
 CONTADOR DE VISTAS
 =============================================*/
//usamos la funcion load, para que inmediatemnete cargue el dom, ejecute esa funcion
var contador = 0;
$(window).on("load", function () {
    var vistas = $('span.vistas').html();
    var tipo = $('span.vistas').attr('tipo');  // captura el atributo tipo que contiene el precio del articulo
    var item = ""; // variable que decidira que columan de la bd actualizar
    //console.log("cantidad de vistas ", vistas);
    console.log("tipo ", tipo);
    contador = Number(vistas) + 1;

    //modificamos en la vista el contador
    $('span.vistas').html(contador);

    //evaluamos el precio para definir campo a actualziar
    if (tipo == 0) {
        item = "vistasGratis";
    } else {
        item = "vistas";
    }

    //evalamos la ruta para definir el producto a actualzizar
    var urlActual = location.pathname;
    //console.log(urlActual);
    var ruta = urlActual.split('/'); // separamos la url capturada, separada por /


    var datos = new FormData();
    datos.append('valor', contador);
    datos.append('item', item);
    datos.append('ruta', ruta.pop()); // array.pop() // devuelve la ultima posicion del un array

    //peticion ajax
    $.ajax({
        url: rutaOculta + "ajax/producto.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            //console.log("respuesta ", respuesta);
        }
    });

});


/*=============================================
 ALTURA COMENTARIOS
 =============================================*/


//definimos una altura fija, para msotrar solo 4 columas y 1 fila, para que al precionar ver as se desplieuge el resto
$('.comentarios').css({
    "hegiht": $('.comentarios .alturaComentarios').height() + 'px',
    "overflow": 'hidden',
    "margin-bottom": '20px'
});

//click en btn ver mas
$('#verMas').click(function (e) {

    e.preventDefault();

    if ($('#verMas').html() == 'VER MAS') {
        //mostramos el resto
        $('.comentarios').css({
            "overflow": 'inherit'
        })

        //cambiamos el texto
        $('#verMas').html('VER MENOS');
    } else {

        //reseteamos los cambios
        $('.comentarios').css({
            "hegiht": $('.comentarios .alturaComentarios').height() + 'px',
            "overflow": 'hidden',
            "margin-bottom": '20px'
        });


        //cambiamos el texto
        $('#verMas').html('VER MAS');


    }

});