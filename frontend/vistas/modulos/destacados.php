<!--=======================================
BANNER
=============================================-->
<?php
$servidor = @Ruta::ctrRutaServidor();


$ruta = "sin-categoria";

//funcion que traera el banner desde la BD
$banner = ControladorProductos::ctrMostrarBanner($ruta);

if($banner != null){

    if($banner["estado"] != 0){

        echo '<figure class="banner">

				<img src="'.$servidor.$banner["img"].'" class="img-responsive" width="100%">	

			  </figure>';

    }

}

?>


<!--=======================================
BARRA DE PRODUCTOS
=============================================-->

<?php


$titulosModulos = array(
    "ARTICULOS GRATUITOS",
    "LO MAS VENDIDO",
    "LO MAS VISTO"
);

$rutasModulos = array("articulos-gratis", "lo-mas-vendido", "lo-mas-visto");

$ordenar = "";
$gratis = '';
$ventas = '';
$vistas = '';
$base = 0;
$tope = 4;
$modo = 'DESC';
if ($titulosModulos[0] == "ARTICULOS GRATUITOS") {
    $ordenar = 'id';
    $item = 'precio';
    $valor = 0;
    $gratis = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);
}

if ($titulosModulos[1] == "LO MAS VENDIDO") {
    $ordenar = 'ventas';
    $item = null;
    $valor = null;
    $ventas = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);
}

if ($titulosModulos[2] == "LO MAS VISTO") {
    $ordenar = 'vistas';
    $item = null;
    $valor = null;
    $vistas = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);
}

//$productos = ControladorProductos::ctrMostrarProductos($ordenar);

//variable que reunira todos los valores de las variables que instancian al contrlador
$modulos = array($gratis, $ventas, $vistas);


for ($i = 0; $i < count($titulosModulos); $i++) {
    //barra de botones
    echo '<div class="container-fluid well well-sm barraProductos">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 organizarProductos">
                <div class="btn-group pull-right">
                    <button class="btn btn-default btnGrid" id="btnGrid' . $i . '">
                        <i class="fa fa-th"></i>
                        <span class="visible-lg visible-md visible-sm pull-right"> GRID</span>
                    </button>
                    <button class="btn btn-default btnList" id="btnList' . $i . '">
                        <i class="fa fa-list"></i>
                        <span class="visible-lg visible-md visible-sm pull-right"> LIST</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>';

    //vitrina de productos

    echo '<div class="container-fluid productos">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 tituloDestacado">
                <div class="col-sm-6 col-xs-12">
                    <h1>
                        <small>' . $titulosModulos[$i] . '</small>
                    </h1>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <a href="' . $rutasModulos[$i] . '">
                        <button class="btn btn-default backColor pull-right">
                            <span class="fa fa-angle-rigth"></span> VER MAS
                        </button>
                    </a>
                </div>
            </div>

        </div>
        <hr>
     
        <ul class="grid' . $i . '" style="">';

    foreach ($modulos[$i] as $key => $value) {
        echo ' <li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <figure>
                    <a href="' . $value['ruta'] . '" class="pixelProducto">
                        <img src="' . $servidor . $value['portada'] . '"
                             alt="" class="img-responsive">
                    </a>
                </figure>
                <h4>
                    <small>
                        <a href="' . $value['ruta'] . '" class="pixelProducto">
                            ' . $value['titulo'] . ' <br>
                            
                            <span style="color:rgba(0,0,0,0)">-</span>';



        //validacion de si el producto no de alta del producto es menor a 30 dias, entonces en NUEVO
        $fecha = date('y-m-d');
        $fechaActual = strtotime('-30 day', strtotime($fecha) );
        $fechaNueva = date('y-m-d', $fechaActual); // parseamos el resultado de arriba con los - 30 days

        //comparacion de fecha, si es menor la fecha actual -30 dias a la fecha de publicacion
        if ($fechaNueva < $value['fecha']) {
            echo '<span class="label label-warning fonstSize">Nuevo </span> <span style="color:rgba(0,0,0,0)">-</span>';
        }

        // 0 -> en la bd siginifica que no tiene oferta
        if ($value['oferta'] != 0) {
            echo '<span class="label label-warning fonstSize"> ' . $value['descuentoOferta'] . '% off </span> ';
        }

        echo '</a>
                    </small>
                </h4>
                <div class="col-xs-6 precio">';

        if ($value['precio'] == 0) {
            echo ' <h2>
                        <small>GRATIS</small>
                    </h2>';
        } else {
            if ($value['oferta'] != 0) {
                echo ' <h2>
                        <strong class="oferta">USD $' . $value['precio'] . '</strong>
                        <small>$' . $value['precioOferta'] . '</small>
                    </h2>
                    ';
            } else {
                echo ' <h2>
                        <small>USD $' . $value['precio'] . '</small>
                    </h2>';
            }


        }


        echo '</div>
                <div class="col-xs-6 enlaces">
                    <div class="btn btn-group pull-right">
                        <button class="btn btn-default btn-xs deseos" idProducto="' . $value['id'] . '" data-toggle="tooltip"
                                title="Agregar a mi lista de deseos">
                            <i class="fa fa-heart"></i>
                        </button>';

        if ($value['tipo'] == "virtual") {

            if ($value['oferta'] != 0) {
                echo ' <button class="btn btn-default btn-xs agregarCarrito" idProducto="' . $value['id'] . '"
                                imagen="' . $servidor . $value['portada'] . '"
                                titulo="' . $value['titulo'] . '"
                                precio="' . $value['precioOferta'] . '" tipo="' . $value['tipo'] . '" peso="' . $value['peso'] . '" data-toggle="tooltip"
                                title="Agregar al carrito de compras"
                        >
                            <i class="fa fa-shopping-cart"></i>
                        </button>';
            } else {
                echo ' <button class="btn btn-default btn-xs agregarCarrito" idProducto="' . $value['id'] . '"
                                imagen="' . $servidor . $value['portada'] . '"
                                titulo="' . $value['titulo'] . '"
                                precio="' . $value['precio'] . '" tipo="' . $value['tipo'] . '" peso="' . $value['peso'] . '" data-toggle="tooltip"
                                title="Agregar al carrito de compras"
                        >
                            <i class="fa fa-shopping-cart"></i>
                        </button>';
            }


        }
        echo '<a href="' . $value['ruta'] . '" class="pixelProducto">
                            <button class="btn btn-default btn-xs deseos" idProducto="' . $value['id'] . '" data-toggle="tooltip"
                                    title="Ver producto">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>
                    </div>
                </div>

            </li>';
    }

    echo '</ul>

					<ul class="list' . $i . '" style="display:none">';

    foreach ($modulos[$i] as $key => $value) {

        echo '<li class="col-xs-12">
						  
					  		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
								   
								<figure>
							
									<a href="' . $value["ruta"] . '" class="pixelProducto">
										
										<img src="' . $servidor . $value["portada"] . '" class="img-responsive">

									</a>

								</figure>

						  	</div>
								  
							<div class="col-lg-10 col-md-7 col-sm-8 col-xs-12">
								
								<h1>

									<small>

										<a href="' . $value["ruta"] . '" class="pixelProducto">

											<a href="' . $value["ruta"] . '" class="pixelProducto">
											
											' . $value["titulo"] . '<br>';

        //validacion de si el producto no de alta del producto es menor a 30 dias, entonces en NUEVO
        $fecha = date('y-m-d');
        $fechaActual = strtotime('-30 day', strtotime($fecha) );
        $fechaNueva = date('y-m-d', $fechaActual); // parseamos el resultado de arriba con los - 30 days

        //comparacion de fecha, si es menor la fecha actual -30 dias a la fecha de publicacion
        if ($fechaNueva < $value['fecha']) {

            echo '<span class="label label-warning">Nuevo</span> ';

        }

        if ($value["oferta"] != 0) {

            echo '<span class="label label-warning">' . $value["descuentoOferta"] . '% off</span>';

        }

        echo '</a>

									</small>

								</h1>

								<p class="text-muted">' . $value["titular"] . '</p>';

        if ($value["precio"] == 0) {

            echo '<h2><small>GRATIS</small></h2>';

        } else {

            if ($value["oferta"] != 0) {

                echo '<h2>

												<small>
							
													<strong class="oferta">USD $' . $value["precio"] . '</strong>

												</small>

												<small>$' . $value["precioOferta"] . '</small>
											
											</h2>';

            } else {

                echo '<h2><small>USD $' . $value["precio"] . '</small></h2>';

            }

        }

        echo '<div class="btn-group pull-left enlaces">
							  	
							  		<button type="button" class="btn btn-default btn-xs deseos"  idProducto="' . $value["id"] . '" data-toggle="tooltip" title="Agregar a mi lista de deseos">

							  			<i class="fa fa-heart" aria-hidden="true"></i>

							  		</button>';

        if ($value["tipo"] == "virtual" && $value["precio"] != 0) {

            if ($value["oferta"] != 0) {

                echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="' . $value["id"] . '" imagen="' . $servidor . $value["portada"] . '" titulo="' . $value["titulo"] . '" precio="' . $value["precioOferta"] . '" tipo="' . $value["tipo"] . '" peso="' . $value["peso"] . '" data-toggle="tooltip" title="Agregar al carrito de compras">

												<i class="fa fa-shopping-cart" aria-hidden="true"></i>

												</button>';

            } else {

                echo '<button type="button" class="btn btn-default btn-xs agregarCarrito"  idProducto="' . $value["id"] . '" imagen="' . $servidor . $value["portada"] . '" titulo="' . $value["titulo"] . '" precio="' . $value["precio"] . '" tipo="' . $value["tipo"] . '" peso="' . $value["peso"] . '" data-toggle="tooltip" title="Agregar al carrito de compras">

												<i class="fa fa-shopping-cart" aria-hidden="true"></i>

												</button>';

            }

        }

        echo '<a href="' . $value["ruta"] . '" class="pixelProducto">

								  		<button type="button" class="btn btn-default btn-xs" data-toggle="tooltip" title="Ver producto">

								  		<i class="fa fa-eye" aria-hidden="true"></i>

								  		</button>

							  		</a>
								
								</div>

							</div>

							<div class="col-xs-12"><hr></div>

						</li>';

    }

    echo '</ul>

				</div>

			</div>';


}

?>
