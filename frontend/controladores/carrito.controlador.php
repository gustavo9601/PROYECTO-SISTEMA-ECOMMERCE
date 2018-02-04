<?php

class ControladorCarrito
{

    /*=======================================
    MOSTRAR TARIFAS
    ========================================*/
    static public function ctrMostrarTarifas()
    {
        $tabla = 'comercio';

        $respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);

        return $respuesta;
    }


}


?>