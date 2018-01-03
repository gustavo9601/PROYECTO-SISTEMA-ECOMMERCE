/*==================================*/
/*VALIDAR EL REGISTRO DEL USUARIO*/
/*==================================*/


function resgistroUsuario() {



    /*==================================*/
    /*VALIDAR EL NOMBRE*/
    /*==================================*/
    var nombre = $('#regUsuario').val();
    if (nombre != "") {
        var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;
        if (!expresion.test(nombre)) {
            $('#regUsuario').parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten numeros ni caracteres especiales</div>');
            return false;
        }
    } else {
        $('#regUsuario').parent().before('<div class="alert alert-warning"><strong>ATENCION:</strong> Este campo es obligatorio</div>');
        return false;
    }


    /*==================================*/
    /*VALIDAR EL EMAIL*/
    /*==================================*/
    var email = $('#regEmail').val();
    if (email != "") {
        var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
        if (!expresion.test(email)) {
            $('#regEmail').parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No correctamente el correo electronico</div>');
            return false;
        }
    } else {
        $('#regEmail').parent().before('<div class="alert alert-warning"><strong>ATENCION:</strong> Este campo es obligatorio</div>');
        return false;
    }


    /*==================================*/
    /*VALIDAR CONTRASEÑA*/
    /*==================================*/
    var password = $('#regPassword').val();
    if (password != "") {
        var expresion = /^[a-zA-Z0-9]*$/;
        if (!expresion.test(password)) {
            $('#regPassword').parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten caracteres especiales</div>');
            return false;
        }
    } else {
        $('#regPassword').parent().before('<div class="alert alert-warning"><strong>ATENCION:</strong> Este campo es obligatorio</div>');
        return false;
    }


    /*==================================*/
    /*VALIDAR PLITICAS DE PRIVACIDAD*/
    /*==================================*/
    //capturamos el valor del chek activo
    var politicas = $('#regPoliticas:checked').val();

    if (politicas != "on") {
        $('#regPoliticas').parent().before('<div class="alert alert-warning"><strong>ATENCION:</strong>Debe aceptar nuestras politicas de uso y privacidad</div>');
        return false;
    }


    return true;
}