<?php

session_start();


$llamandoControlladorPlantilla = @ControladorPlantilla::ctrEstilosPlantilla();
$servidor = @Ruta::ctrRutaServidor();
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <!--Trabajar en diferentes disposivos-->
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!--Titulo-->
    <meta name="title" content="Tienda Virtual">
    <!--Descripcion de la pagina-->
    <meta name="description"
          content="Pagina de compras">
    <!--Descripcion Keywords-->
    <meta name="keyword"
          content="Lorem ipsum, dolor sit amet, consectetur, adipisicing, elit, Quisquam, accusantium, enim, esse">

    <title>Tienda Virtual</title>

    <link rel="icon" href="<?php echo $servidor . $llamandoControlladorPlantilla['icono']; ?>">
    <?php


    /*=============================================
    MANTENER LA RUTA FIJA DEL PROYECTO
    =============================================*/

    $url = @Ruta::ctrRuta();

    ?>

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

    <link rel="stylesheet" href="<?php echo $url; ?>vistas/css/plugins/sweetalert.css">

    <!--==================================
 PLUGINS DE JAVASCRIPT
 ======================================-->
    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.min.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/bootstrap.min.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.easing.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.scrollUp.js"></script>


    <script src="<?php echo $url; ?>vistas/js/plugins/jquery.flexslider.js"></script>

    <script src="<?php echo $url; ?>vistas/js/plugins/sweetalert.min.js"></script>

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
    ) {
        include_once 'modulos/' . $rutas[0] . '.php';
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
</script>


</body>
</html>