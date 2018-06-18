<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR EL TOTAL DE USUARIOS
	=============================================*/	

	static public function mdlMostrarTotalUsuarios($tabla, $orden){
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY $orden DESC");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt-> close();

		$stmt = null;

	}

}