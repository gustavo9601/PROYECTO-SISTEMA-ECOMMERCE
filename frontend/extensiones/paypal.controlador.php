<?php
require_once "../modelos/rutas.php";
require_once "../modelos/carrito.modelo.php";


//importando todas los spacemnt de Paypal
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


class Paypal
{

    static public function mdlPagoPaypal($datos)
    {

        //requeriendo la configuracion base de paypal
        require __DIR__ . '/bootstrap.php';

        /*echo '<pre>';
        print_r($datos);
        echo '<pre>';*/

        //Separammos los string separados por coma, para convertirlos en array
        $tituloArray = explode(",", $datos["tituloArray"]);
        $cantidadArray = explode(",", $datos["cantidadArray"]);
        $valorItemArray = explode(",", $datos["valorItemArray"]);
        //reemplazamos las comas por un guion
        $idProductos = str_replace(",", "-", $datos["idProductoArray"]);
        $cantidadProductos = str_replace(",", "-", $datos["cantidadArray"]);


        #Seleccionamos el método de pago
        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        //Creamos los item dinamicamente
        $item = array();
        $variosItem = array();

        //recorremos de acuerdo a la cantidad de items que vengan crear un item dinamico
        for ($i = 0; $i < count($tituloArray); $i++) {

            $item[$i] = new Item();
            $item[$i]->setName($tituloArray[$i])
                ->setCurrency($datos["divisa"])
                ->setQuantity($cantidadArray[$i])
                ->setPrice($valorItemArray[$i] / $cantidadArray[$i]);  // enviamos el precio por 1 Unidad,
            // ya que Paypal realzia la multiplicacion si hay mas cantidad por item

            //insertamos todo el item array , al arreglo de items
            array_push($variosItem, $item[$i]);
        }


        #Agrupamos los items en una lista de ITEMS
        $itemList = new ItemList();
        $itemList->setItems($variosItem);

        #Agregamos los detalles del pago: impuestos, envíos...etc
        $details = new Details();
        $details->setShipping($datos["envio"])// costo de envio
        ->setTax($datos["impuesto"])// costo de impuestos
        ->setSubtotal($datos["subtotal"]); // enviamos el subtotal sin impuestos

        #definimos el pago total con sus detalles
        $amount = new Amount();
        $amount->setCurrency($datos["divisa"])// pasamos la divisa
        ->setTotal($datos["total"])//valor total de la compra incluido iva
        ->setDetails($details); // le pasamos los detalles anteriormente creados

        #Agregamos las características de la transacción
        $transaction = new Transaction();
        $transaction->setAmount($amount)// pasamos el pago anteriomente creado
        ->setItemList($itemList)// pasamos los detalles de impuestos
        ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid()); //  uniqid() -> genera un id unico


        #Agregamos las URL'S después de realizar el pago, o cuando el pago es cancelado
        #Importante agregar la URL principal en la API developers de Paypal,
        $url = @Ruta::ctrRuta(); // ruta vase de nuestra amplicacion

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("$url/index.php?ruta=finalizar-compra&paypal=true&productos=" . $idProductos . "&cantidad=" . $cantidadProductos)// url de retorno ok
        ->setCancelUrl("$url/carrito-de-compras");  // url de cancelacion


        #Agregamos todas las características del pago
        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        #Tratar de ejcutar un proceso y si falla ejecutar una rutina de error
        try {
            // traemos las credenciales $apiContext , del archio boostrap
            $payment->create($apiContext);
/*
               echo '<pre>';
               print_r($payment);
               echo '</pre>';*/

        } catch (PayPal\Exception\PayPalConnectionException $ex) {

            echo $ex->getCode(); // Prints the Error Code
            echo $ex->getData(); // Prints the detailed error message
            die($ex);
            return "$url/error";

        }


        # utilizamos un foreach para iterar sobre $payment, utilizamos el método llamado getLinks() para obtener todos los enlaces que aparecen en el
        # array $payment y caso de que $Link->getRel() coincida con 'approval_url' extraemos dicho enlace, finalmente enviamos al usuario a esa dirección
        # que guardamos en la variable $redirectUrl on el método getHref();

        foreach ($payment->getLinks() as $link) {

            if($link->getRel() == "approval_url"){  // validara, si el array que devuelve el api, es igual arpoval_url que es el link al cual debe redirigirse

                $redirectUrl = $link->getHref();
            }
        }

        return $redirectUrl;


    }

}

?>