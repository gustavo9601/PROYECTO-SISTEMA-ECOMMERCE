<?php

/*Archivo que recibira las variables que nos devuelva el paypal*/

$url = @Ruta::ctrRuta();


//validacion de sesion
if (!isset($_SESSION["validarSesion"])) {

    echo '<script>window.location = "' . $url . '";</script>';

    exit();

}


#requerimos las credenciales de paypal
require 'extensiones/bootstrap.php';
//importamos el archivo de datos con la BD
require_once 'modelos/carrito.modelo.php';


#importamos librería del SDK
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;


/*=============================================
PAGO PAYPAL
=============================================*/

#evaluamos si la compra está aprobada
//validamos que si recibvamos la variable de paypal
if (isset($_GET['paypal']) && $_GET['paypal'] === 'true') {

    #recibo los productos comprados
    //creamos los array de cada proudcto y cantidad que recibo
    $productos = explode("-", $_GET['productos']);
    $cantidad = explode("-", $_GET['cantidad']);

    #capturamos el Id del pago que arroja Paypal
    $paymentId = $_GET['paymentId'];


    #Creamos un objeto de Payment para confirmar que las credenciales si tengan el Id de pago resuelto
    $payment = Payment::get($paymentId, $apiContext);

    #creamos la ejecución de pago, invocando la clase PaymentExecution() y extraemos el id del pagador
    $execution = new PaymentExecution(); // creamos un objeto de ejecucion de pago
    $execution->setPayerId($_GET['PayerID']); // le pasamos el ID del pagador


    #validamos con las credenciales que el id del pagador si coincida
    $payment->execute($execution, $apiContext);

    //Toma de datos en variables
    $datosTransaccion = $payment->toJSON();


    $datosUsuario = json_decode($datosTransaccion); // decodificamos el json que nos devuelve
    //informacion de la cuenta de Paypal
    $emailComprador = $datosUsuario->payer->payer_info->email;
    $dir = $datosUsuario->payer->payer_info->shipping_address->line1;
    $ciudad = $datosUsuario->payer->payer_info->shipping_address->city;
    $estado = $datosUsuario->payer->payer_info->shipping_address->state;
    $codigoPostal = $datosUsuario->payer->payer_info->shipping_address->postal_code;
    $pais = $datosUsuario->payer->payer_info->shipping_address->country_code;
    $direccion = $dir . ", " . $ciudad . ", " . $estado . ", " . $codigoPostal;

#Actualizamos la base de datos
    for ($i = 0; $i < count($productos); $i++) {

        //array de datos para enviar a la BD
        $datos = array("idUsuario" => $_SESSION["id"],
            "idProducto" => $productos[$i],
            "metodo" => "paypal",
            "email" => $emailComprador,
            "direccion" => $direccion,
            "pais" => $pais);

        $respuesta = ControladorCarrito::ctrNuevasCompras($datos);


        //trayendo informacion del los productos
        $ordenar = "id";
        $item = "id";
        $valor = $productos[$i];
        $productosCompra = @ControladorProductos::ctrListarProductos($ordenar, $item, $valor);
        $actualizarCompra = "";
        foreach ($productosCompra as $key => $value) {

            $item1 = "ventas";
            $valor1 = $value["ventas"] + $cantidad[$i];  // incrementando las ventas al proudcto de acuerdo a la cantidad pasada por parametro
            $item2 = "id";
            $valor2 = $value["id"];
            //actualizamos la cantidad de ventas que ha tenido el producto
            $actualizarCompra = @ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);

        }


        //si la inserciiomn viene OK
        if ($respuesta == "ok" && $actualizarCompra == "ok") {

            //limpiamos los elemento que hayan en local storage para que no le aparesca nada en el carrito de comrpas
            echo '<script>

				localStorage.removeItem("listaProductos");
				localStorage.removeItem("cantidadCesta");
				localStorage.removeItem("sumaCesta");
				window.location = "' . $url . 'perfil";

   			</script>';

        }


    }

    /*=============================================
    PAGO PAYU
    =============================================*/
} else if (isset($_GET['payu']) && $_GET['payu'] === 'true') {

    $respuesta = ControladorCarrito::ctrMostrarTarifas();

    $ApiKey = $respuesta["apiKeyPayu"];  // TRAEMOS LA INFO DEL API KEY
    $merchant_id = $_REQUEST['merchantId'];
    $referenceCode = $_REQUEST['referenceCode'];
    $TX_VALUE = $_REQUEST['TX_VALUE'];
    $New_value = number_format($TX_VALUE, 1, '.', '');
    $currency = $_REQUEST['currency'];
    $transactionState = $_REQUEST['transactionState'];
    $firma_cadena = "$ApiKey~$merchant_id~$referenceCode~$New_value~$currency~$transactionState";
    $firmacreada = md5($firma_cadena);
    $firma = $_REQUEST['signature'];
    $reference_pol = $_REQUEST['reference_pol'];
    $cus = $_REQUEST['cus'];
    $extra1 = $_REQUEST['description'];
    $pseBank = $_REQUEST['pseBank'];
    $lapPaymentMethod = $_REQUEST['lapPaymentMethod'];
    $transactionId = $_REQUEST['transactionId'];


    if ($_REQUEST['transactionState'] == 4) {
        $estadoTx = "Transacción aprobada";
    } else if ($_REQUEST['transactionState'] == 6) {
        $estadoTx = "Transacción rechazada";
    } else if ($_REQUEST['transactionState'] == 104) {
        $estadoTx = "Error";
    } else if ($_REQUEST['transactionState'] == 7) {
        $estadoTx = "Transacción pendiente";
    } else {
        $estadoTx = $_REQUEST['mensaje'];
    }


    //Si se cumple todo, actualizaremos la base de datos
    if (strtoupper($firma) == strtoupper($firmacreada) && $estadoTx == "Transacción aprobada") {
        //separacion de los productos con guin a array
        $productos = explode("-", $_GET['productos']);
        $cantidad = explode("-", $_GET['cantidad']);

        #Actualizamos la base de datos
        for ($i = 0; $i < count($productos); $i++) {

            //creamos el array de datos
            $datos = array("idUsuario" => $_SESSION["id"],
                "idProducto" => $productos[$i],
                "metodo" => "payu",
                "email" => $_REQUEST['buyerEmail'],
                "direccion" => "",  // por ahora no tenemos la direccion, ya que se tendra cuando salga a produccion publico
                "pais" => "");  // por ahora tampoco esta pais, pero cuando recibamos la informacion de confirmacion si contendra la informacion

            $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

            $ordenar = "id";
            $item = "id";
            $valor = $productos[$i];

            $productosCompra = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

            foreach ($productosCompra as $key => $value) {

                $item1 = "ventas";
                $valor1 = $value["ventas"] + $cantidad[$i];
                $item2 = "id";
                $valor2 = $value["id"];

                $actualizarCompra = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);

            }


            //Removemos la informacion del localstorage ya que ya se ejecuto la compral
            if ($respuesta == "ok" && $actualizarCompra == "ok") {

                echo '<script>

            localStorage.removeItem("listaProductos");
            localStorage.removeItem("cantidadCesta");
            localStorage.removeItem("sumaCesta");
            window.location = "' . $url . 'perfil";

            </script>';

            }

        }
    }

} /*=============================================
ADQUISICIONES GRATUITAS
=============================================*/
else if(isset($_GET['gratis']) && $_GET['gratis'] == 'true') {


    $producto = $_GET['producto'];
    $titulo = $_GET['titulo'];

    $datos = array(  "idUsuario"=>$_SESSION["id"],
        "idProducto"=>$producto,
        "metodo"=>"gratis",
        "email"=>$_SESSION["email"],
        "direccion"=>"",
        "pais"=>"");

    $respuesta = ControladorCarrito::ctrNuevasCompras($datos);

    $ordenar = "id";
    $item = "id";
    $valor = $producto;

    $productosGratis = ControladorProductos::ctrListarProductos($ordenar, $item, $valor);

    foreach ($productosGratis as $key => $value) {

        $item1 = "ventasGratis";
        $valor1 = $value["ventasGratis"] + 1;
        $item2 = "id";
        $valor2 =$value["id"];

        $actualizarSolicitud = ControladorProductos::ctrActualizarProducto($item1, $valor1, $item2, $valor2);
    }

    if($respuesta == "ok" && $actualizarSolicitud == "ok"){

        echo '<script>
         
            window.location = "'.$url.'ofertas/aviso";

         </script>';

    }


}else{

    echo '<script>window.location = "'.$url.'cancelado";</script>';
}

?>

