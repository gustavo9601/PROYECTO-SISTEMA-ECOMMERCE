/*===============================*/
/*BOTON DE REGISTRAR CON FACEBOOK*/
/*===============================*/

$('.facebook').click(function () {
    //Funcion propia de facebookS
    FB.login(function (response) {
        validarUsuario(); // funcion propia que valida el usuario
    }, {scope: 'public_profile, email'}) // le indicamos a facebook que quiero capturar del usuario
});


/*FUNCION DE VALIDAR EL INGRESO*/
function validarUsuario() {
    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
    });
}

/*VALIDAMOS EL CAMBIO DE ESTADO EN FACEBOOK*/
function statusChangeCallback(response) {

    //validacion si esta conectado
    if (response.status === 'connected') {
        testApi();
    } else {
        swal({
                title: "¡ERROR!",
                text: "¡Ocurrio un error al ingresar con Facebook, vuelve a intentarlo !",
                type: "error",
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = localStorage.getItem('rutaActual');
                }
            });
    }
}


/*INGRESMO A LA API DE FACEBOOK*/
function testApi() {

    //le indico a facebook los ID de lo que quiero capturar con la respuesta
    FB.api('/me?fields=id,name,email,picture', function (response) {


        console.log(response);

        //hacemos la validacion si llega nulo o indefinido , ya que si se tiene bloqueado compartir en facebook el email , retornaara undefined
        if (response.email == null) {

            swal({
                    title: "¡ERROR!",
                    text: "¡Para poder ingresar al sistema, debe proporcionar la informacion de correo electronico !",
                    type: "error",
                    confirmButtonText: "Cerrar",
                    closeOnConfirm: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        window.location = localStorage.getItem('rutaActual');
                    }
                });

        } else {

            /*Si vienen datos, creo las variables para capturar los datos devuelvto de facebook*/
            var email = response.email;
            var nombre = response.name;
            var foto = "http://graph.facebook.com/" + response.id + "/picture?type=large";

            //hacemos la peticion ajac, para almacenar la informacion a la BD
            var datos = new FormData();
            datos.append('email', email);
            datos.append('nombre', nombre);
            datos.append('foto', foto);


            console.log(email);
            console.log(nombre);
            console.log(foto);


            $.ajax({
                url: rutaOculta + "ajax/usuarios.ajax.php",
                method: 'POST',
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {

                    console.log(respuesta);
                }
            })
            ;


        }
    });
}