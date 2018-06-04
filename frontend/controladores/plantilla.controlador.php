<?php


class ControladorPlantilla
{

    /*=============================================
    LLAMAMOS LA PLANTILLA
    =============================================*/
    public function plantilla()
    {
        include "vistas/plantilla.php";
    }

    /*=============================================
      TRAEMOS LOS ESTILOS DINAMICOS
        =============================================*/
    //ctr -> controlador
    public function ctrEstilosPlantilla()
    {
        $tabla = "plantilla";
        $respuesta = ModeloPantilla::mdlEstiloPlantilla($tabla);
        return $respuesta;
    }


    /*=============================================
    TRAEMOS LAS CABECERAS
    =============================================*/

     static public function ctrTraerCabeceras($ruta){

        $tabla = "cabeceras";

        $respuesta =  ModeloPantilla::mdlTraerCabeceras($tabla, $ruta);

        return $respuesta;

    }

}