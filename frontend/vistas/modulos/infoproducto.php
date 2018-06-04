<?php
$servidor = @Ruta::ctrRutaServidor();
$url = @Ruta::ctrRuta();
?>

<!--=============================================-->
<!--info productos-->
<!--=============================================-->
<div class="container-fluid well well-sm">
    <div class="container">
        <div class="row">
            <!--=============================================-->
            <!--MIGA DE PAN-->
            <!--=============================================-->
            <ul class="breadcrumb fondoBreadcrumb lead">
                <li><a href="<?php echo $url ?>">INICIO</a></li>
                <li><a href="" class="active paginaActiva"><?php echo $rutas[0] ?></a></li>
            </ul>
        </div>
    </div>
</div>


<!--=============================================-->
<!--info productos-->
<!--=============================================-->
<div class="container-fluid infoproducto">
    <div class="container">
        <div class="row">
            <!--=============================================-->
            <!--VISOR DE PRODUCTOS-->
            <!--=============================================-->

            <?php

            $item = "ruta";
            $valor = $rutas[0];


            $infoproducto = ControladorProductos::ctrMostrarInfoProducto($item, $valor);


            //decodificamos lo que venga en multimedai
            $multimedia = json_decode($infoproducto['multimedia'], true);

            if ($infoproducto["tipo"] == "fisico") {
                /*
                 * <!--=============================================-->
            <!--VISOR DE IMAGENES-->
            <!--=============================================-->
                 *
                 * */
                echo ' 
            <div class="col-md-5 col-sm-6 col-xs-12 visorImg">
                <figure class="visor">';


                for ($i = 0; $i < @count($multimedia); $i++) {
                    echo '<img id="lupa' . ($i + 1) . '" class="img-thumbnail"
                         src="' . $servidor . $multimedia[$i]['foto'] . '"
                         alt="">';
                }
                echo '
                </figure>
                <div class="flexslider">
                    <ul class="slides">';

                for ($i = 0; $i < @count($multimedia); $i++) {
                    echo '<li>
                            <img class="img-thumbnail"
                                 src="' . $servidor . $multimedia[$i]['foto'] . '"
                                 alt="' . $infoproducto['titulo'] . '" value="' . ($i + 1) . '">
                        </li>';
                }
                echo '
                    </ul>
                </div>

            </div>';
            } else {
                /*
                * <!--=============================================-->
           <!--VISOR DE VIDEO-->
           <!--=============================================-->
                *
                * */
                //?rel=0  // para que no muestre videos relacionados, autoplay=1  // se repoduce automaicamente
                echo '<div class="col-md-5 col-sm-6 col-xs-12 videoPresentacion">
                    
                   <iframe width="100%" frameborder="0" src="https://www.youtube.com/embed/' . $infoproducto['multimedia'] . '?rel=0autoplay=1">
                   
                   </iframe>
                </div>';

            }

            //var_dump($infoproducto);
            ?>


            <!--=============================================-->
            <!--PRODUCTO-->
            <!--=============================================-->

            <?php

            if ($infoproducto["tipo"] == "fisico") {
                echo '<div class="col-md-7 col-sm-6 col-xs-12">';
            } else {
                echo '<div class="col-md-6 col-sm-6 col-xs-12">';
            }

            ?>
            <!--regresar a la tienda-->
            <div class="col-xs-6">
                <h6>
                    <a href="javascript:history.back()" class="text-muted">
                        <i class="fa fa-reply"></i> Continuar Comprando
                    </a
                    ></h6>
            </div>

            <!--=============================================-->
            <!--COMPARTIR EN REDES SOCIALES-->
            <!--=============================================-->

            <div class="col-xs-6">
                <h6>
                    <a href="#" class="dropdown-toogle pull-right text-muted" data-toggle="dropdown">
                        <i class="fa fa-plus"></i> Compartir
                    </a>
                    <ul class="dropdown-menu pull-right compartirRedes">
                        <li>
                            <p class="btnFacebook">
                                <i class="fa fa-facebook"></i>
                                Facebook
                            </p>
                        </li>
                        <li>
                            <p class="btnGoogle">
                                <i class="fa fa-google"></i>
                                Google
                            </p>
                        </li>
                    </ul>
                </h6>


                <?php


                /*Aparecera en display none para que no se muestre en el HTML pero desde el JS si se capturara la informacion que tengan los input y bootnes*/
                echo '<div class="comprarAhora" style="display:none">

						<button class="btn btn-default backColor quitarItemCarrito" idProducto="' . $infoproducto["id"] . '" peso="' . $infoproducto["peso"] . '"></button>

						<p class="tituloCarritoCompra text-left">' . $infoproducto["titulo"] . '</p>';

                if ($infoproducto["oferta"] == 0) {

                    echo '<input class="cantidadItem" value="1" tipo="' . $infoproducto["tipo"] . '" precio="' . $infoproducto["precio"] . '" idProducto="' . $infoproducto["id"] . '">

							<p class="subTotal' . $infoproducto["id"] . ' subtotales">
						
								<strong>USD $<span>' . $infoproducto["precio"] . '</span></strong>

							</p>

							<div class="sumaSubTotal"><span>' . $infoproducto["precio"] . '</span></div>';


                } else {

                    echo '<input class="cantidadItem" value="1" tipo="' . $infoproducto["tipo"] . '" precio="' . $infoproducto["precioOferta"] . '" idProducto="' . $infoproducto["id"] . '">

							<p class="subTotal' . $infoproducto["id"] . ' subtotales">
						
								<strong>USD $<span>' . $infoproducto["precioOferta"] . '</span></strong>

							</p>

							<div class="sumaSubTotal"><span>' . $infoproducto["precioOferta"] . '</span></div>';
                }
                echo '</div>';

                ?>

            </div>

            <div class="clearfix"></div>

            <!--=============================================-->
            <!--ESPACIO PARA EL PRODUCTO-->
            <!--=============================================--


                <?php

            /*==============================*/
            /*TITULO DEL PRODUCTO*/
            /*==============================*/
            //si es == 0 es por que no trae oferta
            if ($infoproducto['oferta'] == 0) {


                if ($infoproducto["nuevo"] == 0) {
                    echo '<h1 class="text-mute text-uppercase">' . $infoproducto['titulo'] . '</h1>';

                } else {
                    echo '<h1 class="text-mute text-uppercase">' . $infoproducto['titulo'] . '<br>
                    <small>
                        <span class="label label-warning">nuevo</span>
                    </small>
                </h1>';
                }

            } else {

                if ($infoproducto["nuevo"] == 0) {
                    echo '<h1 class="text-mute text-uppercase">' . $infoproducto['titulo'] . '<br>
                    <small>
                        <span class="label label-warning">' . $infoproducto['descuentoOferta'] . ' % off</span>
                    </small>
                </h1>';
                } else {
                    echo '<h1 class="text-mute text-uppercase">' . $infoproducto['titulo'] . '<br>
                    <small>
                        <span class="label label-warning">' . $infoproducto['descuentoOferta'] . ' % off</span>
                        <span class="label label-warning">nuevo</span>
                    </small>
                </h1>';
                }


            }

            /*==============================*/
            /*PRECIO DEL PRODUCTO*/
            /*==============================*/
            if ($infoproducto['precio'] == 0) {
                echo '<h2 class="text-muted">GRATIS</h2>';
            } else {

                if ($infoproducto['oferta'] == 0) {
                    echo '<h2 class="text-muted">USD $' . $infoproducto['precio'] . '</h2>';

                } else {
                    echo '<h2 class="text-muted">
                    <span>
                    <strong class="oferta">USD $' . $infoproducto['precio'] . '</strong>
                    </span>
                    <span>
                    $' . $infoproducto['precio'] . '
                    </span>
                    </h2>';
                }

            }


            /*==============================*/
            /*DESCRIPCION DEL PRODUCTO*/
            /*==============================*/
            echo '<p>' . $infoproducto['descripcion'] . '</p>';
            ?>


                <!--=============================================-->
            <!--CARACTERISTICAS DEL PRODUCTO-->
            <!--=============================================-->
            <hr>
            <div class="form-group row">
                <?php
                if ($infoproducto['detalles'] != null) {
                    //cnvierto a array el json que viene desde la bd
                    $detales = json_decode($infoproducto['detalles'], true);
                    if ($infoproducto['tipo'] == "fisico") {
                        if ($detales["Talla"] != null) {
                            echo '<div class="col-md-3 col-xs-12">
                                    <select class="form-control seleccionarDetalle" id="seleccionarTalla">
                                        <option value="">Talla</option>';
                            for ($i = 0; $i < count($detales["Talla"]); $i++) {
                                echo '<option value="' . $detales['Talla'][$i] . '">' . $detales['Talla'][$i] . '</option>';
                            }
                            echo '</select>
                                </div>';
                        }


                        if ($detales["Color"] != null) {
                            echo '<div class="col-md-3 col-xs-12">
                                    <select class="form-control seleccionarDetalle" id="seleccionarColor">
                                        <option value="">Color</option>';
                            for ($i = 0; $i < count($detales["Color"]); $i++) {
                                echo '<option value="' . $detales['Color'][$i] . '">' . $detales['Color'][$i] . '</option>';
                            }
                            echo '</select>
                                </div>';
                        }


                        if ($detales["Marca"] != null) {
                            echo '<div class="col-md-3 col-xs-12">
                                    <select class="form-control seleccionarDetalle" id="seleccionarMarca">
                                        <option value="">Marca</option>';
                            for ($i = 0; $i < count($detales["Marca"]); $i++) {
                                echo '<option value="' . $detales['Marca'][$i] . '">' . $detales['Marca'][$i] . '</option>';
                            }
                            echo '</select>
                                </div>';
                        }
                    } else {
                        /*SI ES VIRTUAL*/

                        echo '<div class="col-xs-12">
                                <li>
                                    <i style="margin-right:10px;" class="fa fa-play-circle"></i> ' . $detales['Clases'] . '
                                </li>
                                <li>
                                    <i style="margin-right:10px;" class="fa fa-clock-o"></i> ' . $detales['Tiempo'] . '
                                </li>
                                                                <li>
                                    <i style="margin-right:10px;" class="fa fa-check-circle"></i> ' . $detales['Nivel'] . '
                                </li>
                                                                <li>
                                    <i style="margin-right:10px;" class="fa fa-info-circle"></i> ' . $detales['Acceso'] . '
                                </li>
                                                                <li>
                                    <i style="margin-right:10px;" class="fa fa-desktop"></i> ' . $detales['Dispositivo'] . '
                                </li>
                                                                <li>
                                    <i style="margin-right:10px;" class="fa fa-trophy"></i> ' . $detales['Certificado'] . '
                                </li>
                                
                            </div>';
                    }
                }


                /*==========================================*/
                /*ENTREGA DEL PRODUCTO*/
                /*==========================================*/
                if ($infoproducto['entrega'] == 0) {

                    // si el precio es 0 es por que es gratis
                    if ($infoproducto['precio'] == 0) {
                        echo '<h4 class="col-md-12 col-xs-0 col-sm-0">
                            <hr>
                            <span class="label label-default" style="font-weight: 100">
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                Entrega Inmediata |
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventasGratis'] . ' inscritos |
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistasGratis'] . '</span> personas
                                
                            </span>
                        </h4>
                        
                        <h4 class="col-md-0 col-lg-0 col-xs-12">
                            <hr>
                          <small>
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                Entrega Inmediata <br>
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventasGratis'] . ' inscritos <br>
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistasGratis'] . '</span> personas
                                
                          </small>
                        </h4>
                        ';
                    } else {
                        echo '<h4 class="col-md-12 col-xs-0 col-sm-0">
                            <hr>
                            <span class="label label-default" style="font-weight: 100">
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                Entrega Inmediata |
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventas'] . ' ventas |
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistas'] . '</span> personas
                                
                            </span>
                        </h4>
                        
                        <h4 class="col-md-0 col-lg-0 col-xs-12">
                            <hr>
                           <small>
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                                Entrega Inmediata <br>
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventas'] . ' ventas <br>
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistas'] . '</span> personas
                            </small>    
                         
                        </h4>';
                    }


                } else {

                    // si el precio es 0 es por que es gratis
                    if ($infoproducto['precio'] == 0) {
                        echo '<h4 class="col-md-12 col-xs-0 col-sm-0">
                            <hr>
                            <span class="label label-default" style="font-weight: 100">
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                               ' . $infoproducto['entrega'] . ' dias habiles para la entrega |
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventasGratis'] . ' solicitudes |
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistasGratis'] . '</span> personas
                                
                            </span>
                        </h4>
                        
                        <h4 class="col-md-0 col-lg-0 col-xs-12">
                            <hr>
                            <small>
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                               ' . $infoproducto['entrega'] . ' dias habiles para la entrega <br>
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventasGratis'] . ' solicitudes <br>
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistasGratis'] . '</span> personas
                              </small>  
                           
                        </h4>';
                    } else {
                        /*
                         *
                         * col-lg-0  // elimimna el espacio en el tamaño de boostrap
                         * */
                        echo '<h4 class="col-md-12 col-xs-0 col-sm-0">
                            <hr>
                            <span class="label label-default" style="font-weight: 100">
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                               ' . $infoproducto['entrega'] . ' dias habiles para la entrega |
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventas'] . ' ventas |
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistas'] . '</span> personas
                            </span>
                        </h4>
                        <h4 class="col-md-0 col-lg-0 col-xs-12">
                            <hr>
                            <small>
                                <i class="fa fa-clock-o" style="margin-right: 5px"></i>
                               ' . $infoproducto['entrega'] . ' dias habiles para la entrega <br>
                                <i class="fa fa-shopping-cart" style="margin: 0px 5px"></i>
                                ' . $infoproducto['ventas'] . ' ventas <br>
                                 <i class="fa fa-eye" style="margin: 0px 5px"></i>
                                visto por <span class="vistas" tipo="' . $infoproducto['precio'] . '">' . $infoproducto['vistas'] . '</span> personas
                            </small>
                        </h4>
                        
                        ';
                    }


                }

                ?>
            </div>


            <!--=============================================-->
            <!--BOTONES DE COMPRA-->
            <!--=============================================-->


            <div class="row text-center botonesCompra">


                <?php
                //validando si el producto es gratis
                if ($infoproducto['precio'] == 0) {
                    echo '<div class="col-md-6 col-xs-12">';


                    //Validacion si iniico sesion, para que se registre primero antes de acceder o solaicitar algo gratis
                    if (isset($_SESSION['validarSesion']) && $_SESSION['validarSesion'] == 'ok') {


                    if ($infoproducto['tipo'] == "virtual") {

                        echo '<button class="btn btn-default btn-block btn-lg backColor agregarGratis" idProducto="'.$infoproducto['id'].'" idUsuario="'.$_SESSION['id'].'" tipo="'.$infoproducto['tipo'].'" titulo="'.$infoproducto['titulo'].'"><small>ACCEDER AHORA</small></button>';
                    } else {
                        echo '<button class="btn btn-default btn-block btn-lg backColor agregarGratis" idProducto="'.$infoproducto['id'].'" idUsuario="'.$_SESSION['id'].'" tipo="'.$infoproducto['tipo'].'" titulo="'.$infoproducto['titulo'].'" ><small>SOLICITAR AHORA</small></button>
                            <br> <div class="col-xs-12 alert alert-info text-left">
                                    <strong>¡Atencion!</strong>
                                        El producto a solicitar es totalmente gratuito y se enviara la direccion solicitada, solo se cobraran cargos de Envio.
                                </div>';
                    }

                }else{
                        if ($infoproducto['tipo'] == "virtual") {

                            echo '<a class="btn btn-default btn-block btn-lg backColor" href="#modalIngreso" data-toggle="modal"><small>ACCEDER AHORA</small></a>';
                        } else {
                            echo '<a class="btn btn-default btn-block btn-lg backColor" href="#modalIngreso" data-toggle="modal"><small>SOLICITAR AHORA</small></a>';
                        }

                    }
                    echo '</div>';
                } else {

                    //validando si el producto es fisico o virtual
                    if ($infoproducto['tipo'] == "virtual") {
                        echo ' 
                     <div class="col-md-6 col-xs-12">';

                        if (isset($_SESSION["validarSesion"])) {

                            if ($_SESSION["validarSesion"] == "ok") {

                                echo '<a id="btnCheckout" href="#modalComprarAhora" data-toggle="modal" idUsuario="' . $_SESSION["id"] . '">
                                    
                                     <button class="btn btn-default btn-block btn-lg "><small>COMPRAR AHORA</small></button></a>
                                    ';

                            }


                        } else {

                            echo '<a href="#modalIngreso" data-toggle="modal"><button class="btn btn-default btn-block btn-lg "><small>COMPRAR AHORA</small></button></a>';
                        }


                        echo '</div>
 
                       <div class="col-md-6 col-xs-12">
                                <button class="btn btn-default btn-block btn-lg backColor agregarCarrito" idProducto="' . $infoproducto['id'] . '"
                                imagen="' . $servidor . $infoproducto['portada'] . '"
                                titulo="' . $infoproducto['titulo'] . '"
                                precio="' . $infoproducto['precio'] . '" tipo="' . $infoproducto['tipo'] . '" peso="' . $infoproducto['peso'] . '"><small>ADICIONAR AL CARRITO</small> <i
                                            class="fa fa-shopping-cart col-xs-0 col-md-0"></i></button>
                            </div>';
                    } else {
                        echo ' <div class="col-md-6 col-xs-12">
                                <button class="btn btn-default btn-block btn-lg backColor agregarCarrito" idProducto="' . $infoproducto['id'] . '"
                                imagen="' . $servidor . $infoproducto['portada'] . '"
                                titulo="' . $infoproducto['titulo'] . '"
                                precio="' . $infoproducto['precio'] . '" tipo="' . $infoproducto['tipo'] . '" peso="' . $infoproducto['peso'] . '">ADICIONAR AL CARRITO <i
                                            class="fa fa-shopping-cart col-xs-0"></i></button>
                            </div>';
                    }


                }

                ?>


            </div>


            <!--=============================================-->
            <!--ZONA DE LUPA-->
            <!--=============================================-->
            <figure class="lupa">
                <img src="" alt="">
            </figure>

        </div>
    </div>


    <!--=============================================-->
    <!--COMENTARIOS-->
    <!--=============================================-->
    <br>
    <div class="row">


        <?php

        //Instanciando la clase que contiene el contrllado de los comentarios
        $datos = [   // le pasamos el idUsuario vacio, ya q en el modelo lo requiere, pero aun asi nos devolvera todos los ocment por idPorducto
            "idUsuario" => "",
            "idProducto" => $infoproducto['id']
        ];

        $cantidad = 0;

        $comentarios = ControladorUsuarios::ctrMostrarComentariosPerfil($datos);


        // var_dump($comentarios);


        foreach ($comentarios as $key => $value) {
            //validamos que el comentario sea diferente de null o vacio, de ser asi es por que ya se escribio algun comentario
            //ya que al comprar el producto se genera un comentario, como registro pero vacio este campo

            if ($value['comentario'] != "") {
                // alacenamos la cantidad de los comentario
                $cantidad += count($value['id']);

            }

        }

        ?>


        <ul class="nav nav-tabs">

            <?php

            // si no hay comentarios
            if ($cantidad == 0) {
                echo '
                    <li class="active">
                    <a>
                    ESTE PRODUCTO NO TIENE COMENTARIOS
</a>
                    
</li><li></li>
                    ';
            } else {
                // si hay comentarios
                echo '
                     <li class="active">
                    <a>COMENTARIOS ' . $cantidad . '</a>
                </li>
                 <li><a href="" id="verMas">VER MAS</a></li>
                    ';

                //recorreremos de nuevo el reusltado para calcular el promedio de calificacion
                $sumaCalificacion = 0;
                for ($i = 0; $i < $cantidad; $i++) {
                    $sumaCalificacion += $comentarios[$i]['calificacion'];
                }

                //var_dump($sumaCalificacion);
                $promedio = round($sumaCalificacion / $cantidad);
                //var_dump($promedio);


                //imprimidmos el promedio con las estrellitas
                echo '
                      <li class="pull-right">
                    <a href="" class="text-muted">
                        PROMEDIO DE CALIFICACION: ' . $promedio . ' | ';

                //valodacion del promedio para colocarlas estrellas
                if ($promedio >= 0 && $promedio < 0.5) {

                    echo '<i class="fa fa-star-half-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 0.5 && $promedio < 1) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 1 && $promedio < 1.5) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-half-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 1.5 && $promedio < 2) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 2 && $promedio < 2.5) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-half-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 2.5 && $promedio < 3) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 3 && $promedio < 3.5) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-half-o text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 3.5 && $promedio < 4) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-o text-success"></i>';

                } else if ($promedio >= 4 && $promedio < 4.5) {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star-half-o text-success"></i>';

                } else {

                    echo '<i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>
							  <i class="fa fa-star text-success"></i>';

                }


                echo '</a>
                </li>
                    ';

            }
            ?>


        </ul>
        <br>
    </div>
    <div class="row comentarios">

        <?php


        foreach ($comentarios as $key => $value) {

            //si el comentario es diferente de vacio
            if ($value['comentario'] != "") {
                $item = "id";
                $valor = $value["id_usuario"];

                $usuario = ControladorUsuarios::ctrMostrarUsuario($item, $valor);

                //var_dump($usuario);

                echo '
                       <div class="panel-group col-md-3 col-sm-6 col-xs-12 alturaComentarios">
                <div class="panel panel-default">
                    <div class="panel-heading text-uppercase">
                        ' . $usuario['nombre'] . '
                        <span class="text-right">';

                /*Validacion de modo para traer correctamnete la imagen por url*/
                if ($usuario['modo' == 'directo']) {


                    //validacion si la foto esta vacia


                    if ($usuario['foto'] == '') {
                        echo '
                              <img class="img-circle pull-right" src="' . $servidor . 'vistas/img/usuarios/default/anonymous.png" alt=""
                             width="20%">
                            ';
                    } else {
                        echo '
                              <img class="img-circle pull-right" src="' . $url . $usuario['foto'] . '" alt=""
                             width="20%">
                            ';
                    }

                } else {
                    echo '
                              <img class="img-circle pull-right" src="' . $usuario['foto'] . '" alt=""
                             width="20%">
                            ';
                }


                echo '</span>
                    </div>
                    <div class="panel-body">
                        <small>
                            ' . $value['comentario'] . '
                        </small>
                    </div>
                    <div class="panel-footer">';


                switch ($value['calificacion']) {

                    case 0.5:
                        echo '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 1.0:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 1.5:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 2.0:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 2.5:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 3.0:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 3.5:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 4.0:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-o text-success" aria-hidden="true"></i>';
                        break;

                    case 4.5:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star-half-o text-success" aria-hidden="true"></i>';
                        break;

                    case 5.0:
                        echo '<i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>
																  <i class="fa fa-star text-success" aria-hidden="true"></i>';
                        break;

                }


                echo '</div>
                </div>
            </div>
                
                ';


            }

        }


        ?>


    </div>
</div>
</div>
<!--=============================================-->
<!--ARTICULOS RELACIONADOS-->
<!--=============================================-->

<hr>
<?php
echo '<div class="container-fluid productos">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 tituloDestacado">
                <div class="col-sm-6 col-xs-12">
                    <h1>
                        <small>PRODUCTOS RELACIONADOS</small>
                    </h1>
                </div>';
$item = "id";
$valor = $infoproducto['id_categoria'];
//hacemos la consulta para traer los detstacados similares al producto abierto
$rutaArticulosDestacados = ControladorProductos::ctrMostrarSubCategorias($item, $valor);
//var_dump($rutaArticulosDestacados[0]['ruta']); //categoria del producto actual

echo '<div class="col-sm-6 col-xs-12">
                    <a href="' . $url . $rutaArticulosDestacados[0]['ruta'] . '">
                        <button class="btn btn-default backColor pull-right">
                            <span class="fa fa-angle-rigth"></span> VER MAS
                        </button>
                    </a>
                </div>
            </div>

        </div>
        <hr>';


//para traer los 4 articulos del controlador, definimos los parametros
$ordenar = "";
$item = "id_subcategoria";
$valor = $infoproducto['id_subcategoria'];
$base = 0;
$tope = 4;
$modo = "Rand()"; //enviaremos la funcion para que escoja aleatoriamente

$relacionados = ControladorProductos::ctrMostrarProductos($ordenar, $item, $valor, $base, $tope, $modo);
//validando si viene informacion, de lo contrario mostrresmo un mensaje
if (!$relacionados) {
    echo '<div class="col-xs-12 error404">
        <h1>
        <small>!Oops¡</small>    
    </h1>
    <h2>No hay productos relacionados</h2>
    </div>';
} else {
    echo '<ul class="grid0">';
    foreach ($relacionados as $key => $value) {
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


        //0 -> en la BD siginidica que no es nuevo
        if ($value['nuevo'] != 0) {
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
    echo '</ul></div></div>';
}


?>


<!--=====================================
VENTANA MODAL PARA CHECKOUT
======================================-->

<div id="modalComprarAhora" class="modal fade modalFormulario" role="dialog">

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
