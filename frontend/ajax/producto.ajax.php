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
        $datos = [
            'valor' => $this->valor,
            'item' => $this->item,
            'ruta' => $this->ruta
        ];
        //le pasamos el array de esta forma par aqu eno genere inconvenietes con el sql
        $respuesta = @ControladorProductos::ctrActualizarVistaProducto($datos, $datos['item']);
        //devolvemos un Json que entienda javascript, de array -> string
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


