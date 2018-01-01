/*=============================================
 CARRUSEL
 =============================================*/

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
