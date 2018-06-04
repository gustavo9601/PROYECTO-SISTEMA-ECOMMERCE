/*=============================================
 PLANTILLA
 =============================================*/

//varaible que trae toda la rua del servidor
var rutaOculta = $('#rutaOculta').val();

$.ajax({
//Realizamo la peticion , odne traera la informacion y cambiara las clases de css
    url: rutaOculta + "ajax/plantilla.ajax.php",
    success: function (respuesta) {
        console.log(JSON.parse(respuesta));
        //JSON.parse(variable).indice //conversitmos la variable a json legible
        var colorFondo = JSON.parse(respuesta).colorFondo;
        var colorTexto = JSON.parse(respuesta).colorTexto;
        var barraSuperior = JSON.parse(respuesta).barraSuperior;
        var textoSuperior = JSON.parse(respuesta).textoSuperior;

        $(".backColor, .backColor a").css({
            "background": colorFondo,
            "color": colorTexto
        })

        $(".barraSuperior, .barraSuperior a").css({
            "background": barraSuperior,
            "color": textoSuperior
        })
    }

})


/*=============================================
 CUADRICULA O LISTA EN LOS PRODUCTOS
 =============================================*/
var btnList = $('.btnList');

console.log(btnList.length);

for (var i = 0; i < btnList.length; i++) {
    $('#btnGrid' + i).click(function () {
        //capturamos el id oprimido, y con substr le capturamos el ultimo valor, que seria el numero
        var numero = $(this).attr('id').substr(-1);
        $('.list' + numero).hide();
        $('.grid' + numero).show();
        //le damos color al boton oprimido y al otro le quitamos la clase
        $('#btnList' + numero).removeClass("backColor");
        $('#btnGrid' + numero).addClass("backColor");
    });
    $('#btnList' + i).click(function () {
        //capturamos el id oprimido, y con substr le capturamos el ultimo valor, que seria el numero
        var numero = $(this).attr('id').substr(-1);
        $('.list' + numero).show();
        $('.grid' + numero).hide();
        //le damos color al boton oprimido y al otro le quitamos la clase
        $('#btnGrid' + numero).removeClass("backColor");
        $('#btnList' + numero).addClass("backColor");
    });
}


/*=============================================
 EFECTOS CON EL SCROLL
 =============================================*/
//capturamos el evento de scroll sobre el documento
$(window).scroll(function () {
    //capturamos la posicion sobre el eje Y, al mover con scroll
    var scrollY = window.pageYOffset;
    //console.log(scrollY);

    //validamos el tamaño de la pantalla. y solo se ejecutara si es mayor a 768px
    if (window.matchMedia("(min-width:768px)").matches) {

        //validamo que si exista el banner, para evitar que tire error en las otras interfaces
        if ($(".banner").html() != null) {
            //validamos si el scroll es < a la pisicion de arriba del banner
            if (scrollY < ($('.banner').offset().top - 200)) {
                $(".banner img").css({
                    "margin-top": -scrollY / 2 + "px"
                });
            } else {
                scrollY = 0;
            }
        }
    }
});

/*=============================================
 SCROLL UP, activando el pluggin
 =============================================*/
$.scrollUp({
    scrollText: "",
    scrollSpeed: "2000",
    easingType: "easeOutQuint"
});


/*=============================================
 CONFIGURANDO TOOLTIP
 =============================================*/
$('[data-toggle="tooltip"]').tooltip();


/*=============================================
 MIGAS DE PAN
 =============================================*/
var pagActiva = $('.paginaActiva').html();
if (pagActiva != null) {
    //quitamos los guines, y los remplazamos por un espacio, usabdo una exprecion regular
    var regPagActiva = pagActiva.replace(/-/g, " ");
    $('.paginaActiva').html(regPagActiva);
}

/*=============================================
 ENLACES PAGINACION
 =============================================*/

//capturando la url donde me encuentro
var url = window.location.href;

//convertimos a array la url
var indice = url.split("/");

console.log(url);
console.log(indice);

//si es diferente a un numeral aplique la clase

//.pop();  -> devuelve el valor de la ultima pocicion
$("#item" + indice.pop()).addClass('active');  //coloreamos el enlace activo
console.log(indice.pop());



/*=============================================
 OFERTAS
 =============================================*/

//eliminado el jumbotron de ofertas
$(".cerrarOfertas").click(function(){

    $(this).parent().remove();

})
