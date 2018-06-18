<?php

class ControladorProductos{

	/*=============================================
	MOSTRAR TOTAL PRODUCTOS
	=============================================*/

	static public function ctrMostrarTotalProductos($orden){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarTotalProductos($tabla, $orden);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR SUMA VENTAS
	=============================================*/

	static public function ctrMostrarSumaVentas(){

		$tabla = "productos";

		$respuesta = ModeloProductos::mdlMostrarSumaVentas($tabla);

		return $respuesta;

	}


}