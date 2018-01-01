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


                    for ($i = 0; $i < count($multimedia); $i++) {
                        echo '<img id="lupa' . ($i + 1) . '" class="img-thumbnail"
                         src="' . $servidor . $multimedia[$i]['foto'] . '"
                         alt="">';
                    }
                    echo '
                </figure>
                <div class="flexslider">
                    <ul class="slides">';

                    for ($i = 0; $i < count($multimedia); $i++) {
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
                </div>

                <div class="clearfix"></div>

                <!--=============================================-->
                <!--ESPACIO PARA EL PRODUCTO-->
                <!--=============================================-->

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
                        if ($infoproducto['tipo'] == "virtual") {

                            echo '<button class="btn btn-default btn-block btn-lg backColor"><small>ACCEDER AHORA</small></button>';
                        } else {
                            echo '<button class="btn btn-default btn-block btn-lg backColor"><small>SOLICITAR AHORA</small></button>';
                        }
                        echo '</div>';
                    } else {

                        //validando si el producto es fisico o virtual
                        if ($infoproducto['tipo'] == "virtual") {
                            echo ' 
                     <div class="col-md-6 col-xs-12">
                            <button class="btn btn-default btn-block btn-lg "><small>COMPRAR AHORA</small></button>
                        </div>
 
                       <div class="col-md-6 col-xs-12">
                                <button class="btn btn-default btn-block btn-lg backColor"><small>ADICIONAR AL CARRITO</small> <i
                                            class="fa fa-shopping-cart col-xs-0 col-md-0"></i></button>
                            </div>';
                        } else {
                            echo ' <div class="col-md-6 col-xs-12">
                                <button class="btn btn-default btn-block btn-lg backColor">ADICIONAR AL CARRITO <i
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
            <ul class="nav nav-tabs">
                <li class="active">
                    <a>COMENTARIOS 4</a>
                </li>
                <li><a href="#">VER MAS</a></li>
                <li class="pull-right">
                    <a href="" class="text-muted">
                        PROMEDIO DE CALIFICACION: 3.5 |
                        <i class="fa fa-star text-success"></i>
                        <i class="fa fa-star text-success"></i>
                        <i class="fa fa-star text-success"></i>
                        <i class="fa fa-star-half-o text-success"></i>
                        <i class="fa fa-star-o text-success"></i>
                    </a>
                </li>
            </ul>
            <br>
        </div>
        <div class="row comentarios">
            <div class="panel-group col-md-3 col-sm-6 col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-uppercase">
                        Gustavo Marquez
                        <span class="text-right">
                        <img class="img-circle" src="<?php echo $url; ?>vistas/img/usuarios/40/944.jpg" alt=""
                             width="20%">
                    </span>
                    </div>
                    <div class="panel-body">
                        <small>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid in incidunt minima nisi
                            obcaecati quidem!
                        </small>
                    </div>
                    <div class="panel-footer">
                        <i class="fa fa-star text-success"></i>
                        <i class="fa fa-star text-success"></i>
                        <i class="fa fa-star text-success"></i>
                        <i class="fa fa-star-half-o text-success"></i>
                        <i class="fa fa-star-o text-success"></i>
                    </div>
                </div>
            </div>
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