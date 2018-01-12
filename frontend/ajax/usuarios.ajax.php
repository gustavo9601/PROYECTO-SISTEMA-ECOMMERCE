<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class AjaxUsuario
{
    /*=============================================
	VALIDAR EMAIL EXISTENTE
	=============================================*/

    public $validarEmail;

    public function ajaxValidarEmail()
    {
        $datos = $this->validarEmail;

        $respuesta = ControladorUsuarios::ctrMostrarUsuario("email", $datos);

        echo json_encode($respuesta);

    }
}

/*=============================================
VALIDAR EMAIL EXISTENTE
=============================================*/
if ($_POST['validarEmail']) {
    $a = new AjaxUsuario();
    $a->validarEmail = $_POST['validarEmail'];
    $a->ajaxValidarEmail();
}


