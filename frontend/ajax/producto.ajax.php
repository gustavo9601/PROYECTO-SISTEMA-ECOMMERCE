<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxProductos
{

    public $valor;
    public $item;
    public $ruta;

    public function ajaxVistaProducto()
    {
        $item1 = $this->item;
        $valor1 = $this->valor;

        $item2 = "ruta";
        $valor2 = $this->ruta;

        $respuesta = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);

        echo $respuesta;
    }
}

//si viene alguna variable post valor,
if (isset($_POST['valor'])) {

    $vista = new AjaxProductos();
    $vista->valor = $_POST['valor'];
    $vista->item = $_POST['item'];
    $vista->ruta = $_POST['ruta'];
    $vista->ajaxVistaProducto();
}


