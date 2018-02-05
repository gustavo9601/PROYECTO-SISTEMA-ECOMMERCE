<?php

//requeriendo el controlador del carrito de compras

require_once '../extensiones/paypal.controlador.php';

class AjaxCarrito
{
    /*=============================================
 MÉTODO PAYPAL
 =============================================*/

    public $divisa;
    public $total;
    public $impuesto;
    public $envio;
    public $subtotal;
    public $tituloArray;
    public $cantidadArray;
    public $valorItemArray;
    public $idProductoArray;

    public function ajaxEnviarPaypal()
    {

        $datos = array(
            "divisa" => $this->divisa,
            "total" => $this->total,
            "impuesto" => $this->impuesto,
            "envio" => $this->envio,
            "subtotal" => $this->subtotal,
            "tituloArray" => $this->tituloArray,
            "cantidadArray" => $this->cantidadArray,
            "valorItemArray" => $this->valorItemArray,
            "idProductoArray" => $this->idProductoArray,
        );

        $respuesta = Paypal::mdlPagoPaypal($datos);

        echo $respuesta;

    }


}


/*=============================================
MÉTODO PAYPAL
=============================================*/

if (isset($_POST["divisa"])) {

    $paypal = new AjaxCarrito();
    $paypal->divisa = $_POST["divisa"];
    $paypal->total = $_POST["total"];
    $paypal->impuesto = $_POST["impuesto"];
    $paypal->envio = $_POST["envio"];
    $paypal->subtotal = $_POST["subtotal"];
    $paypal->tituloArray = $_POST["tituloArray"];
    $paypal->cantidadArray = $_POST["cantidadArray"];
    $paypal->valorItemArray = $_POST["valorItemArray"];
    $paypal->idProductoArray = $_POST["idProductoArray"];
    $paypal->ajaxEnviarPaypal();


}


?>