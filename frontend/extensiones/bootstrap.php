<?php

//importamos el autoload
require __DIR__ . '/vendor/autoload.php';



//usando las dependencias propias del api
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;


//Vamos a traer la informacion de comercio de la BD
$tabla = "comercio";
$respuesta = ModeloCarrito::mdlMostrarTarifas($tabla);



//alcenando en varaibles la informacion que nos traiga la BD
$clienteIdPaypal = $respuesta["clienteIdPaypal"];
$llaveSecretaPaypal = $respuesta["llaveSecretaPaypal"];
$modoPaypal = $respuesta["modoPaypal"];

//Creando el Objeto Contexto de Paypal
$apiContext = new ApiContext(

    new OAuthTokenCredential(

        $clienteIdPaypal,
        $llaveSecretaPaypal

    )
);

//Modificando las configuraciones basicas de esta api
$apiContext->setConfig(
    array(
        'mode' => $modoPaypal,
        'log.LogEnabled' => true,
        'log.FileName' => '../PayPal.log',
        'log.LogLevel' => 'DEBUG',
        'http.CURLOPT_CONNECTTIMEOUT' => 30
    )
);


?>