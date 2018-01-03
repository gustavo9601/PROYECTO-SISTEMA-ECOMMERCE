<?php
$social = @ControladorPlantilla::ctrEstilosPlantilla();
//json_decode($json , TRUE) //convertimos un json a array
$jsonRedesSociales = json_decode($social['redesSociales'], true);

//Categorias
//dejamos las variables nullas, ya que no las usamo en los paramtros
$item = null;
$valor = null;
$categorias = ControladorProductos::ctrMostrarCategorias($item, $valor);

$servidor = @Ruta::ctrRutaServidor();
$url = @Ruta::ctrRuta();
?>

<!--=====================================
TOP
======================================-->

<div class="container-fluid barraSuperior" id="top">

    <div class="container">

        <div class="row">

            <!--=====================================
            REDES OCIALES
            ======================================-->

            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 social">
                <ul>
                    <?php
                    /*
                     * TRALLENDO DINAMICAMENTE LOS ICONOS DE REDES SOCIALES
                     * */
                    //recorremos el array de redes sociales
                    foreach ($jsonRedesSociales as $dato => $valor) {
                        echo '<li>
                                 <a href="' . $valor['url'] . '" target="_blank">
                                     <i class="fa ' . $valor['red'] . ' redSocial ' . $valor['estilo'] . '" aria-hidden="true"></i>
                                  </a>
                              </li>';
                    };
                    ?>
                </ul>
            </div>

            <!--=====================================
            REGISTRO DE USUARIOS
            ======================================-->
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 registro">

                <ul>
                    <!--llamaran modales-->
                    <li><a href="#modalIngreso" data-toggle="modal">Ingresar</a></li>
                    <li>|</li>
                    <li><a href="#modalRegistro" data-toggle="modal">Crear una cuenta</a></li>

                </ul>

            </div>

        </div>

    </div>

</div>

<!--=====================================
HEADER
======================================-->

<header class="container-fluid">

    <div class="container">

        <div class="row" id="cabezote">

            <!--=====================================
            LOGOTIPO
            ======================================-->

            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12" id="logotipo">

                <a href="<?php echo $url; ?>">
                    <img src="<?php echo $servidor . $social['logo']; ?>" class="img-responsive" alt="">
                </a>

            </div>

            <!--=====================================
            BLOQUE CATEGORÍAS Y BUSCADOR
            ======================================-->

            <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">

                <!--=====================================
                BOTÓN CATEGORÍAS
                ======================================-->

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 backColor" id="btnCategorias">

                    <p>CATEGORÍAS
                        <span class="pull-right">
							<i class="fa fa-bars" aria-hidden="true"></i>
						</span>
                    </p>

                </div>

                <!--=====================================
                BUSCADOR
                ======================================-->

                <div class="input-group col-lg-8 col-md-8 col-sm-8 col-xs-12" id="buscador">

                    <input type="search" name="buscar" class="form-control" placeholder="Buscar...">

                    <span class="input-group-btn">
						
						<a href="<?php echo $url; ?>buscador/1/recientes">
							<button class="btn btn-default backColor" type="submit">
								<i class="fa fa-search"></i>
							</button>
						</a>
					</span>
                </div>
            </div>

            <!--=====================================
            CARRITO DE COMPRAS
            ======================================-->

            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12" id="carrito">

                <a href="#">

                    <button class="btn btn-default pull-left backColor">

                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>

                    </button>

                </a>

                <p>TU CESTA <span class="cantidadCesta">3</span> <br> USD $ <span class="sumaCesta">20</span></p>

            </div>

        </div>

        <!--=====================================
        SECCION DE CATEGORÍAS
        ======================================-->
        <div class="col-lg-12 col-md-12 col-xs-12 backColor" id="categorias">

            <?php
            foreach ($categorias as $dato) {
                echo '<div class="col-lg-2 col-md-3 col col-sm-4 col-xs-12">
                        <h4>
                            <a href="' . $url . $dato['ruta'] . '" class="pixelCategorias">' . $dato['categoria'] . '</a>
                        </h4>
                        <hr>
                        <ul>';

                //le pasamos el id d ela categoria
                $valor = $dato['id'];
                $item = "id_categoria"; //esta es la columna de la tabla subcategorias
                $subCategorias = @ControladorProductos::ctrMostrarSubCategorias($item, $valor);
                //lleganod dinamico de subcategorias
                foreach ($subCategorias as $dato2) {
                    echo '<li><a href="' . $url . $dato2['ruta'] . '" class="pixelSubCategorias">' . $dato2['subcategoria'] . '</a></li>';
                }
                echo '</ul>
                    </div>';
            }
            ?>
        </div>

    </div>

</header>


<!--=====================================
       MODAL DE REGISTRASE O INICIAR SESION
       ======================================-->

<div class="modal fade modalFormulario" id="modalRegistro" role="dialog">
    <div class="modal-dialog modal-content">
        <div class="modal-body modalTitulo">
            <h3 class="backColor">REGISTRARSE</h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

            <!--=====================================
       REGISTRO CON FACEBOOK
       ======================================-->
            <div class="col-sm-6 col-xs-12 facebook" id="btnFacebookRegistro">
                <p>
                    <i class="fa fa-facebook"></i>
                    Registro con Facebook
                </p>
            </div>

            <!--=====================================
       REGISTRO CON GOOGLE
       ======================================-->

            <div class="col-sm-6 col-xs-12 google" id="btnGoogleRegistro">
                <p>
                    <i class="fa fa-google"></i>
                    Registro con Google
                </p>
            </div>


            <!--=====================================
       REGISTRO DIRECTO
       ======================================-->
            <form action="post" onsubmit="return resgistroUsuario();">
                <hr>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-user"></i>
                        </span>
                        <input type="text" class="form-control text-uppercase" id="regUsuario" name="regUsuario"
                               placeholder="Nombre Completo" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-envelope"></i>
                        </span>
                        <input type="email" class="form-control" id="regEmail" name="regEmail"
                               placeholder="Correo electronico" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-lock"></i>
                        </span>
                        <input type="password" class="form-control text-uppercase" id="regPassword" name="regPassword"
                               placeholder="Contraseña" required>
                    </div>
                </div>

                <!--=====================================
              REGISTRO DIRECTO
              ======================================-->

                <div class="checkBox">
                    <label for="">
                        <input type="checkbox" id="regPoliticas">
                        <small>
                            Acepta nuestras condiciones de uso y politicas de privacidad
                            <!--Codigo de politicas de privacidad-->

                            <a href="//www.iubenda.com/privacy-policy/86257248" class="iubenda-white iubenda-embed"
                               title="Privacy Policy">Leer mas</a>
                            <script type="text/javascript">(function (w, d) {
                                    var loader = function () {
                                        var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0];
                                        s.src = "//cdn.iubenda.com/iubenda.js";
                                        tag.parentNode.insertBefore(s, tag);
                                    };
                                    if (w.addEventListener) {
                                        w.addEventListener("load", loader, false);
                                    } else if (w.attachEvent) {
                                        w.attachEvent("onload", loader);
                                    } else {
                                        w.onload = loader;
                                    }
                                })(window, document);</script>
                        </small>
                    </label>
                </div>


                <input type="submit" class="btn btn-default backColor btn-block" value="ENVIAR">


            </form>

        </div>
        <div class="modal-footer">
            ¿Ya tienes una cuenta registrada ? | <strong><a href="#modalIngreso" data-dismiss="modal"
                                                            data-toggle="modal">Ingresar</a></strong>
        </div>
    </div>
</div>
</div>