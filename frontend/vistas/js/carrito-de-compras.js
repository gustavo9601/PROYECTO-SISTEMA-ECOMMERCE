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