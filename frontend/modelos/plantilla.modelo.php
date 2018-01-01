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
}