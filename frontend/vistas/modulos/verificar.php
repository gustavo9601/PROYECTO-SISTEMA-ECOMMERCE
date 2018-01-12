<!--==============================================-->
<!--VERFICAR-->
<!--==============================================-->

<?php
//Capturamos el parametro de email encriptado
$url = @Ruta::ctrRuta();
$valor = $rutas[1];
$item = "emailEncriptado";

//invocando al controlador
$respuesta = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

$id = $respuesta["id"];
$item2 = "verificacion";
$valor2 = 0;

$respuesta2 = ControladorUsuarios::ctrActualizarUsuario($id, $item2, $valor2);

$usuarioVerificado = false;
if ($respuesta2 == 'ok') {

    $usuarioVerificado = true;
}

?>

<div class="container">
    <div class="row">
        <div class="col-xs-12 text-center verificar">
            <?php

            if ($usuarioVerificado) {
                echo '<h3>Gracias</h3>
                    <h2><small>!Hemos verificado su correo electronico, puede ingresar al sistema¡</small></h2>
                    <br>
                    <a href="#modalIngreso" data-toggle="modal">
                        <button class="btn btn-default backColor btn-lg">INGRESAR</button>
                    </a>
                ';
            }else{
                echo '<h3>Error</h3>
                    <h2><small>!No se ha podido verificar el correo electronico, vuelva a registrase¡</small></h2>
                    <br>
                    <a href="#modalRegistro" data-toggle="modal">
                        <button class="btn btn-default backColor btn-lg">INGRESAR</button>
                    </a>';
            }

            ?>

        </div>

    </div>
</div>