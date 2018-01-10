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


}

