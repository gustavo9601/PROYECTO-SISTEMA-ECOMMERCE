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


    /*=============================================
        NUEVAS COMPRAS
        =============================================*/

    static public function ctrNuevasCompras($datos)
    {

        $tabla = "compras";

        $respuesta = ModeloCarrito::mdlNuevasCompras($tabla, $datos);

        return $respuesta;

    }
}


?>