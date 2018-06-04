<?php

require_once 'conexion.php';

class ModeloPantilla
{
    //mdl -> Modelo
    static public function mdlEstiloPlantilla($tabla)
    {
        $conexion = @Conexion::conectar();
        $sql = "SELECT * FROM $tabla";
        $stament = $conexion->prepare($sql);
        $stament->execute();
        return $stament->fetch(); //retornamos una sola linea
        $stament->close();
    }


    /*=============================================
    TRAEMOS LAS CABECERAS
    =============================================*/

    static public function mdlTraerCabeceras($tabla, $ruta){

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ruta = :ruta");

        $stmt -> bindParam(":ruta", $ruta, PDO::PARAM_STR);

        $stmt -> execute();

        return $stmt -> fetch();

        $stmt -> close();

        $stmt = null;

    }


}