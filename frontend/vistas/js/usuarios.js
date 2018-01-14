/*==================================*/
/*CAPTURA DE RUTAS*/
/*==================================*/
//reando la variable de localstorage para almcenar la ruta actual

var rutaActual = location.href;
console.log(rutaActual);

// cuando se le de click a cualquier boton de inicio sde sesion se almacene la ruta actual
$(".btnIngreso, .facebook, .google").click(function(){

    localStorage.setItem("rutaActual", rutaActual);

})

/*==================================*/
/*FORMATEAR LOS INPUT*/
/*==================================*/
$("input").focus(function () {
    $('.alert').remove(); // cuando se paren en cualquier input que eliminen las alertas
});


/*==================================*/
/*VALIDAR EMAIL REPETIDO*/
/*==================================*/
var validarEmailRepetido = false;

$('#regEmail').change(function () {
    var email = $('#regEmail').val();

    var datos = new FormData();
    datos.append('validarEmail', email);

    $.ajax({
        url: rutaOculta + "ajax/usuarios.ajax.php", // ya existe en un archivo anterior
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log(respuesta);
            //validando lo que nos devuelva
            if (respuesta === false || JSON.parse(respuesta).modo == undefined) {
                $('.alert').remove();
                validarEmailRepetido = false;
            } else {
                //parseamosel modo de la respuesta que nos venga en la bd
                var modo = JSON.parse(respuesta).modo;
                console.log(modo);
                if (modo == 'directo') {
                    modo = "esta pagina";
                }
                $('#regEmail').parent().before('<div class="alert alert-warning"><strong>ATENCION:</strong> Correo ya esa en uso, y fue registrado atravez de ' + modo + ', por favor ingrese otro diferente</div>');

                validarEmailRepetido = true;
            }
        }
    });
});


/*==================================*/
/*VALIDAR EL REGISTRO DEL USUARIO*/
/*==================================*/

function registroUsuario() {

    /*=============================================
     VALIDAR EL NOMBRE
     =============================================*/

    var nombre = $("#regUsuario").val();

    if (nombre != "") {

        var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

        if (!expresion.test(nombre)) {

            $("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten números ni caracteres especiales</div>')

            return false;

        }

    } else {

        $("#regUsuario").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

        return false;
    }

    /*=============================================
     VALIDAR EL EMAIL
     =============================================*/

    var email = $("#regEmail").val();

    if (email != "") {

        var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

        if (!expresion.test(email)) {

            $("#regEmail").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Escriba correctamente el correo electrónico</div>')

            return false;

        }

        if (validarEmailRepetido) {

            $("#regEmail").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')

            return false;

        }

    } else {

        $("#regEmail").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

        return false;
    }


    /*=============================================
     VALIDAR CONTRASEÑA
     =============================================*/

    var password = $("#regPassword").val();

    if (password != "") {

        var expresion = /^[a-zA-Z0-9]*$/;

        if (!expresion.test(password)) {

            $("#regPassword").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> No se permiten caracteres especiales</div>')

            return false;

        }

    } else {

        $("#regPassword").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Este campo es obligatorio</div>')

        return false;
    }

    /*=============================================
     VALIDAR POLÍTICAS DE PRIVACIDAD
     =============================================*/

    var politicas = $("#regPoliticas:checked").val();

    if (politicas != "on") {

        $("#regPoliticas").parent().before('<div class="alert alert-warning"><strong>ATENCIÓN:</strong> Debe aceptar nuestras condiciones de uso y políticas de privacidad</div>')

        return false;

    }

    return true;
}



