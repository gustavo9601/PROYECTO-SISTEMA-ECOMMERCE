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
                                    //alcanemara dentro del formualario el di del susario
                                    echo '<input type="hidden" name="idUsuario" value="' . $_SESSION['id'] . '">';
                                    //almacenarael password por si el suuario n cambia nada1
                                    echo '<input type="hidden" name="passUsuario" value="' . $_SESSION['password'] . '">';
                                    //alcanamos la foto por si no se cambia
                                    echo '<input type="hidden" name="fotoUsuario" value="' . $_SESSION['foto'] . '">';
                                    //modo oculto
                                    echo '<input type="hidden" name="modoUsuario" value="' . $_SESSION['modo'] . '">';


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


                                <br>

                                <?php


                                if ($_SESSION['modo'] == 'directo') {
                                    echo '
                                    <button type="button" class="btn btn-default" id="btnCambiarFoto">
                                    Cambiar foto de perfil                            
                                    </button>
                                    ';
                                }

                                ?>


                                <div id="subirImagen">
                                    <input type="file" class="form-control"  id="datosImagen" name="datosImagen">
                                    <img class="previsualizar" src="" alt="">
                                </div>

                            </div>
                            <div class="col-md-9 col-sm-8 col-xs-12 text-center">
                                <?php

                                if ($_SESSION['modo'] != 'directo') {
                                    echo '<label class="control-label text-muted text-uppercase">Nombre:</label>
                                            <div class="input-group">
                                             <span class="input-group-addon">
                                             <i class="glyphicon glyphicon-user"></i>
</span>
                        
                                            <input type="text" class="form-control" id="editarNombre" readonly value="' . $_SESSION['nombre'] . '">
</div>

<br>

									<label class="control-label text-muted text-uppercase">Correo electrónico:</label>
									
									<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input type="text" class="form-control"  value="' . $_SESSION["email"] . '" readonly>

									</div>

									<br>


<label class="control-label text-muted text-uppercase">Modo de registro en el sistema:</label>
									
									<div class="input-group">
								
										<span class="input-group-addon"><i class="fa fa-' . $_SESSION["modo"] . '"></i></span>
										<input type="text" class="form-control text-uppercase"  value="' . $_SESSION["modo"] . '" readonly>

									</div>

									<br>

';
                                    //readonly -> deja inhabilitado la edicion del input
                                } else {
                                    echo '<label class="control-label text-muted text-uppercase" for="editarNombre">Cambiar Nombre:</label>
									
									<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input type="text" class="form-control" id="editarNombre" name="editarNombre" value="' . $_SESSION["nombre"] . '">

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarEmail">Cambiar Correo Electrónico:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
										<input type="text" class="form-control" id="editarEmail" name="editarEmail" value="' . $_SESSION["email"] . '">

									</div>

								<br>

								<label class="control-label text-muted text-uppercase" for="editarPassword">Cambiar Contraseña:</label>

								<div class="input-group">
								
										<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="text" class="form-control" id="editarPassword" name="editarPassword" placeholder="Escribe la nueva contraseña">

									</div>

								<br>

								<button type="submit" class="btn btn-default backColor btn-md pull-left">Actualizar Datos</button>';


                                }

                                ?>
                            </div>


                            <?php

                            //instanciando el objeto
                            $actualizarPerfil = NEW ControladorUsuarios();
                            $actualizarPerfil->ctrActualizarPerfil();
                            ?>


                        </form>


                        <button class="btn btn-danger btn-md pull-right" id="eliminarUsuario">Eliminar cuenta</button>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
