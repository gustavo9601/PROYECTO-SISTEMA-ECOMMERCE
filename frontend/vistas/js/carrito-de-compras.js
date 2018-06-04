/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 VISUALIZAR LA CESTA DEL CARRITO DE COMPRAS
 =============================================*/

//validacion si no es nullo lo que tenga la cesta, colocamos en 0 la cesta y la suma
//de lo contrario colocamos lo que tenga el localstorage
if (localStorage.getItem("cantidadCesta") != null) {

    $(".cantidadCesta").html(localStorage.getItem("cantidadCesta"));
    $(".sumaCesta").html(localStorage.getItem("sumaCesta"));
} else {
    $(".cantidadCesta").html("0");
    $(".sumaCesta").html("0");

}


/*=====================================*/
/*=====================================*/
/*=====================================*/
/*=====================================*/
/*VISUALIZAR LOS PRODUCTOS EN LA PAGINA DE CARRITO DE COMPRAS*/
/*=====================================*/

//validar si el local ya esta creada o tiene informacion

if (localStorage.getItem("listaProductos") != null) {


    //gacemos la conversion de string a objeto jeison de lo que tenga el localStorage, para que se pueda concatenar como array , mas abajo con el concat
    var listaCarrito = JSON.parse(localStorage.getItem("listaProductos"));


    //vamos a iterar por cada item la funcion que o lo que le pasemos por parametro
    listaCarrito.forEach(funcionForEach);


    function funcionForEach(item, index) {

        //console.log(item);

        //hacemos un append sobre el cuerpo de CuerpoCarrito con la informacion que hay en el arreglo
        $(".cuerpoCarrito").append(
            '<div clas="row itemCarrito">' +

            '<div class="col-sm-1 col-xs-12">' +

            '<br>' +

            '<center>' +

            '<button class="btn btn-default backColor quitarItemCarrito" idProducto="' + item.idProducto + '" peso="' + item.peso + '">' +

            '<i class="fa fa-times"></i>' +

            '</button>' +

            '</center>' +

            '</div>' +

            '<div class="col-sm-1 col-xs-12">' +

            '<figure>' +

            '<img src="' + item.imagen + '" class="img-thumbnail">' +

            '</figure>' +

            '</div>' +

            '<div class="col-sm-4 col-xs-12">' +

            '<br>' +

            '<p class="tituloCarritoCompra text-left">' + item.titulo + '</p>' +

            '</div>' +

            '<div class="col-md-2 col-sm-1 col-xs-12">' +

            '<br>' +

            '<p class="precioCarritoCompra text-center">USD $<span>' + item.precio + '</span></p>' +

            '</div>' +

            '<div class="col-md-2 col-sm-3 col-xs-8">' +

            '<br>' +

            '<div class="col-xs-8">' +

            '<center>' +

            '<input type="number" class="form-control cantidadItem" min="1" value="' + item.cantidad + '" tipo="' + item.tipo + '" precio="' + item.precio + '" idProducto="' + item.idProducto + '">' +

            '</center>' +

            '</div>' +

            '</div>' +

            '<div class="col-md-2 col-sm-1 col-xs-4 text-center">' +

            '<br>' +

            '<p class="subTotal' + item.idProducto + ' subtotales">' +

            '<strong>USD $<span>' + item.precio + '</span></strong>' +

            '</p>' +

            '</div>' +

            '</div>' +

            '<div class="clearfix"></div>' +

            '<hr>');

        /*=============================================
         EVITAR MANIPULAR LA CANTIDAD EN PRODUCTOS VIRTUALES
         =============================================*/

        $(".cantidadItem[tipo='virtual']").attr("readonly", "true");

    }


} else {

    //Si no esta creado el arreglo en el Local Storage
    $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
    $(".sumaCarrito").hide();   // escondemos el boton y el campo de sumatoria
    $(".cabeceraCheckout").hide(); // escondemos el boton y el campo de sumatoria
}

/*=====================================*/
/*=====================================*/
/*=====================================*/
/*=====================================*/
/*AGREGAR AL CARRITO DE COMPRA*/
/*=====================================*/


$('.agregarCarrito').click(function () {
    var idProducto = $(this).attr("idProducto");
    var imagen = $(this).attr("imagen");
    var titulo = $(this).attr("titulo");
    var precio = $(this).attr("precio");
    var tipo = $(this).attr("tipo");
    var peso = $(this).attr("peso");

    /*=============================================
     CAPTURAR DETALLES
     =============================================*/

    //validacion del tipo de producto que viene al dar click

    var agregarAlCarrito = false;
    if (tipo == 'virtual') {
        agregarAlCarrito = true;
    } else {

        var seleccionarDetalle = $('.seleccionarDetalle');

        //recorremos los selecte con esa clase para recorrer los valores
        for (var i = 0; i < seleccionarDetalle.length; i++) {

            //valdiacion si alguno es nulo o no se ha seleccionado
            if ($(seleccionarDetalle[i]).val() == "") {
                swal({
                    title: "Debe seleccionar Talla y Color",
                    text: "",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "¡Seleccionar!",
                    closeOnConfirm: false
                });
            } else {  // si si slecciono detalles

                titulo = titulo + "-" + $(seleccionarDetalle[i]).val();

                agregarAlCarrito = true;  // pasaos a true la variable
            }

        }

    }


    /*=============================================
     ALMACENAR EN EL LOCALSTARGE LOS PRODUCTOS AGREGADOS AL CARRITO
     =============================================*/
    //si es true agregar el carrito
    if (agregarAlCarrito) {

        /*=============================================
         RECUPERAR ALMACENAMIENTO DEL LOCALSTORAGE
         =============================================*/
        //validamos si existe el local stroge, para crear el array o concatenasr lo que pasemos de nuevo al array para que no se sobreescriba
        if (localStorage.getItem("listaProductos") == null) {

            listaCarrito = [];

        } else {

            listaCarrito.concat(localStorage.getItem("listaProductos"));

        }


        //insertamos nformacion del producto al array, para luego pasarlo a localstorge
        listaCarrito.push({
            "idProducto": idProducto,
            "imagen": imagen,
            "titulo": titulo,
            "precio": precio,
            "tipo": tipo,
            "peso": peso,
            "cantidad": "1"
        });


        //console.log(listaCarrito);
        //alcenando la info en el localstorage, en formato string
        localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

        /*=============================================
         ACTUALIZAR LA CESTA
         =============================================*/
        //actualizaremso los valores de la ceta

        //numero que se ira incrementado
        var cantidadCesta = Number($('.cantidadCesta').html()) + 1;
        //sumamos lo que tenga en el htm con el nuevo precio del articulo
        var sumaCesta = Number($('.sumaCesta').html()) + precio;

        $(".cantidadCesta").html(cantidadCesta);
        $(".sumaCesta").html(sumaCesta);

        localStorage.setItem("cantidadCesta", cantidadCesta);
        localStorage.setItem("sumaCesta", sumaCesta);


        /*=============================================
         MOSTRAR ALERTA DE QUE EL PRODUCTO YA FUE AGREGADO
         =============================================*/

        swal({
                title: "",
                text: "¡Se ha agregado un nuevo producto al carrito de compras!",
                type: "success",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "¡Continuar comprando!",
                confirmButtonText: "¡Ir a mi carrito de compras!",
                closeOnConfirm: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    window.location = rutaOculta + "carrito-de-compras";
                }
            });


    }
});


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 QUITAR PRODUCTOS DEL CARRITO
 =============================================*/

$(".quitarItemCarrito").click(function () {

    //quitamos a todo el pariente
    $(this).parent().parent().parent().remove();

    //vapturamos los valores que tiene el boton, que son la informacion de todo el producto
    var idProducto = $(".cuerpoCarrito button");
    var imagen = $(".cuerpoCarrito img");
    var titulo = $(".cuerpoCarrito .tituloCarritoCompra");
    var precio = $(".cuerpoCarrito .precioCarritoCompra span");
    var cantidad = $(".cuerpoCarrito .cantidadItem");

    /*=============================================
     SI AÚN QUEDAN PRODUCTOS VOLVERLOS AGREGAR AL CARRITO (LOCALSTORAGE)
     =============================================*/

    //hacemos a 0 el array que llevara la inforacion a localstorage
    listaCarrito = [];

    //validamo que sea mayor a cero, la cantidad de item
    if (idProducto.length != 0) {



        //como anteriormente eliminamos el HTML del boton, podemos recorrer todo lo que este en l contenido, y se creara un nuevo array
        // para que sobrescriba toda la informacion en el localstorage
        for (var i = 0; i < idProducto.length; i++) {

            var idProductoArray = $(idProducto[i]).attr("idProducto");
            var imagenArray = $(imagen[i]).attr("src");
            var tituloArray = $(titulo[i]).html();
            var precioArray = $(precio[i]).html();
            var pesoArray = $(idProducto[i]).attr("peso");
            var tipoArray = $(cantidad[i]).attr("tipo");
            var cantidadArray = $(cantidad[i]).val();

            listaCarrito.push({
                "idProducto": idProductoArray,
                "imagen": imagenArray,
                "titulo": tituloArray,
                "precio": precioArray,
                "tipo": tipoArray,
                "peso": pesoArray,
                "cantidad": cantidadArray
            });

        }

        //sobrescribiendo l ainformacion el localstorage con el nuevo array
        localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));


        //sumaSubtotales();


        //actualizamos la informacion de los subtotales al eliminar algun item
        sumaSubtotales();
        //actualizamos la informacion de totales y de cesta
        cestaCarrito(listaCarrito.length);  // le pasamos la nueva cantidad
    } else {

        /*=============================================
         SI YA NO QUEDAN PRODUCTOS HAY QUE REMOVER TODO
         =============================================*/
        //si no quedan pordocutos vaciamos todos lo que pueda haber en el localstorage

        localStorage.removeItem("listaProductos");

        localStorage.setItem("cantidadCesta", "0");

        localStorage.setItem("sumaCesta", "0");

        //receteamos a 0
        $(".cantidadCesta").html("0");
        $(".sumaCesta").html("0");

        //mostramos el mensaje de que no hay productos
        $(".cuerpoCarrito").html('<div class="well">Aún no hay productos en el carrito de compras.</div>');
        $(".sumaCarrito").hide();
        $(".cabeceraCheckout").hide();

    }

})


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 GENERAR SUBTOTAL DESPUES DE CAMBIAR CANTIDAD
 =============================================*/
$(".cantidadItem").change(function () {

    var cantidad = $(this).val();
    var precio = $(this).attr("precio");
    var idProducto = $(this).attr("idProducto");

    $(".subTotal" + idProducto).html('<strong>USD $<span>' + (cantidad * precio) + '</span></strong>');

    /*=============================================
     ACTUALIZAR LA CANTIDAD EN EL LOCALSTORAGE
     =============================================*/

    var idProducto = $(".cuerpoCarrito button");
    var imagen = $(".cuerpoCarrito img");
    var titulo = $(".cuerpoCarrito .tituloCarritoCompra");
    var precio = $(".cuerpoCarrito .precioCarritoCompra span");
    var cantidad = $(".cuerpoCarrito .cantidadItem");

    listaCarrito = [];


    //actualimamos el arreglo que esta en json en localstorage, para ello recorremos todo el dom de artiruclos
    for (var i = 0; i < idProducto.length; i++) {

        var idProductoArray = $(idProducto[i]).attr("idProducto");
        var imagenArray = $(imagen[i]).attr("src");
        var tituloArray = $(titulo[i]).html();
        var precioArray = $(precio[i]).html();
        var pesoArray = $(idProducto[i]).attr("peso");
        var tipoArray = $(cantidad[i]).attr("tipo");
        var cantidadArray = $(cantidad[i]).val();

        listaCarrito.push({
            "idProducto": idProductoArray,
            "imagen": imagenArray,
            "titulo": tituloArray,
            "precio": precioArray,
            "tipo": tipoArray,
            "peso": pesoArray,
            "cantidad": cantidadArray
        });

    }

    localStorage.setItem("listaProductos", JSON.stringify(listaCarrito));

    //actualizamos los valores de suma de todos los item, invocando la siguiente funcion
    sumaSubtotales();
    cestaCarrito(listaCarrito.length);
})


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 ACTUALIZAR SUBTOTAL
 =============================================*/
var precioCarritoCompra = $(".cuerpoCarrito .precioCarritoCompra span");
var cantidadItem = $(".cuerpoCarrito .cantidadItem");

//El for , recorre los item y toma la cantidad para multiplicarlo con precio
for (var i = 0; i < precioCarritoCompra.length; i++) {

    var precioCarritoCompraArray = $(precioCarritoCompra[i]).html();
    var cantidadItemArray = $(cantidadItem[i]).val();
    var idProductoArray = $(cantidadItem[i]).attr("idProducto");

    $(".subTotal" + idProductoArray).html('<strong>USD $<span>' + (precioCarritoCompraArray * cantidadItemArray) + '</span></strong>')

    sumaSubtotales();
    cestaCarrito(precioCarritoCompra.length);

}


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 SUMA DE TODOS LOS SUBTOTALES
 =============================================*/
function sumaSubtotales() {

    //capturamos los valores desde el html
    var subtotales = $(".subtotales span");
    //array que ira acumulando los subtotales
    var arraySumaSubtotales = [];

    for (var i = 0; i < subtotales.length; i++) {

        var subtotalesArray = $(subtotales[i]).html();
        //voy insertando los valores de cada item al array
        arraySumaSubtotales.push(Number(subtotalesArray));
    }


    //funcion recursiva
    function sumaArraySubtotales(total, numero) {

        return total + numero;

    }

    /// Metodo reduce -> devuelve la sumatoria de izquierda a derecha de un array
    var sumaTotal = arraySumaSubtotales.reduce(sumaArraySubtotales);

    //modificma'os el html de Suma total
    $(".sumaSubTotal").html('<strong>USD $<span>' + sumaTotal + '</span></strong>');
//modficiamos la informacion de cesta
    $(".sumaCesta").html(sumaTotal);

    //almacenamos la informacion de la Cesta en el localstorage
    localStorage.setItem("sumaCesta", sumaTotal);

}


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 ACTUALIZAR CESTA AL CAMBIAR CANTIDAD
 =============================================*/
function cestaCarrito(cantidadProductos) {
//recibo como parametro, la longitud de cantidad de productos existentes
    /*=============================================
     SI HAY PRODUCTOS EN EL CARRITO
     =============================================*/

    if (cantidadProductos != 0) {

        var cantidadItem = $(".cuerpoCarrito .cantidadItem");

        var arraySumaCantidades = [];

        for (var i = 0; i < cantidadItem.length; i++) {

            //recorrerar todos los item neuvamente para capturar su valor
            var cantidadItemArray = $(cantidadItem[i]).val();
            //alcanamos en un array los precios de los item
            arraySumaCantidades.push(Number(cantidadItemArray));

        }

        //funcion que no se le pasara parametros puntualmente, si no atravez de a fncion reduce,
        //enviara el parametro y recibira un total
        function sumaArrayCantidades(total, numero) {

            return total + numero;

        }

        //hace un forech con una con la funcion reduce, del array de todas las cantidades de producto
        var sumaTotalCantidades = arraySumaCantidades.reduce(sumaArrayCantidades);

        $(".cantidadCesta").html(sumaTotalCantidades);
        localStorage.setItem("cantidadCesta", sumaTotalCantidades);

    }
}


//Actualizando los subtotales indemditamten se cargue la pagina
sumaSubtotales();


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 CHECKOUT
 =============================================*/

//Click sobre el boton que llama al modal de chekout
$("#btnCheckout").click(function () {
        //Resteamo el htm de la tabla de proudctos en el modal
        $(".listaProductos table.tablaProductos tbody").html("");

        //Resteamos para que aparesca checado la opcion por default paypal
        $("#checkPaypal").prop("checked", true);
        $("#checkPayu").prop("checked", false);

        //Captura de valores, por clases es decir solo se crean arrays
        var idUsuario = $(this).attr("idUsuario");
        var peso = $(".cuerpoCarrito button, .comprarAhora button");
        var titulo = $(".cuerpoCarrito .tituloCarritoCompra, .comprarAhora .tituloCarritoCompra");
        var cantidad = $(".cuerpoCarrito .cantidadItem, .comprarAhora .cantidadItem");
        var subtotal = $(".cuerpoCarrito .subtotales span, .comprarAhora .subtotales span");
        var tipoArray = [];
        var cantidadPeso = [];


        /*=============================================
         SUMA SUBTOTAL
         =============================================*/
        //capturamos el valor de subtotal de la tabla inicial del carrito de compras y lo capturamos para
        //modificar el valor en el modal
        var sumaSubTotal = $(".sumaSubTotal span")

        $(".valorSubtotal").html($(sumaSubTotal).html());
        $(".valorSubtotal").attr("valor", $(sumaSubTotal).html());


        /*=============================================
         TASAS DE IMPUESTO
         =============================================*/

        //costo de impesto, multipmicando el porcentaje de IVA por el subtotal / 100
        var impuestoTotal = ($(".valorSubtotal").html() * $("#tasaImpuesto").val()) / 100;
        //con toFixed parseamos a solo 2 decimales
        $(".valorTotalImpuesto").html(impuestoTotal.toFixed(2));
        $(".valorTotalImpuesto").attr("valor", impuestoTotal.toFixed(2));


        sumaTotalCompra();
        /*=============================================
         VARIABLES ARRAY
         =============================================*/
        //recorriendo todos arreglos
        for (var i = 0; i < titulo.length; i++) {
            var pesoArray = $(peso[i]).attr("peso");
            var tituloArray = $(titulo[i]).html();
            var cantidadArray = $(cantidad[i]).val();
            var subtotalArray = $(subtotal[i]).html();


            /*=============================================
             EVALUAR EL PESO DE ACUERDO A LA CANTIDAD DE PRODUCTOS
             =============================================*/
            //multiplicamos el peso de cada articulo por su cantidad
            cantidadPeso[i] = pesoArray * cantidadArray;

            function sumaArrayPeso(total, numero) {

                return total + numero;

            }

            var sumaTotalPeso = cantidadPeso.reduce(sumaArrayPeso);


            /*=============================================
             MOSTRAR PRODUCTOS DEFINITIVOS A COMPRAR
             =============================================*/
            //en cada iteracion mostrara al detalle cada articulo en la tabla del modal
            $(".listaProductos table.tablaProductos tbody").append('<tr>' +
                '<td class="valorTitulo">' + tituloArray + '</td>' +
                '<td class="valorCantidad">' + cantidadArray + '</td>' +
                '<td>$<span class="valorItem" valor="' + subtotalArray + '">' + subtotalArray + '</span></td>' +
                '<tr>');


            /*=============================================
             SELECCIONAR PAÍS DE ENVÍO SI HAY PRODUCTOS FÍSICOS
             =============================================*/
            //creamos un arreglo e inserto informacion de tipo
            tipoArray.push($(cantidad[i]).attr("tipo"));
            //validamos cada uno de los item, el tipo, para sabe si se coloca o no
            function checkTipo(tipo) {

                return tipo == "fisico";

            }

            /*=============================================
             EXISTEN PRODUCTOS FÍSICOS
             =============================================*/
            //ejecutamos una busqueda ejecutando la atentiror funcion, que retornara los productos , que tengan tipo fisico
            if (tipoArray.find(checkTipo) == "fisico") {

                //agrego en el html del select de Pais
                $('.seleccionePais').html(
                    ' <select required name="" id="seleccionarPais" class="form-control">' +
                    '<option value="">Seleccione el Pais</option>' +
                    '</select>'
                );

                //Como es fisico, mostramos el formulario de envio
                $(".formEnvio").show();

                $(".btnPagar").attr("tipo", "fisico");

                //Hago la peticion ajax, hacia el archivo json, que contoene el listado de paises en json
                $.ajax({
                    url: rutaOculta + "vistas/js/plugins/countries.json",
                    type: "GET",
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function (respuesta) {

                        //recorremos el resultado conel foreach y ejecutamos la funcion
                        respuesta.forEach(seleccionarPais);

                        function seleccionarPais(item, index) {

                            var pais = item.name;
                            var codPais = item.code;

                            $("#seleccionarPais").append('<option value="' + codPais + '">' + pais + '</option>');

                        }

                    }
                })


                /*=============================================
                 EVALUAR TASAS DE ENVÍO SI EL PRODUCTO ES FÍSICO
                 =============================================*/
                //cuando cambie el select de pais
                $("#seleccionarPais").change(function () {
                    $(".alert").remove();


                    //capturamos valor
                    var pais = $(this).val();
                    var tasaPais = $("#tasaPais").val();

                    //validacion si el pais seleccionado es el mismo al de la bd, el envio es nacional
                    if (pais == tasaPais) {

                        var resultadoPeso = sumaTotalPeso * $("#envioNacional").val();

                        //condicional que valida que el total de kilo por cantidad
                        // si es menor con la tasa minima de envio, colocamos las tasas minimas
                        // de lo contrario colocamos los resultado de la operacion
                        if (resultadoPeso < $("#tasaMinimaNal").val()) {

                            $(".valorTotalEnvio").html($("#tasaMinimaNal").val());
                            $(".valorTotalEnvio").attr("valor", $("#tasaMinimaNal").val());

                        } else {

                            $(".valorTotalEnvio").html(resultadoPeso);
                            $(".valorTotalEnvio").attr("valor", resultadoPeso);
                        }
                    } else {

                        var resultadoPeso = sumaTotalPeso * $("#envioInternacional").val();

                        if (resultadoPeso < $("#tasaMinimaInt").val()) {

                            $(".valorTotalEnvio").html($("#tasaMinimaInt").val());
                            $(".valorTotalEnvio").attr("valor", $("#tasaMinimaInt").val());

                        } else {

                            $(".valorTotalEnvio").html(resultadoPeso);
                            $(".valorTotalEnvio").attr("valor", resultadoPeso);
                        }

                    }


                    /*=============================================
                     RETORNAR CAMBIO DE DIVISA A DOLAR USD
                     =============================================*/

                    //reseteamos el valor a USD, al cambiar de pais
                    $('#cambiarDivisa').val('USD');

                    //cambiamos el HTML del span de la tabla de subtotoal y total, reseteanso a Dolares
                    $(".cambioDivisa").html('USD');
                    //captura de los valores numericos que estan en el HTML, para realizar la por 1, ya que al cambiar el pasi la modena por defecto es el Dolar
                    $(".valorSubtotal").html((1 * Number($(".valorSubtotal").attr("valor"))).toFixed(2))
                    $(".valorTotalEnvio").html((1 * Number($(".valorTotalEnvio").attr("valor"))).toFixed(2))
                    $(".valorTotalImpuesto").html((1 * Number($(".valorTotalImpuesto").attr("valor"))).toFixed(2))
                    $(".valorTotalCompra").html((1 * Number($(".valorTotalCompra").attr("valor"))).toFixed(2))

                    //captra del valor inicial, de cada uno de los elememto con esta clase
                    var valorItem = $(".valorItem");

                    //recorremos todos los item
                    for (var i = 0; i < valorItem.length; i++) {
                        //cambio de datos en cada nos de lo sitem, multiplicando la a Dolar
                        $(valorItem[i]).html((1 * Number($(valorItem[i]).attr("valor"))).toFixed(2))

                    }


                    //ejecuto la funcions
                    sumaTotalCompra();
                    pagarConPayu();


                });


            } else {
                //es por que viene solo virtual le cambiamos el tipo al btn de pago
                $(".btnPagar").attr("tipo", "virtual");
            }


        }

    }
)


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 SUMA TOTAL DE LA COMPRA
 =============================================*/
function sumaTotalCompra() {
//sumam los totales, de cada uno de lo que contenga el HTML de la tabla
    var sumaTotalTasas = Number($(".valorSubtotal").html()) +
        Number($(".valorTotalEnvio").html()) +
        Number($(".valorTotalImpuesto").html());

    //reemplza en el modal la informacion de los totales y parsea a float de 2 decimales con toFixed
    $(".valorTotalCompra").html(sumaTotalTasas.toFixed(2));
    $(".valorTotalCompra").attr("valor", sumaTotalTasas.toFixed(2));
}

/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 MÉTODO DE PAGO PARA CAMBIO DE DIVISA
 =============================================*/
//ejecutando la funcion por default para que aparesca los valores de divisa de Paypal
var metodoPago = "paypal";
divisas(metodoPago);

//cuando cambie el estado del input circular
$("input[name='pago']").change(function () {

    //alaceno el metodo de pago que esta en el valor del check
    var metodoPago = $(this).val();

    //ejecutando la funcion
    divisas(metodoPago);

    if (metodoPago == "payu") {

        $(".btnPagar").hide();
        $(".formPayu").show(); // mostramos el formulario de payu, pero solo se vera el btn ya que lo demas esta en hidden

        pagarConPayu();

    } else {

        $(".btnPagar").show();
        $(".formPayu").hide();

    }

});


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 FUNCIÓN PARA EL CAMBIO DE DIVISA
 =============================================*/

function divisas(metodoPago) {

    //vaciamos el select para que no haga feos con el append
    $("#cambiarDivisa").html("");

    //Modificaccion del HTMK del select que contiene las divisas de
    //acuerdo al metodo de pago pasado por parametro
    if (metodoPago == "paypal") {

        //Opciones tomadas de la documentacion de Paypal
        $("#cambiarDivisa").append('<option value="USD">USD</option>' +
            '<option value="EUR">EUR</option>' +
            '<option value="GBP">GBP</option>' +
            '<option value="MXN">MXN</option>' +
            '<option value="JPY">JPY</option>' +
            '<option value="CAD">CAD</option>' +
            '<option value="BRL">BRL</option>')

    } else {

        //Opciones tomadas de la documentacion de Payu
        $("#cambiarDivisa").append('<option value="USD">USD</option>' +
            '<option value="PEN">PEN</option>' +
            '<option value="COP">COP</option>' +
            '<option value="MXN">MXN</option>' +
            '<option value="CLP">CLP</option>' +
            '<option value="ARS">ARS</option>' +
            '<option value="BRL">BRL</option>')

    }

}


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 CAMBIO DE DIVISA
 =============================================*/

var divisaBase = "USD";
//detectamos el cambio de divisa, y ejecutamos la funcion que realizara la peticion ajax, para traer los datos dinamicos del api
$("#cambiarDivisa").change(function () {

    $(".alert").remove();

    //Vlidacion si ha seleccionado el pais, para que muestre la alerta
    if ($("#seleccionarPais").val() == "") {

        $("#cambiarDivisa").after('<div class="alert alert-warning">No ha seleccionado el país de envío</div>');

        return;

    }

    var divisa = $(this).val();

    $.ajax({

        url: "http://free.currencyconverterapi.com/api/v3/convert?q=" + divisaBase + "_" + divisa + "&compact=y",
        type: "GET",
        cache: false,
        contentType: false,
        processData: false,
        dataType: "jsonp", // es de tipo jsonp, para realizar el cruce de origen para traer informacion de otro servidor
        success: function (respuesta) {

            //Parseamos el string recibido a cadena de Texto
            var divisaString = JSON.stringify(respuesta);
            // sustraemos la informacion del string ya que solo enecsiamos un valor
            var conversion = divisaString.substr(18, 4);

            //validacion si la divisa de cambio es Dollar, se multipicara solo por 1
            if (divisa == "USD") {
                conversion = 1;
            }

            //cambiamos el HTML del span de la tabla de subtotoal y total,,,
            $(".cambioDivisa").html(divisa);

            //captura de los valores numericos que estan en el HTML, para realizar la multiplicacion por la nueva modena escogida
            $(".valorSubtotal").html((Number(conversion) * Number($(".valorSubtotal").attr("valor"))).toFixed(2))
            $(".valorTotalEnvio").html((Number(conversion) * Number($(".valorTotalEnvio").attr("valor"))).toFixed(2))
            $(".valorTotalImpuesto").html((Number(conversion) * Number($(".valorTotalImpuesto").attr("valor"))).toFixed(2))
            $(".valorTotalCompra").html((Number(conversion) * Number($(".valorTotalCompra").attr("valor"))).toFixed(2))

            //captra del valor inicial, de cada uno de los elememto con esta clase
            var valorItem = $(".valorItem");

            //recorremos todos los item
            for (var i = 0; i < valorItem.length; i++) {
                //cambio de datos en cada nos de lo sitem, multiplicando la nueva modena
                $(valorItem[i]).html((Number(conversion) * Number($(valorItem[i]).attr("valor"))).toFixed(2))

            }



            pagarConPayu();


        }

    })


})


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 BOTÓN PAGAR PAYPAL
 =============================================*/

//btn del modal para ejecutar el pago
$(".btnPagar").click(function () {
    //capturamos el tipo que es un atributo que tiene este boton
    var tipo = $(this).attr("tipo");

    //console.log($("#seleccionarPais").val());
    if (tipo == "fisico" && $("#seleccionarPais").val() == "") {
        $('.alert').remove();  //para que remueva si habia etiquetas de error antiguas
        $(".btnPagar").after('<div class="alert alert-warning">No ha seleccionado el país de envío</div>');

        return;

    }


    //CAPTURA DE DATOS QUE SE ENVIARAN A LA FORMA DE PAGO
    var divisa = $("#cambiarDivisa").val();
    var total = $(".valorTotalCompra").html();
    var impuesto = $(".valorTotalImpuesto").html();
    var envio = $(".valorTotalEnvio").html();
    var subtotal = $(".valorSubtotal").html();
    var titulo = $(".valorTitulo");
    var cantidad = $(".valorCantidad");
    var valorItem = $(".valorItem");
    var idProducto = $('.cuerpoCarrito button, .comprarAhora button');

    //variables que se llenaran en el for, recorriendo cada uno de los articulos
    var tituloArray = [];
    var cantidadArray = [];
    var idProductoArray = [];
    var valorItemArray = [];

    //recorremos todos los productos, de acuerdo a la cantidad de productos que hallan
    for (var i = 0; i < titulo.length; i++) {

        tituloArray[i] = $(titulo[i]).html();
        cantidadArray[i] = $(cantidad[i]).html();
        idProductoArray[i] = $(idProducto[i]).attr("idProducto");
        valorItemArray[i] = $(valorItem[i]).html();
    }

    /*  console.log(tituloArray);
     console.log(cantidadArray);
     console.log(idProductoArray);
     console.log(valorItemArray);
     */

    //peticion ajax para enviar toda la informacion al controlador
    var datos = new FormData();

    datos.append("divisa", divisa);
    datos.append("total", total);
    datos.append("impuesto", impuesto);
    datos.append("envio", envio);
    datos.append("subtotal", subtotal);
    datos.append("tituloArray", tituloArray);
    datos.append("cantidadArray", cantidadArray);
    datos.append("valorItemArray", valorItemArray);
    datos.append("idProductoArray", idProductoArray);

    $.ajax({
        url: rutaOculta + "ajax/carrito.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {

            console.log(respuesta);
            //redireccionamos hacia la URL respectiva
            window.location = respuesta;

        }

    })


})


/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 BOTÓN PAGAR PAYU
 =============================================*/

function pagarConPayu() {

    //console.log($("#seleccionarPais").val());
    if ($("#seleccionarPais").val() == "") { // validamos que el paise no este nulo

        $('.alert').remove();  //para que remueva si habia etiquetas de error antiguas
        $(".formPayu").after('<div class="alert alert-warning">No ha seleccionado el país de envío</div>');

        //seleccionamos el boton de envio
        $('.formPayu input[name="Submit"]').attr("type", "button");

        return;

    }


    //CAPTURA DE DATOS QUE SE ENVIARAN A LA FORMA DE PAGO
    var divisa = $("#cambiarDivisa").val();
    var total = $(".valorTotalCompra").html();
    var impuesto = $(".valorTotalImpuesto").html();
    var envio = $(".valorTotalEnvio").html();
    var subtotal = $(".valorSubtotal").html();
    var titulo = $(".valorTitulo");
    var cantidad = $(".valorCantidad");
    var valorItem = $(".valorItem");
    var idProducto = $('.cuerpoCarrito button, .comprarAhora button');


    //variables que se llenaran en el for, recorriendo cada uno de los articulos
    var tituloArray = [];
    var cantidadArray = [];
    var idProductoArray = [];
    var valorItemArray = [];

    /*=========================
     * A payu no se le envia el discrimando de precio por articulo
     * Le pasamos el total ya que aparecera solo un item concatenado con todos lo productos
     * =========================*/

    //recorremos todos los productos, de acuerdo a la cantidad de productos que hallan
    for (var i = 0; i < titulo.length; i++) {

        tituloArray[i] = $(titulo[i]).html();
        cantidadArray[i] = $(cantidad[i]).html();
        idProductoArray[i] = $(idProducto[i]).attr("idProducto");
    }

    var datos = new FormData();
    datos.append("metodoPago", "payu");

    //peticion que traera la informacion de conexion/credenciales con payu
    $.ajax({
        url: rutaOculta + "ajax/carrito.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
            console.log(respuesta);


            /*Rellenaremos la informacion de lso campos al formulario Hidden de payu*/

            //variables que contendran los datos parseados de acuerdo a lo que traiga la BD
            var merchantId = JSON.parse(respuesta).merchantIdPayu;
            var accountId = JSON.parse(respuesta).accountIdPayu;
            var apiKey = JSON.parse(respuesta).apiKeyPayu;
            var modo = JSON.parse(respuesta).modoPayu;
            //validacion de acuerdo a lo que venga se ejecutara la informacion
            if (modo == "sandbox") {
                var url = "https://sandbox.gateway.payulatam.com/ppp-web-gateway/";
                var test = 1;
            } else {
                var url = "https://gateway.payulatam.com/ppp-web-gateway/";
                var test = 0;
            }
            var description = tituloArray.toString(); // Convertimos a string
            var referenceCode = (Number(Math.ceil(Math.random() * 1000000)) + Number(total).toFixed()); // numero aleatorio
            var productosToString = idProductoArray.toString();
            var productos = productosToString.replace(/,/g, "-"); // remplazamos las comas a -, cada id de proudcto
            var cantidadToString = cantidadArray.toString();
            var cantidad = cantidadToString.replace(/,/g, "-"); // remplazamos las comas po -
            //hex_md5 // funcion que proviene de un plugin
            var signature = hex_md5(apiKey + "~" + merchantId + "~" + referenceCode + "~" + total + "~" + divisa);  // cigrando en MD5 las variables

            //console.log(signature);
            /*Cambiando variables en el formulario*/
            $(".formPayu").attr("method", "POST");
            $(".formPayu").attr("action", url);
            $(".formPayu input[name='merchantId']").attr("value", merchantId);
            $(".formPayu input[name='accountId']").attr("value", accountId);
            $(".formPayu input[name='description']").attr("value", description);
            $(".formPayu input[name='referenceCode']").attr("value", referenceCode);
            $(".formPayu input[name='amount']").attr("value", total);
            $(".formPayu input[name='tax']").attr("value", impuesto);
            if (divisa == "COP") {  // solo valido para colomba, si se tiene IVA, de lo contrari odebe ir en 0
                var taxReturnBase = (total - impuesto).toFixed(2)
                //resta del total menos el impuesto, con solo 2 decimales
            } else {
                var taxReturnBase = 0;
            }
            /*
             * la pagina de confirmacion, es necsario que el proyecto este publico
             * ya que no funcionara como localhost o intranet
             * */
            $(".formPayu input[name='taxReturnBase']").attr("value", taxReturnBase);
            $(".formPayu input[name='shipmentValue']").attr("value", envio);
            $(".formPayu input[name='currency']").attr("value", divisa);
            $(".formPayu input[name='responseUrl']").attr("value", rutaOculta + "index.php?ruta=finalizar-compra&payu=true&productos=" + productos + "&cantidad=" + cantidad);
            $(".formPayu input[name='declinedResponseUrl']").attr("value", rutaOculta + "carrito-de-compras");
            if (envio != 0) {  // validacion si el envio es fisico, para que diligencie los campos de direccion
                var tipoEnvio = "YES";
            } else {
                var tipoEnvio = "NO";
            }
            $(".formPayu input[name='displayShippingInformation']").attr("value", tipoEnvio);
            $(".formPayu input[name='test']").attr("value", test);
            $(".formPayu input[name='signature']").attr("value", signature);

            /*=============================================
             GENERADOR DE TARJETAS DE CRÉDITO
             http://www.elfqrin.com/discard_credit_card_generator.php


             //Nombre de la tarjeta
             APPROVED

             =============================================*/

        }

    });


}






/*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 /*=============================================
 AGREGAR PRODUCTOS GRATIS
 =============================================*/

$('.agregarGratis').click(function(){

    var idProducto = $(this).attr("idProducto");
    var idUsuario = $(this).attr("idUsuario");
    var tipo = $(this).attr("tipo");
    var titulo = $(this).attr("titulo");
    var agregarGratis = false;

    /*=============================================
     VERIFICAR QUE NO TENGA EL PRODUCTO ADQUIRIDO
     =============================================*/
    var datos = new FormData();

    datos.append("idUsuario", idUsuario);
    datos.append("idProducto", idProducto);

    $.ajax({
        url:rutaOculta+"ajax/carrito.ajax.php",
        method:"POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success:function(respuesta){

            console.log(respuesta);

            //validacion debe ser != pero se deja asi para que pueda alcenar por ahora la compra gratuita
        if(respuesta == "false"){

                swal({
                    title: "¡Usted ya adquirió este producto!",
                    text: "",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Regresar",
                    closeOnConfirm: false
                })


            }else{

                if(tipo == "virtual"){

                    agregarGratis = true;

                }else{

                    var seleccionarDetalle = $(".seleccionarDetalle");

                    for(var i = 0; i < seleccionarDetalle.length; i++){

                        if($(seleccionarDetalle[i]).val() == ""){

                            swal({
                                title: "Debe seleccionar Talla y Color",
                                text: "",
                                type: "warning",
                                showCancelButton: false,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "¡Seleccionar!",
                                closeOnConfirm: false
                            })

                        }else{

                            titulo = titulo + "-" + $(seleccionarDetalle[i]).val();

                            agregarGratis = true;

                        }

                    }

                }

                if(agregarGratis){

                    window.location = rutaOculta+"index.php?ruta=finalizar-compra&gratis=true&producto="+idProducto+"&titulo="+titulo;

                }

            }


        }
    });


});