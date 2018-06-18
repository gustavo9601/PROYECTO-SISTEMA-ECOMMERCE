<?php

class ControladorUsuarios{

	/*=============================================
	MOSTRAR TOTAL USUARIOS
	=============================================*/

	static public function ctrMostrarTotalUsuarios($orden){

		$tabla = "usuarios";

		$respuesta = ModeloUsuarios::mdlMostrarTotalUsuarios($tabla, $orden);

		return $respuesta;

	}

}