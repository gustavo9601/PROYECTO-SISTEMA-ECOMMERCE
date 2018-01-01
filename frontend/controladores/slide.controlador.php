<?php

class ControladorSlide
{

    static public function ctrMostrarSlide()
    {
        $tabla = "slide";
        $respuesta = ModeloSlide::mdlMostrarSlide($tabla);
        return $respuesta;
    }

}

?>