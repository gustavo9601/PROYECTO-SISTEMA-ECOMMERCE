<?php
/*==========================================*/
/*VALIDAR SESION*/
/*==========================================*/

$url = @Ruta::ctrRuta();
$servidor = @Ruta::ctrRutaServidor();
//si no existe la variable en el sistema
if (!isset($_SESSION['validarSesion'])) {
    echo '<script>
        window.location = "' . $url . '"
    </script>';

    exit();
}


?>


<!--=====================================
BREADCRUMB PERFIL
======================================-->

<div class="container-fluid well well-sm">

    <div class="container">

        <div class="row">

            <ul class="breadcrumb fondoBreadcrumb text-uppercase">

                <li><a href="<?php echo $url; ?>">INICIO</a></li>
                <li class="active pagActiva"><?php echo $rutas[0] ?></li>

            </ul>

        </div>

    </div>

</div>


<div class="container-fluid">
    <div class="container">
        <ul class="nav nav-tabs">

            <li class="active">
                <a data-toggle="tab" href="#compras">
                    <i class="fa fa-list-ul"></i> MIS COMPRAS</a>
            </li>

            <li>
                <a data-toggle="tab" href="#deseos">
                    <i class="fa fa-gift"></i> MI LISTA DE DESEOS</a>
            </li>

            <li>
                <a data-toggle="tab" href="#perfil">
                    <i class="fa fa-user"></i> EDITAR PERFIL</a>
            </li>

            <li>
                <a href="<?php echo $url; ?>ofertas">
                    <i class="fa fa-star"></i> VER OFERTAS</a>
            </li>

        </ul>


        <div class="tab-content">
            <!--=====================================
                PESTAÑA COMPRAS
            ======================================-->
            <div id="compras" class="tab-pane fade in active">
                <div class="panel-group">
                </div>
            </div>
            <!--=====================================
            PESTAÑA DESEOS
            ======================================-->
            <div id="deseos" class="tab-pane fade in active">
                <div class="panel-group">
                </div>
            </div>

            <!--=====================================
            PESTAÑA PERFIL EDICION PERFIL
            ======================================-->
            <div id="perfil" class="tab-pane fade in active">
                <div class="panel-group">
                    <div class="row">
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="col-md-3 col-sm-4 col-xs-12 text-center">
                                <br>
                                <figure id="imgPerfil">
                                    <?php
                                    //validacion si viene directo o por redes sociales
                                    if ($_SESSION['modo'] == 'directo') {
                                        if ($_SESSION['foto'] != "") {
                                            echo '  
            <img src="' . $url . $_SESSION['foto'] . '" alt="" class="img-thumbnail">
                                        ';
                                        } else {
                                            //colocamos la foto por defecto
                                            echo '  
            <img src="' . $servidor . 'vistas/img/usuarios/default/anonymous.png" alt="" class="img-thumbnail">
                                        ';

                                        }


                                    } else {
                                        echo '  
            <img src="' . $_SESSION['foto'] . '" alt="" class="img-thumbnail">
                                        ';
                                    }
                                    ?>
                                </figure>
                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12 text-center">

                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
