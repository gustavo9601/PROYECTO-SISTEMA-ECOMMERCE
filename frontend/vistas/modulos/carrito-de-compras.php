<!--=====================================
BREADCRUMB PERFIL
======================================-->

<div class="container-fluid well well-sm">

    <div class="container">

        <div class="row">

            <ul class="breadcrumb fondoBreadcrumb text-uppercase">

                <li><a href="<?php echo $url; ?>">CARRITO DE COMPRAS</a></li>
                <li class="active pagActiva"><?php echo $rutas[0] ?></li>

            </ul>

        </div>

    </div>

</div>


<!--=====================================
TABLA CARRITO DE COMPRAS
======================================-->

<div class="container-fluid">
    <div class="container">
        <div class="panel panel-default">

            <!--=====================================
            CABECERA CARRITO DE COMPRAS
            ======================================-->
            <div class="panel-heading cabeceraCarrito">
                <div class="col-md-6 col-sm-7 col-xs-12 text-center">
                    <h3>
                        <small>PRODUCTO</small>
                    </h3>
                </div>
                <div class="col-md-2 col-sm-1 col-xs-0 text-center">
                    <h3>
                        <small>PRECIO</small>
                    </h3>
                </div>
                <div class="col-sm-2 col-xs-12 text-center">
                    <h3>
                        <small>CANTIDAD</small>
                    </h3>
                </div>
                <div class="col-sm-2 col-xs-12 text-center">
                    <h3>
                        <small>SUBTOTAL</small>
                    </h3>
                </div>
            </div>

            <!--=====================================
      CUERPO CARRITO DE COMPRAS
      ======================================-->
            <div class="panel-body cuerpoCarrito">


            </div>

            <!--=====================================
    SUMA DEL TOTAL DE PRODUCTOS
    ======================================-->

            <div class="panel-body sumaCarrito">

                <div class="col-md-4 col-sm-6 col-xs-12 pull-right well">

                    <div class="col-xs-6">

                        <h4>TOTAL:</h4>

                    </div>

                    <div class="col-xs-6">

                        <h4 class="sumaSubTotal">

                            <strong>USD $<span>21</span></strong>

                        </h4>

                    </div>

                </div>

            </div>

            <!--=====================================
            BOTÓN CHECKOUT
            ======================================-->

            <div class="panel-heading cabeceraCheckout">

                <?php

                /*Validaremos si ya se inicio sesion para modificar el boton de realziar, pago
                y abirir el modal de pago o si no ha iniciado el modal de inicio
                */

                if (isset($_SESSION["validarSesion"])) {

                    if ($_SESSION["validarSesion"] == "ok") {

                        echo '<a id="btnCheckout" href="#modalCheckout" data-toggle="modal" idUsuario="' . $_SESSION["id"] . '"><button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button></a>';

                    }


                } else {

                    echo '<a href="#modalIngreso" data-toggle="modal"><button class="btn btn-default backColor btn-lg pull-right">REALIZAR PAGO</button></a>';
                }


                ?>
            </div>

        </div>
    </div>
</div>


<!--=====================================
VENTANA MODAL PARA CHECKOUT
======================================-->

<div id="modalCheckout" class="modal fade modalFormulario" role="dialog">

    <div class="modal-content modal-dialog">

        <div class="modal-body modalTitulo">

            <h3 class="backColor">REALIZAR PAGO</h3>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <div class="contenidoCheckout">

                <?php
                //Trera la informacion desde la BD, de las tarigfas del Ecommerce
                $respuesta = ControladorCarrito::ctrMostrarTarifas();

                //Imprimimos los input ocultos

                echo '<input type="hidden" id="tasaImpuesto" value="' . $respuesta["impuesto"] . '">
                          <input type="hidden" id="envioNacional" value="' . $respuesta["envioNacional"] . '">
                          <input type="hidden" id="envioInternacional" value="' . $respuesta["envioInternacional"] . '">
                          <input type="hidden" id="tasaMinimaNal" value="' . $respuesta["tasaMinimaNal"] . '">
                          <input type="hidden" id="tasaMinimaInt" value="' . $respuesta["tasaMinimaInt"] . '">
                          <input type="hidden" id="tasaPais" value="' . $respuesta["pais"] . '">

                    ';

                ?>

                <div class="formEnvio row">

                    <h4 class="text-center well text-muted text-uppercase">Información de envío</h4>

                    <div class="col-xs-12 seleccionePais">

                        <!-- Aparecera el listbox con los paises-->


                    </div>

                </div>

                <br>

                <div class="formaPago row">

                    <h4 class="text-center well text-muted text-uppercase">Elige la forma de pago</h4>

                    <figure class="col-xs-6">

                        <center>

                            <input id="checkPaypal" type="radio" name="pago" value="paypal" checked>

                        </center>

                        <img src="<?php echo $url; ?>vistas/img/plantilla/paypal.jpg" class="img-thumbnail">

                    </figure>

                    <figure class="col-xs-6">

                        <center>

                            <input id="checkPayu" type="radio" name="pago" value="payu">

                        </center>

                        <img src="<?php echo $url; ?>vistas/img/plantilla/payu.jpg" class="img-thumbnail">

                    </figure>

                </div>

                <br>

                <div class="listaProductos row">

                    <h4 class="text-center well text-muted text-uppercase">Productos a comprar</h4>

                    <table class="table table-striped tablaProductos">

                        <thead>

                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>

                        </thead>

                        <tbody>
                        <!--Traemos la informacion de los proudctos que esten en el localstorage-->

                        </tbody>

                    </table>

                    <div class="col-sm-6 col-xs-12 pull-right">

                        <table class="table table-striped tablaTasas">

                            <tbody>

                            <tr>
                                <td>Subtotal</td>
                                <td><span class="cambioDivisa">USD</span> $<span class="valorSubtotal"
                                                                                 valor="0">0</span></td>
                            </tr>

                            <tr>
                                <td>Envío</td>
                                <td><span class="cambioDivisa">USD</span> $<span class="valorTotalEnvio"
                                                                                 valor="0">0</span></td>
                            </tr>

                            <tr>
                                <td>Impuesto</td>
                                <td><span class="cambioDivisa">USD</span> $<span class="valorTotalImpuesto"
                                                                                 valor="0">0</span></td>
                            </tr>

                            <tr>
                                <td><strong>Total</strong></td>
                                <td><strong><span class="cambioDivisa">USD</span> $<span class="valorTotalCompra"
                                                                                         valor="0">0</span></strong>
                                </td>
                            </tr>

                            </tbody>

                        </table>

                        <div class="divisa">

                            <select class="form-control" id="cambiarDivisa" name="divisa">


                            </select>

                            <br>

                        </div>

                    </div>

                    <div class="clearfix"></div>

                    <!--Formulario de Payu-->
                    <form class="formPayu" style="display:none">
                        <!--Merchan ID-->
                        <input name="merchantId" type="hidden" value=""/>
                        <!--Id de cuenta-->
                        <input name="accountId" type="hidden" value=""/>
                        <!--Nombre de describpcion-->
                        <input name="description" type="hidden" value=""/>
                        <!--R   eferencia de transferencia-->
                        <input name="referenceCode" type="hidden" value=""/>
                        <!--Costo-->
                        <input name="amount" type="hidden" value=""/>
                        <!--Tasas de impuesto-->
                        <input name="tax" type="hidden" value=""/>
                        <!--retorno que se genera de acuerdo al impuesto-->
                        <input name="taxReturnBase" type="hidden" value=""/>
                        <!--Valor del envio-->
                        <input name="shipmentValue" type="hidden" value=""/>
                        <!--Divisa-->
                        <input name="currency" type="hidden" value=""/>
                        <!--Legunaje-->
                        <input name="lng" type="hidden" value="es"/>
                        <!--URL de confirmacion -->
                        <input name="confirmationUrl" type="hidden" value=""/>
                        <!--URL de respuesta-->
                        <input name="responseUrl" type="hidden" value=""/>
                        <!--URL de respuesta si se  cancela la transaccion-->
                        <input name="declinedResponseUrl" type="hidden" value=""/>
                        <!--Poder visualizar la informacion de envio del comprador (YES / NO ) si es producoto fisico-->
                        <input name="displayShippingInformation" type="hidden" value=""/>
                        <!--Valor 1 es modo prueba, valor 0 es modo real-->
                        <input name="test" type="hidden" value=""/>
                        <!--Token o clave secreta para que payu identifique la transaccion , mezcla de variables cifrados-->
                        <input name="signature" type="hidden" value=""/>


                        <input name="Submit" class="btn btn-block btn-lg btn-default backColor" type="submit"
                               value="PAGAR">
                    </form>

                    <button class="btn btn-block btn-lg btn-default backColor btnPagar">PAGAR</button>

                </div>

            </div>

        </div>

        <div class="modal-footer">

        </div>

    </div>

</div>
