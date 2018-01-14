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


    /*=============================================
    REGISTRO CON FACEBOOK
    =============================================*/
    public $email;
    public $nombre;
    public $foto;

    public function ajaxRegistroFacebook()
    {
        $datos = [
            'nombre' => $this->nombre,
            'email' => $this->email,
            'foto' => $this->foto,
            'modo' => 'facebook',
            'password' => 'null',
            'verificacion' => 0,
            'emailEncriptado' => 'null'
        ];

        $respuesta = ControladorUsuarios::ctrRegistroRedesSociales($datos);

        echo $respuesta;

    }

}

/*=============================================
VALIDAR EMAIL EXISTENTE
=============================================*/
if (@$_POST['validarEmail']) {
    $a = new AjaxUsuario();
    $a->validarEmail = $_POST['validarEmail'];
    $a->ajaxValidarEmail();
}

/*=============================================
REGISTRO CON FACEBOOK
=============================================*/
if (@$_POST['email']) {
    $regFacebook = new AjaxUsuario();
    $regFacebook->email = $_POST['email'];
    $regFacebook->nombre = $_POST['nombre'];
    $regFacebook->foto = $_POST['foto'];
    $regFacebook->ajaxRegistroFacebook();
}
