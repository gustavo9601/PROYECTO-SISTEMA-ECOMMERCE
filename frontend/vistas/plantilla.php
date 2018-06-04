<?php

session_start();


$llamandoControlladorPlantilla = @ControladorPlantilla::ctrEstilosPlantilla();
$servidor = @Ruta::ctrRutaServidor();


/*=============================================
MANTENER LA RUTA FIJA DEL PROYECTO
=============================================*/
$url = @Ruta::ctrRuta();
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <!--Trabajar en diferentes disposivos-->
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">


    <link rel="icon" href="<?php echo $servidor . $llamandoControlladorPlantilla['icono']; ?>">

    <?php


    /*=============================================
    MARCADO DE CABECERAS
    =============================================*/

    $rutas = array();

    if(isset($_GET["ruta"])){

        $rutas = explode("/", $_GET["ruta"]);

        $ruta = $rutas[0];

    }else{

        $ruta = "inicio";

    }

    //TREAMOS LA INFORMACION DE CABECERAS
    $cabeceras = ControladorPlantilla::ctrTraerCabeceras($ruta);

    if(!$cabeceras["ruta"]){

        $ruta = "inicio";

        $cabeceras = ControladorPlantilla::ctrTraerCabeceras($ruta);

    }

    ?>


    <!--=====================================
Marcado HTML5
======================================-->

    <meta name="title" content="<?php echo  $cabeceras['titulo']; ?>">

    <meta name="description" content="<?php echo  $cabeceras['descripcion']; ?>">

    <meta name="keyword" content="<?php echo  $cabeceras['palabrasClaves']; ?>">

    <title><?php echo  $cabeceras['titulo']; ?></title>

    <!--=====================================
        Marcado de Open Graph FACEBOOK
        ======================================-->

    <meta property="og:title"   content="<?php echo $cabeceras['titulo'];?>">
    <meta property="og:url" content="<?php echo $url.$cabeceras['ruta'];?>">
    <meta property="og:description" content="<?php echo $cabeceras['descripcion'];?>">
    <meta property="og:image"  content="<?php echo $cabeceras['portada'];?>">
    <meta property="og:type"  content="website">
    <meta property="og:site_name" content="Tu logo">
    <meta property="og:locale" content="es_CO">

    <!--=====================================
    Marcado para DATOS ESTRUCTURADOS GOOGLE
    ======================================-->

    <meta itemprop="name" content="<?php echo $cabeceras['titulo'];?>">
    <meta itemprop="url" content="<?php echo $url.$cabeceras['ruta'];?>">
    <meta itemprop="description" content="<?php echo $cabeceras['descripcion'];?>">
    <meta itemprop="image" content="<?php echo $cabeceras['portada'];?>">

    <!--=====================================
    Marcado de TWITTER
    ======================================-->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?php echo $cabeceras['titulo'];?>">
    <meta name="twitter:url" content="<?php echo $url.$cabeceras['ruta'];?>">
    <meta name="twitter:description" content="<?php echo $cabeceras['descripcion'];?>">
    <meta name="twitter:image" content="<?php echo $cabeceras['portada'];?>">
    <meta name="twitter:site" content="@tu-usuario">
    <!--==================================
 PLUGINS DE CSS
 ======================================-->
    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plugins/bootstrap.min.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plugins/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plugins/flexslider.css">

    <!--Fuentes Google Fonts-->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu|Ubuntu+Condensed" rel="stylesheet">

    <!--==================================
    HOJAS DE ESTILO PERSONALIZADAS
    ======================================-->
    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plantilla.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/cabezote.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/slide.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/productos.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/infoproducto.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/perfil.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/carrito-de-compras.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/ofertas.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plugins/sweetalert.css">

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plugins/dscountdown.css">

    <!--==================================
 PLUGINS DE JAVASCRIPT
 ======================================-->
    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.min.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/bootstrap.min.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.easing.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.scrollUp.js"></script>


    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.flexslider.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/sweetalert.min.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/md5-min.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/dscountdown.min.js"></script>

    <!--Script necesario de libreria de GOOGLLE PARA COMPARTIR-->
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body>

<?php

/*=============================================
CABEZOTE
=============================================*/

include "modulos/cabezote.php";


/*=============================================
CONTENIDO DINÁMICO
=============================================*/


$rutas = array();
if (isset($_GET['ruta'])) {
    //alamacenamos en una variable, lo que venga por get
    //con explode cremoas una rray con cada uno de los parametros que venga por URL
    $rutas = explode('/', $_GET['ruta']);
    //var_dump($rutas);
    $ruta = null;
    $infoProducto = null;
    $item = "ruta";  //variabe get
    $valor = $rutas[0]; // valor de variable get, pero posicion 0 ya que lo alamcenamos en array rutas

    /*=============================================
     URLS AMIGABLES CATEGORIAS
     =============================================*/

    $rutasCategorias = ControladorProductos::ctrMostrarCategorias($item, $valor);
    //validacion por lo prmiero que s enecutnra en la url dato/

    //Si existe la ruta puesto en la URL, en la BD, almacenmos el valor de ruta
    if ($valor == $rutasCategorias['ruta']) {
        $ruta = $valor;
    }

    /*=============================================
     URLS AMIGABLES SUBCATEGORIAS
     =============================================*/
    $rutasSubcategorias = ControladorProductos::ctrMostrarSubCategorias($item, $valor);

    foreach ($rutasSubcategorias as $dato) {
        if ($valor == $dato['ruta']) {
            $ruta = $valor;
        }
    }


    /*=============================================
     URLS AMIGABLES PRODUCTOS
     =============================================*/
    $rutaProductos = ControladorProductos::ctrMostrarInfoProducto($item, $valor);

    /*var_dump($rutaProductos);
    */
    //condicional que valoda
    // -> lo que paso por URL, sea igual a la URL que tengo en la BD
    if ($rutas[0] == $rutaProductos['ruta']) {
        $infoProducto = $rutas[0];
    }

    /*=============================================
    LISTA BLANCA DE URL AMIGABLES
    =============================================*/
    // si se modifico el valor de ruta, mostrara productos, de lo contraripo error404
    if ($ruta != null || $rutas[0] == "articulos-gratis" || $rutas[0] == "lo-mas-vendido" || $rutas[0] == "lo-mas-visto") {
        include_once 'modulos/productos.php';

        //la varaible info producto se llena siempre y cando la url traiga un valor valido de ruta al comparalo con la ruta de lBD
    } else if ($infoProducto != null) {
        include "modulos/infoproducto.php";
    } else if ($rutas[0] == "buscador"
        || $rutas[0] == 'verificar'
        || $rutas[0] == 'salir'
        || $rutas[0] == 'perfil'
        || $rutas[0] == 'carrito-de-compras'
        || $rutas[0] == 'error'
        || $rutas[0] == 'finalizar-compra'
        || $rutas[0] == 'curso'
        || $rutas[0] == 'ofertas'
        || $rutas[0] == 'cancelado'
    ) {
        include_once 'modulos/' . $rutas[0] . '.php';
    } else if($rutas[0] == "inicio"){
        //Si no vienen variables get incluimos el modulo del slide
        include "modulos/slide.php";
        //incluyendo el modulo de articulos destacados
        include "modulos/destacados.php";
    } else {
        include_once 'modulos/error404.php';
    }
} else {
    //Si no vienen variables get incluimos el modulo del slide
    include "modulos/slide.php";
    //incluyendo el modulo de articulos destacados
    include "modulos/destacados.php";
}
?>


<input type="hidden" name="" value="<?php echo $url; ?>" id="rutaOculta">

<!--==================================
JAVASCRIPT PERSONALIZADOS
======================================-->

<script src="<?php echo $url; ?>vistas/js/plantilla.js"></script>
<script src="<?php echo $url; ?>vistas/js/cabezote.js"></script>
<script src="<?php echo $url; ?>vistas/js/slide.js"></script>
<script src="<?php echo $url; ?>vistas/js/buscador.js"></script>
<script src="<?php echo $url; ?>vistas/js/infoproducto.js"></script>
<script src="<?php echo $url; ?>vistas/js/usuarios.js"></script>
<script src="<?php echo $url; ?>vistas/js/registroFacebook.js"></script>
<script src="<?php echo $url; ?>vistas/js/carrito-de-compras.js"></script>


<!--=====================================
https://developers.facebook.com/
======================================-->
<script>


    window.fbAsyncInit = function () {
        FB.init({
            appId: '171275970307432',
            cookie: true,
            xfbml: true,
            version: 'v2.11'
        });

        FB.AppEvents.logPageView();

    };

    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {
            return;
        }
        js = d.createElement(s);
        js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));


    /*=============================================
     COMPARTIR EN FACEBOOK
     https://developers.facebook.com/docs/
     =============================================*/


    //tomamos la informacion del api, actual del id
    $(".btnFacebook").click(function(){

        FB.ui({

            method: 'share',
            display: 'popup',
            href: '<?php  echo $url.$cabeceras["ruta"];  ?>',
        }, function(response){});

    })



    /*=============================================
     COMPARTIR EN GOOGLE
     https://developers.google.com/+/web/share/
     =============================================*/

    $(".btnGoogle").click(function(){

        //window.open -> evento propio del navegadoor que abre un pop up
        window.open(

            'https://plus.google.com/share?url=<?php  echo $url.$cabeceras["ruta"];  ?>',
            '',
            'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=500,width=400'
        );

        return false;

    })

</script>





</body>
</html>