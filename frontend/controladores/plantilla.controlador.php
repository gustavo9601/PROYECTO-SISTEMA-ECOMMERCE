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
}