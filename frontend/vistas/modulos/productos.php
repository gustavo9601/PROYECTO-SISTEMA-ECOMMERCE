<?php
$servidor = @Ruta::ctrRutaServidor();
$url = @Ruta::ctrRuta();
?>

<!--=======================================
BANNER
=============================================-->
<?php
$ruta = $rutas[0];  //captura la url amigable, si tiene en la bd mostrara el banner
$banner = ControladorProductos::ctrMostrarBanner($ruta);

if($banner != null){

    if($banner["estado"] != 0){

        echo '<figure class="banner">

				<img src="'.$servidor.$banner["img"].'" class="img-responsive" width="100%">';

        if($banner["ruta"] != "sin-categoria"){

            /*=============================================
            BANNER PARA CATEGORÍAS
            =============================================*/

            if($banner["tipo"] == "categorias"){

                $item = "ruta";
                $valor = $banner["ruta"];

                $ofertas = ControladorProductos::ctrMostrarCategorias($item, $valor);

                if($ofertas["oferta"] == 1){

                    echo '<div class="textoBanner textoIzq">

								<h1 style="color:#fff" class="text-uppercase">'.$ofertas["categoria"].'</h1>

							</div>

							<div class="textoBanner textoDer">
							
								<h1 style="color:#fff">OFERTAS ESPECIALES</h1>';

                    if($ofertas["precioOferta"] != 0){

                        echo '<h2 style="color:#fff"><strong>Todos los productos a $ '.$ofertas["precioOferta"].'</strong></h2>';

                    }

                    if($ofertas["descuentoOferta"] != 0){

                        echo '<h2 style="color:#fff"><strong>Todos los productos con '.$ofertas["descuentoOferta"].'% OFF</strong></h2>';
                    }

                    echo '<h3 class="col-md-0 col-sm-0 col-xs-0" style="color:#fff">
								
								La oferta termina en<br>

								<div class="countdown2" finOferta="'.$ofertas["finOferta"].'">


							</h3>';

                    $fechaActual = date('y-m-d');
                    $datetime1 = new DateTime($ofertas["finOferta"]);
                    $datetime2 = new DateTime($fechaActual);

                    $interval = date_diff($datetime1, $datetime2);

                    $finOferta = $interval->format('%a');

                    if($finOferta == 0){

                        echo '<h3 class="col-lg-0" style="color:#fff">La oferta termina hoy</h3>';

                    }else if($finOferta == 1){

                        echo '<h3 class="col-lg-0" style="color:#fff">La oferta termina en '.$finOferta.' día</h3>';

                    }else{

                        echo '<h3 class="col-lg-0" style="color:#fff">La oferta termina en '.$finOferta.' días</h3>';

                    }


                    echo '</div>';

                }

            }

            /*=============================================
            BANNER PARA SUBCATEGORÍAS
            =============================================*/

            if($banner["tipo"] == "subcategorias"){

                $item = "ruta";
                $valor = $banner["ruta"];

                $ofertas = ControladorProductos::ctrMostrarSubCategorias($item, $valor);

                if($ofertas[0]["oferta"] == 1){

                    echo '<div class="textoBanner textoIzq">

								<h1 style="color:#fff" class="text-uppercase">'.$ofertas[0]["subcategoria"].'</h1>

							</div>

							<div class="textoBanner textoDer">
							
								<h1 style="color:#fff">OFERTAS ESPECIALES</h1>';

                    if($ofertas[0]["precioOferta"] != 0){

                        echo '<h2 style="color:#fff"><strong>Todos los productos a $ '.$ofertas[0]["precioOferta"].'</strong></h2>';

                    }

                    if($ofertas[0]["descuentoOferta"] != 0){

                        echo '<h2 style="color:#fff"><strong>Todos los productos con '.$ofertas[0]["descuentoOferta"].'% OFF</strong></h2>';
                    }

                    echo '<h3 class="col-md-0 col-sm-0 col-xs-0" style="color:#fff">
								
								La oferta termina en<br>

								<div class="countdown2" finOferta="'.$ofertas[0]["finOferta"].'">


							</h3>';

                    $datetime1 = new DateTime($ofertas[0]["finOferta"]);
                    $datetime2 = new DateTime($fechaActual);

                    $interval = date_diff($datetime1, $datetime2);

                    $finOferta = $interval->format('%a');

                    if($finOferta == 0){

                        echo '<h3 class="col-lg-0" style="color:#fff">La oferta termina hoy</h3>';

                    }else if($finOferta == 1){

                        echo '<h3 class="col-lg-0" style="color:#fff">La oferta termina en '.$finOferta.' día</h3>';

                    }else{

                        echo '<h3 class="col-lg-0" style="color:#fff">La oferta termina en '.$finOferta.' días</h3>';

                    }


                    echo '</div>';

                }





            }



        }

        echo '</figure>';

    }

}

?>


<div class="container-fluid well well-sm barraProductos">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        Ordenar productos <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">


                        <?php
                        echo '<li><a href="' . $url . $rutas[0] . '/1/recientes">Mas reciente</a></li>
                              <li><a href="' . $url . $rutas[0] . '/1/antiguos">Mas antiguo</a></li>';
                        ?>


                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12 organizarProductos">
                <div class="btn-group pull-right">
                    <button class="btn btn-default btnGrid" id="btnGrid0">
                        <i class="fa fa-th"></i>
                        <span class="visible-lg visible-md visible-sm pull-right"> GRID</span>
                    </button>
                    <button class="btn btn-default btnList" id="btnList0">
                        <i class="fa fa-list"></i>
                        <span class="visible-lg visible-md visible-sm pull-right"> LIST</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<!--=======================================
LISTAR PRODUCTOS
=============================================-->
<div class="container-fluid productos">
    <div class="container">
        <center class="row">

            <!--=======================================
           MIGAS DE PAN
           =============================================-->

            <ul class="breadcrumb fondoBreadcrumb lead">
                <li><a href="<?php echo $url ?>">INICIO</a></li>
                <li><a href="" class="active paginaActiva"><?php echo $rutas[0] ?></a></li>
            </ul>

            <!--=======================================
            LLAMADAO DE PAGINACION
           =============================================-->
            <?php
            //$rutas[1]  -> rutas en la posicion 2, debe treaer un entero que indicaria el numero de pagina

            if (isset($rutas[1])) {

                //var_dump($rutas[1]);


                //rutas[2] -> contine si es reciente o antiguo, validamos que si venga
                if (isset($rutas[2])) {


                    if ($rutas[2] == 'antiguos') {
                        $modo = "ASC";

                        $_SESSION["ordenar"] = $modo;
                        /*
variable de session que almacenara la informacion, para cuando se muevan entre la paginacion, se conserve
la forma de ordenamiento
*/


                    } else {
                        $modo = "DESC";
                        $_SESSION["ordenar"] = $modo;

                    }
                } else { // si no viene ningun modo, se organizaran desendemtenete


                    if (isset($_SESSION['ordenar'])) {

                        $modo = $_SESSION["ordenar"];
                    } else {
                        $modo = "DESC";
                    }

                    // en este caso, si no esty usando la ruta de ordenamiendo, pero si las de paginacion
                    // como ya tengo la session creada con el tipo de ordenamiento este se conservara

                }

                // logica para ir sabiendo el offset del query
                $base = ($rutas[1] - 1) * 12;
                $tope = 12;

            } else {
                $rutas[1] = 1;
                $base = 0;
                $tope = 12;
                $modo = "DESC";
            }
            ?>


            <!--=======================================
LLAMADO DE PRODUCTOS  CATEGORIA, SUBCATEOGRIAS Y DESTACADOS
=============================================-->


            <?php

            if ($rutas[0] == 'articulos-gratis') {
                $item2 = "precio";
                $valor2 = 0;
                $ordenar = "id";
            } else if ($rutas[0] == 'lo-mas-vendido') {
                $item2 = null;
                $valor2 = null;
                $ordenar = "ventas";
            } else if ($rutas[0] == 'lo-mas-visto') {
                $item2 = null;
                $valor2 = null;
                $ordenar = "vistas";
            } else {

                $ordenar = "id";
                $item1 = "ruta";  // nombre de columna en la BD
                $valor1 = $rutas[0];  // url amigable, por GET

                $categoria = ControladorProductos::ctrMostrarCategorias($item1, $valor1);

//var_dump($categoria);
//si no encontro nada en categorias buscamos en subcategorias
                if (!$categoria) {
                    $subCategorias = ControladorProductos::ctrMostrarSubCategorias($item1, $valor1);
                    //var_dump($subCategorias);
                    $item2 = "id_subcategoria";
                    //usamos indice ya que el modelo devuelve una matriz
                    $valor2 = $subCategorias[0]['id'];

                } else {
                    $item2 = "id_categoria";
                    $valor2 = $categoria['id'];
                }
            }


            // echo '<h1>' . $modo . '</h1>';
            $productos = ControladorProductos::ctrMostrarProductos($ordenar, $item2, $valor2, $base, $tope, $modo);
            //var_dump($productos);

            //invaoncado al controlador para saber cuantos productos hay de acuerdo a lo seleccionado o por URL
            $listaProductos = ControladorProductos::ctrListarProductos($ordenar, $item2, $valor2);


            if (!$productos) {
                echo '<div class="container">
	
	<div class="row">
		
		<div class="col-12-xs text-center error404">
			
			<h1><small>!Oops¡</small></h1>
            <h2>Aun no hay productos en esta seccion</h2>
		</div>
	</div>
</div>';
            } else {
                echo "<ul class='grid0'>";
                foreach ($productos as $key => $value) {
                    echo ' <li class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <figure>
                    <a href="' . $url . $value['ruta'] . '" class="pixelProducto">
                        <img src="' . $servidor . $value['portada'] . '"
                             alt="" class="img-responsive">
                    </a>
                </figure>
                <h4>
                    <small>
                        <a href="' . $url . $value['ruta'] . '" class="pixelProducto">
                            ' . $value['titulo'] . ' <br>
                            
                            <span style="color:rgba(0,0,0,0)">-</span>';

                    echo 'COD - ' . $value['id'] . '- ';


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
                    echo '<a href="' . $url . $value['ruta'] . '" class="pixelProducto">
                            <button class="btn btn-default btn-xs deseos" idProducto="' . $value['id'] . '" data-toggle="tooltip"
                                    title="Ver producto">
                                <i class="fa fa-eye"></i>
                            </button>
                        </a>
                    </div>
                </div>

            </li>';
                }

                //Visualizacion de los productos en modo lista
                echo '</ul>

					<ul class="list0" style="display:none">';

                foreach ($productos as $key => $value) {

                    echo '<li class="col-xs-12">
						  
					  		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
								   
								<figure>
							
									<a href="' . $url . $value["ruta"] . '" class="pixelProducto">
										
										<img src="' . $servidor . $value["portada"] . '" class="img-responsive">

									</a>

								</figure>

						  	</div>
								  
							<div class="col-lg-10 col-md-7 col-sm-8 col-xs-12">
								
								<h1>

									<small>

										<a href="' . $url . $value["ruta"] . '" class="pixelProducto">

											<a href="' . $url . $value["ruta"] . '" class="pixelProducto">
											
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
            <center>
                <?php


                /*==========================
                PAGINACION
                ==============================*/
                //si hay mas de 1 producto, ,se creara paginacion
                if (count($listaProductos) != 0) {
                    //cantidad de paginas que deben salir, 12 -> ya que se mostraran 12 por limite en la pagina
                    $pagProductos = ceil(count($listaProductos) / 12); //ceil(num)  -> redondea hacia el numero mayor


                    if ($pagProductos > 4) {

                        /*================================*/
                        /*// LOS BOTONES DE LAS PRIMERAS 4 PAGINAS Y LA ULTIMA PAGINAS*/
                        /*================================*/
                        if ($rutas[1] == 1) {

                            echo '  <ul class="pagination">';

                            for ($i = 1; $i <= 4; $i++) {
                                echo '<li id="item' . $i . '"><a href="' . $url . $rutas[0] . '/' . $i . '">' . $i . '</a></li>';
                            }
                            echo '<li class="disabled"><a>...</a></li>
                            <li id="item' . $pagProductos . '" ><a  href="' . $url . $rutas[0] . '/' . $pagProductos . '">' . $pagProductos . '</a></li>
                            <li><a href="' . $url . $rutas[0] . '/2"><i class="fa fa-angle-right"></i></a></li>';
                            echo '</ul>';


                        } else if ($rutas[1] == $pagProductos) {

                            /*================================*/
                            /*LOS BOTONES DE LAS ULTIMAS 4 PAGINAS*/
                            /*================================*/
                            echo '  <ul class="pagination">
                                        <li><a href="' . $url . $rutas[0] . '/' . ($pagProductos - 1) . '"><i class="fa fa-angle-left"></i></a></li>
                                         <li id="item1"><a href="' . $url . $rutas[0] . '/1">1</a></li>
                                        <li class="disabled"><a>...</a></li>';

                            //para que muestre los ultimos 3 botoenes antes de llegar al totoal
                            // ej 21 ,22, 23
                            for ($i = $pagProductos - 3; $i <= $pagProductos; $i++) {
                                echo '<li id="item' . $i . '"><a href="' . $url . $rutas[0] . '/' . $i . '">' . $i . '</a></li>';
                            }
                            echo '</ul>';

                            //validamos que no sea la ultima posicion, y que no sea la primera,
                        } else if ($rutas[1] != $pagProductos &&
                            $rutas[1] != 1 &&
                            $rutas[1] < $pagProductos / 2 &&
                            $rutas[1] < $pagProductos - 3
                        ) {
                            /*================================*/
                            /*LOS BOTONES DE LA MITAD DE PAGINAS HACIA ABAJO*/
                            /*================================*/
                            $numeroPagActual = $rutas[1];

                            echo '  <ul class="pagination" >
                                        <li><a href="' . $url . $rutas[0] . '/' . ($numeroPagActual - 1) . '"><i class="fa fa-angle-left"></i></a></li>
                                   ';

                            //para que muestre los ultimos 3 botoenes antes de llegar al totoal
                            // ej 21 ,22, 23
                            for ($i = $numeroPagActual; $i <= $numeroPagActual + 3; $i++) {
                                echo '<li id="item' . $i . '" ><a href="' . $url . $rutas[0] . '/' . $i . '">' . $i . '</a></li>';
                            }
                            echo '<li class="disabled"><a>...</a></li>
                            <li id="item' . $pagProductos . '" ><a href="' . $url . $rutas[0] . '/' . $pagProductos . '">' . $pagProductos . '</a></li>
                            <li><a href="' . $url . $rutas[0] . '/' . ($numeroPagActual + 1) . '"><i class="fa fa-angle-right"></i></a></li>';
                            echo '</ul>';

                        } else if ($rutas[1] != $pagProductos &&
                            $rutas[1] != 1 &&
                            $rutas[1] >= $pagProductos / 2 &&
                            $rutas[1] < $pagProductos - 3
                        ) {
                            /*================================*/
                            /*LOS BOTONES DE LA MITAD DE PAGINAS HACIA ARRIBA*/
                            /*================================*/
                            $numeroPagActual = $rutas[1];
                            echo '  <ul class="pagination">
                                        <li><a href="' . $url . $rutas[0] . '/' . ($numeroPagActual - 1) . '"><i class="fa fa-angle-left"></i></a></li>
                                         <li id="item1" ><a href="' . $url . $rutas[0] . '/1">1</a></li>
                                        <li class="disabled"><a>...</a></li>';

                            //para que muestre los ultimos 3 botoenes antes de llegar al totoal
                            // ej 21 ,22, 23
                            for ($i = $numeroPagActual; $i <= $numeroPagActual + 3; $i++) {
                                echo '<li id="item' . $i . '" ><a href="' . $url . $rutas[0] . '/' . $i . '">' . $i . '</a></li>';
                            }
                            echo '<li><a href="' . $url . $rutas[0] . '/' . ($numeroPagActual + 1) . '"><i class="fa fa-angle-right"></i></a></li>
                                </ul>';

                        } else {  // LO QUE SOBRa de todas las condiciones
                            /*================================*/
                            /*LOS BTOTONES DE LAS ULTIMAS 4 PAGINAS*/
                            /*================================*/
                            $numeroPagActual = $rutas[1];
                            echo '  <ul class="pagination">
                                        <li><a href="' . $url . $rutas[0] . '/' . ($numeroPagActual - 1) . '"><i class="fa fa-angle-left"></i></a></li>
                                         <li id="item1" ><a href="' . $url . $rutas[0] . '/1">1</a></li>
                                        <li class="disabled"><a>...</a></li>';

                            //para que muestre los ultimos 3 botoenes antes de llegar al totoal
                            // ej 21 ,22, 23
                            for ($i = $pagProductos - 3; $i <= $pagProductos; $i++) {
                                echo '<li id="item' . $i . '" ><a href="' . $url . $rutas[0] . '/' . $i . '">' . $i . '</a></li>';
                            }
                            echo '</ul>';
                        }


                    } else {
                        echo '  <ul class="pagination">';

                        for ($i = 1; $i <= $pagProductos; $i++) {
                            echo '<li id="item' . $i . '"><a href="' . $url . $rutas[0] . '/' . $i . '">' . $i . '</a></li>';
                        }
                        echo '</ul>';
                    }

                }

                ?>


            </center>

    </div>
</div>
</div>