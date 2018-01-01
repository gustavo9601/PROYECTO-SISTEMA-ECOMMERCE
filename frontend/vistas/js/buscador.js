/*===============================*/
/*BUSCADOR*/
/*===============================*
 /
 */

//detectando el cambio
$('#buscador input').change(function () {
    var busqueda = $('#buscador input').val();

    //Expresion regular que validara lo que se ponga en el input de buscar
    //se permitiran letras min y mayus, nmeros, y algunas letras con tigledes y espacio
    var expresion = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;

    //si no pasa el test
    if (!expresion.test(busqueda)) {
        $('#buscador input').val("");
    } else {
        var evaluarBusqueda = busqueda.replace(/[áéíóúÁÉÍÓÚ ]/g, "-"); //se reemplaza todos los espacios y letras con tildes por guiones para generar una url
        var rutaBuscador = $('#buscador a').attr("href"); // capturamos la url dinamica del <a>

        //si el input esta lleno, diferente de vacio
        if ($('#buscador input').val() != "") {
            $('#buscador a').attr("href", rutaBuscador + "/" + evaluarBusqueda);
        }

    }

});


/*===============================*/
/*BUSCADOR  CON ENTER* /
 /*===============================*
 /
 */
$('#buscador input').focus(function () {
    //detectamos los eventos de teclado
    //keyup, cuando se levante la tecla
    $(document).keyup(function (event) {
        //quitamos los eventos por defecto
        event.preventDefault();

        //13 es la tecla enter
        if (event.keyCode == 13 && $('#buscador input').val() != "") {
            var rutaBuscador = $('#buscador a').attr("href"); // capturamos la url dinamica del <a>

            //redireccinamos el navegador, a la ruta ya modfiicada con la funcion anterior
            window.location.href = rutaBuscador;
        }
    });

});