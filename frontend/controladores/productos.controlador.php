<?php

class ControladorProductos
{

    /*=============================================
    MOSTRAR CATEGORÍAS
    =============================================*/

    static public function ctrMostrarCategorias($item, $valor)
    {

        $tabla = "categorias";

        $respuesta = ModeloProductos::mdlMostrarCategorias($tabla, $item, $valor);

        return $respuesta;

    }

    /*=============================================
    MOSTRAR SUBCATEGORÍAS
    =============================================*/

    static public function ctrMostrarSubCategorias($item, $valor)
    {

        $tabla = "subcategorias";
        $respuesta = ModeloProductos::mdlMostrarSubCategorias($tabla, $item, $valor);

        return $respuesta;

    }


    /*=============================================
    MOSTRA PRODUCTOS
    =============================================*/
    static public function ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo)
    {
        $tabla = "productos";

        $respuesta = ModeloProductos::mdlMostrarProductos($tabla, $ordenar, $item, $valor, $base, $tope, $modo);

        return $respuesta;
    }


    /*=============================================
        MOSTRA INFO PRODUCTO
        =============================================*/

    static public function ctrMostrarInfoProducto($item, $valor)
    {
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlMostrarInfoProducto($tabla, $item, $valor);

        return $respuesta;
    }


    /*=============================================
       LISTRAR PRODUCTOS
        =============================================*/
    static public function ctrListarProductos($ordenar, $item, $valor)
    {
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlListarProductos($tabla, $ordenar, $item, $valor);

        return $respuesta;
    }

    /*=============================================
       MOSTRAR BANNER
        =============================================*/
    static public function ctrMostrarBanner($ruta)
    {

        $tabla = "banner";
        $respuesta = ModeloProductos::mdlMostrarBanner($tabla, $ruta);

        return $respuesta;
    }


    /*=============================================
         MOSTRAR BUSCADOR
          =============================================*/
    static public function ctrBuscarProductos($busqueda, $ordenar, $modo, $base, $tope)
    {

        $tabla = 'productos';
        $respuesta = ModeloProductos::mdlBuscarProductos($tabla, $busqueda, $ordenar, $modo, $base, $tope);

        return $respuesta;

    }


    /*=============================================
       LISTAR PRODUCTOS BUSQUEDA
        =============================================*/
    static public function ctrListarProductosBusqueda($busqueda)
    {

        $tabla = 'productos';
        $respuesta = ModeloProductos::mdlListarProductosBusqueda($tabla, $busqueda);

        return $respuesta;

    }


    /*=============================================
       ACTUALIZAR VISTA PRODUCTO
        =============================================*/

    static public function ctrActualizarVistaProducto($datos, $item)
    {
        $tabla = "productos";
        $respuesta = ModeloProductos::mdlActualizarVistaProducto($tabla, $datos, $item);

        return $respuesta;
    }

}