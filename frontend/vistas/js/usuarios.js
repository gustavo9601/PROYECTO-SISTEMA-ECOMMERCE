/*==================================*/
/*CAPTURA DE RUTAS*/
/*==================================*/
//reando la variable de localstorage para almcenar la ruta actual

var rutaActual = location.href;
console.log(rutaActual);

// cuando se le de click a cualquier boton de inicio sde sesion se almacene la ruta actual
$(".btnIngreso, .facebook, .google").click(function () {

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


/*=============================================
 CAMBIAR FOTO
 =============================================*/

$('#btnCambiarFoto').click(function () {
    $('#imgPerfil').toggle();
    $('#subirImagen').toggle();
});


$('#datosImagen').change(function () {

    //accediendo a la imagen en la pisicion 0l
    var imagen = this.files[0];
    //console.log(imagen);

    //validacion de tipo
    console.log(imagen['type']);

    if (imagen['type'] != "image/jpeg" && imagen['type'] != 'image/png') {
        $('#datosImagen').val("");


        swal({
                title: "¡Error al subir la imagen!",
                text: "¡La imagen debe estar en formato JPG",
                type: "success",
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = rutaActual;
                }
            });

        //validacion de tamaño
    } else if (imagen['size'] > 2000000) {
        $('#datosImagen').val("");

        swal({
                title: "¡Error al subir la imagen!",
                text: "¡La imagen no debe ser mayor a 2 MB",
                type: "error",
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = rutaActual;
                }
            });

    } else {



        //leemos el archivo y lo transformamos a una cadena de codigo
        var datosImagen = new FileReader;
        datosImagen.readAsDataURL(imagen); //convertimos a URL la imagen

        //en cuando cargue la lectura y conversion
        $(datosImagen).on("load", function (event) {
            var rutaImagen = event.target.result;
            //lo que nos devuelva la carga del filereader, en url lo pasamos para que aparesca
            $('.previsualizar').attr('src', rutaImagen);

        });

        /*
         swal({
         title: "¡Correcto!",
         text: "¡La imagen se subio correctamente",
         type: "success",
         confirmButtonText: "Cerrar",
         closeOnConfirm: false
         },
         function (isConfirm) {
         if (isConfirm) {
         window.location = rutaActual;
         }
         });*/

    }


})


/*=============================================
 COMENTARIOS
 =============================================*/
$('.calificarProducto').click(function () {
    var idComentario = $(this).attr('id');  // capturamos el id

    //modficamos el input oculto del modal con el id capturado
    $('#idComentario').val(idComentario);

});

//cambiando las estrellas de acuerdo al puntaje seleccionado en el modal
$('input[name="puntaje"]').change(function () {  // capturando el envento de click/cambio sobre alguno de los chek de name puntaje
    var puntaje = $(this).val();
    //console.log(puntaje);

    switch (puntaje) {

        case "0.5":
            $("#estrellas").html('<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "1.0":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "1.5":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "2.0":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "2.5":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "3.0":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "3.5":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "4.0":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-o text-success" aria-hidden="true"></i>');
            break;

        case "4.5":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star-half-o text-success" aria-hidden="true"></i>');
            break;

        case "5.0":
            $("#estrellas").html('<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i> ' +
                '<i class="fa fa-star text-success" aria-hidden="true"></i>');
            break;

    }

});


/*Validacion del formulario de comentario de producto desde el perfil*/
function validarComentario() {


    var comentarios = $('#comentarios').val();

    //si es diferente de vacio
    if (comentarios != "") {

        //validamos con expresion regular
        var expresion = /^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;

        if (!expresion.test(comentarios)) {

            $("#comentario").parent().before('<div class="alert alert-danger"><strong>ERROR:</strong> No se permiten caracteres especiales como por ejemplo !$%&/?¡¿[]*</div>');

            return false;

        }

    } else {

        //si no hay nada en comentario, se lo exigimos
        $("#comentario").parent().before('<div class="alert alert-warning"><strong>ERROR:</strong> Campo obligatorio</div>');

        return false;

    }

    return true;
}


/*=============================================
 LISTA DE DESEOS
 =============================================*/
//click en la clase deseos que son todo los btn de corzacon
$('.deseos').click(function () {

    var idProducto = $(this).attr('idProducto');
    var idUsuario = localStorage.getItem('usuario');


    if (idUsuario == null) {
        swal({
                title: "¡Debe ingresar al sistema!",
                text: "¡Para agregar un producto a la lista de deseos, debe iniciar sesion",
                type: "warning",
                confirmButtonText: "Cerrar",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = rutaOculta;
                }
            });
    } else {

        $(this).addClass('btn-danger');

//almacenando l ainformacion del corazon a lista de deseos
        var datos = new FormData();
        datos.append('idUsuario', idUsuario);
        datos.append('idProducto', idProducto);

        $.ajax({
            url: rutaOculta + "ajax/usuarios.ajax.php", // ya existe en un archivo anterior
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                //console.log(respuesta);
            }
        })


    }

});


/*=============================================
 BORRAR DE PRODUCTO DE LISTA DESEOS
 =============================================*/
$('.quitarDeseo').click(function () {
    var idDeseo = $(this).attr('idDeseo');
    //alert(idDeseo);
    //eliminamos toda la caja completa
    $(this).parent().parent().parent().remove();


    //eliminamos de la BD
    var datos = new FormData();
    datos.append('idDeseo', idDeseo);
    $.ajax({
        url: rutaOculta + "ajax/usuarios.ajax.php", // ya existe en un archivo anterior
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            //console.log(respuesta);
        }
    })

});


/*=============================================
 ELIMINAR USUARIO
 =============================================*/
//console.log("aaaa" + $('#idUsuario').val());
//console.log("aaaa" + $('#fotoUsuario').val());
$('#eliminarUsuario').click(function () {
    var id = $('#idUsuario').val(); // input escondido


    console.log(id);
    console.log($('#fotoUsuario').val());
    //validacion de tipo
    if ($('#modoUsuario').val() == "directo") {

        //validacion si viene informacion o no de foto, a que se eliminara la foto y directorio de habe rinformacion
        if ($('#fotoUsuario').val() != "") {
            var foto = $('#fotoUsuario').val();
        }
    }
    swal({
            title: "¿Estas seguro(a) de eliminar tu cuenta?",
            text: "¡Si borras esta cuenta ya no se podra recuperar",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "!Si borrar cuenta¡",
            closeOnConfirm: false
        },
        function (isConfirm) {
            if (isConfirm) {
                window.location = "index.php?ruta=perfil&id=" + id + "&foto=" + foto;
            }
        });


});




/*=============================================
 VALIDACIÓN FORMULARIO CONTACTENOS
 =============================================*/

function validarContactenos(){

    var nombre = $("#nombreContactenos").val();
    var email = $("#emailContactenos").val();
    var mensaje = $("#mensajeContactenos").val();

    /*=============================================
     VALIDACIÓN DEL NOMBRE
     =============================================*/

    if(nombre == ""){

        $("#nombreContactenos").before('<h6 class="alert alert-danger">Escriba por favor el nombre</h6>');

        return false;

    }else{

        var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;

        if(!expresion.test(nombre)){

            $("#nombreContactenos").before('<h6 class="alert alert-danger">Escriba por favor sólo letras sin caracteres especiales</h6>');

            return false;

        }

    }

    /*=============================================
     VALIDACIÓN DEL EMAIL
     =============================================*/

    if(email== ""){

        $("#emailContactenos").before('<h6 class="alert alert-danger">Escriba por favor el email</h6>');

        return false;

    }else{

        var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;

        if(!expresion.test(email)){

            $("#emailContactenos").before('<h6 class="alert alert-danger">Escriba por favor correctamente el correo electrónico</h6>');

            return false;
        }

    }

    /*=============================================
     VALIDACIÓN DEL MENSAJE
     =============================================*/

    if(mensaje == ""){

        $("#mensajeContactenos").before('<h6 class="alert alert-danger">Escriba por favor un mensaje</h6>');

        return false;

    }else{

        var expresion = /^[,\\.\\a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;

        if(!expresion.test(mensaje)){

            $("#mensajeContactenos").before('<h6 class="alert alert-danger">Escriba el mensaje sin caracteres especiales</h6>');

            return false;
        }

    }

    return true;
}

