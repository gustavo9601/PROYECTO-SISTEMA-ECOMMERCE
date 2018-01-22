<?php


class ControladorUsuarios
{

    /*========================================*/
    /*REGISTRO DE USUARIO*/
    /*========================================*/
    static public function ctrRegistroUsuario()
    {
        if (isset($_POST['regUsuario'])) {
            /*Validando lo que venga por post, y validando que estengo, santeizadas los compaos*/
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["regUsuario"]) &&
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["regEmail"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["regPassword"])
            ) {

                $encriptar = crypt($_POST["regPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');


                //encritamos en MD5 para que se ecnripte solo en alfanumerico sin caracteres especiales
                $encriptarEmail = md5($_POST["regEmail"]);

                $datos = array("nombre" => $_POST["regUsuario"],
                    "password" => $encriptar,
                    "email" => $_POST["regEmail"],
                    "foto" => "",
                    "modo" => "directo",
                    "verificacion" => 1,  // 1 siginifica que no ha verificado su cuenta, y 0 que si
                    "emailEncriptado" => $encriptarEmail);


                $tabla = "usuarios";

                $respuesta = @ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);

                if ($respuesta == 'ok') {
                    /*=============================================
                VERIFICACIÓN CORREO ELECTRÓNICO
                =============================================*/
                    //definimos sona horaria para enviar el correo
                    date_default_timezone_set("America/Bogota");

                    $url = @Ruta::ctrRuta();
                    //instancioamos la libreria
                    $mail = new PHPMailer;

                    $mail->CharSet = 'UTF-8';

                    $mail->isMail();
                    //de donde se va a enviar el correo
                    $mail->setFrom('ing.gustavo.marquez@gmail.com', 'Ingeniero Gustavo');
                    // responder el correo a
                    $mail->addReplyTo('ing.gustavo.marquez@gmail.com', 'Ingeniero Gustavo');
                    // asunto
                    $mail->Subject = "Por favor verifique su dirección de correo electrónico";
                    //email de destinatario
                    $mail->addAddress($_POST["regEmail"]);
                    // Mensaje que se enviara, com omaqueta HTML
                    $mail->msgHTML('<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
						
						<center>
							
							<img style="padding:20px; width:10%" src="http://tutorialesatualcance.com/tienda/logo.png">

						</center>

						<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
						
							<center>
							
							<img style="padding:20px; width:15%" src="http://tutorialesatualcance.com/tienda/icon-email.png">

							<h3 style="font-weight:100; color:#999">VERIFIQUE SU DIRECCIÓN DE CORREO ELECTRÓNICO</h3>

							<hr style="border:1px solid #ccc; width:80%">

							<h4 style="font-weight:100; color:#999; padding:0 20px">Para comenzar a usar su cuenta de Tienda Virtual, debe confirmar su dirección de correo electrónico</h4>

							<a href="' . $url . 'verificar/' . $encriptarEmail . '" target="_blank" style="text-decoration:none">

							<div style="line-height:60px; background:#0aa; width:60%; color:white">Verifique su dirección de correo electrónico</div>

							</a>

							<br>

							<hr style="border:1px solid #ccc; width:80%">

							<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

							</center>

						</div>

					</div>');

                    $envio = $mail->Send();

                    if (!$envio) {
                        echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Ha Ocurrido un problema, enviando verificacion de correo electronico a ' . $_POST["regEmail"] . $mail->ErrorInfo . '!",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }

								
							});

						</script>';
                    } else {
                        /*Si se envio el correo al usuario muestra la alerta de revisar el mail*/
                        //Debe realizar la verificacion de correo electronico
                        echo '<script> 

							swal({
								  title: "¡OK!",
								  text: "¡Por favor revise la bandeja de entrada de su correo electronico,' . $_POST["regEmail"] . ' para verificar su cuenta!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }

								
							});

						</script>';
                    }


                }
            } else {
                echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Error al registrar el usuario, no se permiten caracteres especiales",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }

								
							});

						</script>';
            }
        } else {


        }
    }

    /*========================================*/
    /*MOSTRAR USUARIO*/
    /*========================================*/
    static public function ctrMostrarUsuario($item, $valor)
    {
        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

        return $respuesta;

    }




    /*=========================================*/
    /*ACTUALIZAR USUARIO*/
    /*=========================================*/


    static public function ctrActualizarUsuario($id, $item2, $valor2)
    {
        $tabla = "usuarios";

        $respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item2, $valor2);

        return $respuesta;

    }


    /*=========================================*/
    /*INGRESO DE USUARIO*/
    /*=========================================*/


    static public function ctrIngresoUsuario()
    {

        if (isset($_POST['ingEmail'])) {
            if (
                preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["ingEmail"]) &&
                preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])
            ) {


                $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
                $tabla = "usuarios";
                $item = "email";
                $valor = $_POST["ingEmail"];

                $respuesta = ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

                /*Validacion junto con la BD*/
                if ($respuesta["email"] == $_POST["ingEmail"] && $respuesta["password"] == $encriptar) {
                    //validacion con la BD si ya esta verficado el email
                    if ($respuesta['verificacion'] == 1) {
                        echo '<script> 

							swal({
								  title: "¡NO HA VERIFICADO SU CORREO ELECTRONICO!",
								  text: "¡Por favor revise la bandeja de entrada o la carpeta de SPAM, para verifcar la direccion de correo electronico  ' . $_POST["ingEmail"] . '" ,
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }

								
							});

						</script>';
                    } else {

                        /*Variables de sesion*/

                        @session_start();
                        $_SESSION['validarSesion'] = 'ok';
                        $_SESSION['id'] = $respuesta['id'];
                        $_SESSION['nombre'] = $respuesta['nombre'];
                        $_SESSION['foto'] = $respuesta['foto'];
                        $_SESSION['email'] = $respuesta['email'];
                        $_SESSION['password'] = $respuesta['password'];
                        $_SESSION['modo'] = $respuesta['modo'];

                        //Utilizando del local storgae, alcenamos la ruta, para cuando inicie sesion, sea redireccionado hacia la ruta
                        echo '
                    <script> 
                        window.location = localStorage.getItem("rutaActual");
                    </script>
                    ';


                    }
                } else {
                    echo '<script> 

							swal({
								  title: "¡ERROR AL INGRESAR!",
								  text: "¡Por favor revise el correo electronico, o la contraseña" ,
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							           window.location = localStorage.getItem("rutaActual");
							    }

								
							});

						</script>';
                }


            } else {
                echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Error al ingresar al sistema, no se permiten caracteres especiales",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }

								
							});

						</script>';
            }
        }


    }



    /*=========================================*/
    /*OLVIDO DE CONTRASEÑA*/
    /*=========================================*/
    static public function ctrOlvidoPassword()
    {
        if (isset($_POST['passEmail'])) {

            if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["passEmail"])) {

                /*Generando contraseña aleatorioa*/
                function generarPassword($longitud)
                {

                    $key = "";
                    $pattern = "123456789abcdefghijklmnopqrstuvwxyz";
                    $max = strlen($pattern) - 1; // menos ya que emepzara desde 0

                    for ($i = 0; $i < $longitud; $i++) {
                        $key .= $pattern{mt_rand(0, $max)};  // escogera aleatoriamente una letra del string de arriba
                    }

                    return $key;

                }

                //genero el nuevo password
                $nuevaPassword = generarPassword(11);
                //encript el password para actualizarlo a la BD
                $encriptar = crypt($nuevaPassword, '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

                // consultamos en la BD el id del usuario que de acuerdo al mail ingresado en el input
                $tabla = "usuarios";

                $item1 = 'email';
                $valor1 = $_POST['passEmail'];
                $respuesta1 = ModeloUsuarios::mdlMostrarUsuario($tabla, $item1, $valor1);

                //si retorna informacion es por que si existe, entonces actualizamos en la BD el usuario
                if ($respuesta1) {
                    $id = $respuesta1['id'];
                    $item2 = 'password';
                    $valor2 = $encriptar;

                    $respuesta2 = ModeloUsuarios::mdlActualizarUsuario($tabla, $id, $item2, $valor2);

                    //si se acutualizo correctamente, enviaremos la contraseña al usuario al email , con la contraseña normal sin exriptacion
                    if ($respuesta2 == 'ok') {


                        /*=============================================
            CAMBIO DE CONTRASEÑA
             =============================================*/
                        //definimos sona horaria para enviar el correo
                        date_default_timezone_set("America/Bogota");

                        $url = @Ruta::ctrRuta();
                        //instancioamos la libreria
                        $mail = new PHPMailer;

                        $mail->CharSet = 'UTF-8';

                        $mail->isMail();
                        //de donde se va a enviar el correo
                        $mail->setFrom('ing.gustavo.marquez@gmail.com', 'Ingeniero Gustavo');
                        // responder el correo a
                        $mail->addReplyTo('ing.gustavo.marquez@gmail.com', 'Ingeniero Gustavo');
                        // asunto
                        $mail->Subject = "SOLICITUD DE NUEVA CONTRASEÑA";
                        //email de destinatario
                        $mail->addAddress($_POST["passEmail"]);
                        // Mensaje que se enviara, com omaqueta HTML
                        $mail->msgHTML('
                    

<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
	
	<center>
		
		<img style="padding:20px; width:10%" src="http://tutorialesatualcance.com/tienda/logo.png">

	</center>

	<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
	
		<center>
		
		<img style="padding:20px; width:15%" src="http://tutorialesatualcance.com/tienda/icon-pass.png">

		<h3 style="font-weight:100; color:#999">SOLICITUD DE NUEVA CONTRASEÑA</h3>

		<hr style="border:1px solid #ccc; width:80%">

		<h4 style="font-weight:100; color:#999; padding:0 20px"><strong>Su nueva contraseña: </strong>' . $nuevaPassword . '</h4>

		<a href="' . $url . '" target="_blank" style="text-decoration:none">

		<div style="line-height:60px; background:#0aa; width:60%; color:white">Ingrese nuevamente al sitio</div>

		</a>

		<br>

		<hr style="border:1px solid #ccc; width:80%">

		<h5 style="font-weight:100; color:#999">Si no se inscribió en esta cuenta, puede ignorar este correo electrónico y la cuenta se eliminará.</h5>

		</center>

	</div>

</div>
               ');

                        $envio = $mail->Send();

                        if (!$envio) {
                            echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Ha Ocurrido un problema, enviando cambio de contraseña a ' . $_POST["passEmail"] . $mail->ErrorInfo . '!",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }

								
							});

						</script>';
                        } else {
                            /*Si se envio el correo al usuario muestra la alerta de revisar el mail*/
                            //Debe realizar la verificacion de correo electronico
                            echo '<script> 

							swal({
								  title: "¡OK!",
								  text: "¡Por favor revise la bandeja de entrada de su correo electronico,' . $_POST["regEmail"] . ' para verificar su cambio de contraseña!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }

								
							});

						</script>';
                        }


                    }

                } else {
                    echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡El correo electronico, no esta registrado en el sistema !",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }
							});
						</script>';
                }


            } else {
                echo '<script> 

							swal({
								  title: "¡ERROR!",
								  text: "¡Error al enviar el correo electronico, no se permiten caracteres especiales o esta mal escrito el correo",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }
							});
						</script>';
            }


        }
    }




    /*=========================================*/
    /*REGISTRO CON REDES SOCIALES FACEBOOK - GOOGLE*/
    /*=========================================*/
    static public function ctrRegistroRedesSociales($datos)
    {
        $tabla = "usuarios";
        $item = "email";
        $valor = $datos['email'];
        $emailRepetido = false;
        $respuesta = '';

        //validacion si al realizar la consulta por el correo, este ya se encuetntra repetido
        $respuesta0 = @ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);
        if ($respuesta0) {
            $emailRepetido = true;
        } else {

            /*Si no viene con informacion filtrado por email, registramos el usuario*/
            $respuesta = @ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);
        }


        /*Validacion si ya esta creado el email, o si se recibe un ok en el registro cremos las sesiones*/
        if ($emailRepetido || $respuesta == 'ok') {


            //seleccionamos la informacion del usuario insertado, filtrado por el email
            $respuesta2 = @ModeloUsuarios::mdlMostrarUsuario($tabla, $item, $valor);

            //si se inserto por facebook
            if ($respuesta2["modo"] == "facebook") {
                @session_start();
                $_SESSION['validarSesion'] = 'ok';
                $_SESSION['id'] = $respuesta2['id'];
                $_SESSION['nombre'] = $respuesta2['nombre'];
                $_SESSION['foto'] = $respuesta2['foto'];
                $_SESSION['email'] = $respuesta2['email'];
                $_SESSION['password'] = $respuesta2['password'];
                $_SESSION['modo'] = $respuesta2['modo'];

                echo 'ok';

            } else {

                echo "";

            }


        }
    }
    /*====================================*/
    /*actualizar perfil*/
    /*====================================*/
    static public function ctrActualizarPerfil()
    {
        //validando que se halla enviado por post con el btn
        if (isset($_POST['editarNombre'])) {


            /*====================================*/
            /*VALIDAR IMAGEN QUE SUBE COMO FOTO*/
            /*====================================*/
            $ruta = "";
            $directorio = "vistas/img/usuarios/{$_POST['idUsuario']}";
            if (isset($_FILES['datosImagen']['tmp_name'])) {

                //primero preuntamos si existe otra imagen en la base de datos
                if (!empty($_POST['foto'])) {  // valido el post oculto de foto
                    unlink($_POST['foto']);  //eliminamos el archivo en el hosting
                    unlink($directorio);
                } else {
                    // si no existe ninguna imagen, creamos el directorio
                    @mkdir($directorio, 0755); // pasamos el directorio, y los permisos
                }


                $aleatorio = mt_rand(100, 999);
                $ruta = "vistas/img/usuarios/{$_POST['idUsuario']}/" . $aleatorio . ".jpg";  // ruta de la foto a almcenar

                //Modificamos tamaño de la foto
                //capturao en un array las medidas ancho y alto
                // list (0 , 1) // indices
                list($ancho, $alto) = getimagesize($_FILES['datosImagen']['tmp_name']);

                $nuevoAncho = 500;
                $nuevoAlto = 500;


                /*=====================================*/
                /*SOLO SIRVE PARA IAMGEN JPG JPEG*/
                /*=====================================*/

                //creamos una nueva imagen
                $origen = imagecreatefromjpeg($_FILES['datosImagen']['tmp_name']);

                $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
                //cortamos la imagen pasando los parametros
                //(destino, origen, posicionx, posiciony, )
                imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

                imagejpeg($destino, $ruta);


            }


            //validacion si se escibio algo en el input de contraseña
            if ($_POST['editarPassword'] != "") {
                $password = $_POST['passUsuario'];
            } else {

                $password = crypt($_POST['editarPassword'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

            }


            $datos = [
                'nombre' => $_POST['editarNombre'],
                'email' => $_POST['editarEmail'],
                'password' => $password,
                'foto' => $ruta,
                'id' => $_POST['idUsuario']
            ];

            $tabla = 'usuarios';
            $respuesta = @ModeloUsuarios::mdlActualizarPerfil($tabla, $datos);

            if ($respuesta == 'ok') {
                //si se ejcuto el update, actualizacmos las variables de sesion del usuario

                @session_start();
                $_SESSION['validarSesion'] = 'ok';
                $_SESSION['id'] = $datos['id'];
                $_SESSION['nombre'] = $datos['nombre'];
                $_SESSION['foto'] = $datos['foto'];
                $_SESSION['email'] = $datos['email'];
                $_SESSION['password'] = $datos['password'];
                $_SESSION['modo'] = $_POST['modoUsuario'];

                echo '<script> 

							swal({
								  title: "¡OK!",
								  text: "¡Su cuenta ha sido actualizada correctamente",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								},
								function (isConfirm){
							    if(isConfirm){
							        history.back();
							    }
							});
						</script>';

            }

        }
    }














    /*====================================*/
    /*Bloque de mostrar compras po usuario*/
    /*====================================*/
    static public function ctrMostrarCompras($item, $valor)
    {
        $tabla = "compras";

        $respuesta = ModeloUsuarios::mdlMostrarCompras($tabla, $item, $valor);

        return $respuesta;

    }


    /*====================================*/
    /*Devovlera el comentario por Persona y por Id del prodycto*/
    /*====================================*/
    static public function ctrMostrarComentariosPerfil($datos)
    {
        $tabla = "comentarios";

        $respuesta = ModeloUsuarios::mdlMostrarComentariosPerfil($tabla, $datos);

        return $respuesta;

    }



    /*====================================*/
    /*Actualizar comentarios*/
    /*====================================*/


    public function ctrActualizarComentario()
    {
        //validacion del idCOmentario que es un input hidden
        if (isset($_POST["idComentario"])) {

            if (preg_match('/^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["comentario"])) {
                //si se envio el POST  decomentario
                if ($_POST["comentario"] != "") {

                    $tabla = "comentarios";

                    //pasamos los datos para actualizar el registro
                    $datos = array("id" => $_POST["idComentario"],
                        "calificacion" => $_POST["puntaje"],
                        "comentario" => $_POST["comentario"]);


                    //actualizacion en la BD
                    $respuesta = ModeloUsuarios::mdlActualizarComentario($tabla, $datos);

                    if ($respuesta == "ok") {
                        //var_dump($datos);
                        echo '<script>
								swal({
									  title: "¡GRACIAS POR COMPARTIR SU OPINIÓN!",
									  text: "¡Su calificación y comentario ha sido guardado!",
									  type: "success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
								},

								function(isConfirm){
										 if (isConfirm) {	   
										   history.back();
										  } 
								});

							  </script>';

                    } else {
                        echo '<script>

								swal({
									  title: "¡ERROR!",
									  text: "¡Error de bases de datos!",
									  type: "error",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
								},

								function(isConfirm){
										 if (isConfirm) {	   
										   history.back();
										  } 
								});

							  </script>';
                    }

                } else {

                    echo '<script>

						swal({
							  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
							  text: "¡El comentario no puede estar vacío!",
							  type: "error",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
						},

						function(isConfirm){
								 if (isConfirm) {	   
								   history.back();
								  } 
						});

					  </script>';

                }

            } else {

                echo '<script>

					swal({
						  title: "¡ERROR AL ENVIAR SU CALIFICACIÓN!",
						  text: "¡El comentario no puede llevar caracteres especiales!",
						  type: "error",
						  confirmButtonText: "Cerrar",
						  closeOnConfirm: false
					},

					function(isConfirm){
							 if (isConfirm) {	   
							   history.back();
							  } 
					});

				  </script>';

            }

        }

    }
}

