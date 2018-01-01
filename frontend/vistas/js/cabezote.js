/*=============================================
 CABEZOTE
 =============================================*/
//Click para ejecutar el slideToogle
var btnCategorias = $("#btnCategorias");
var cajaCategorias = $('#categorias');
var cabezote =  $("#cabezote");
btnCategorias.click(function () {
    //
    if (window.matchMedia("(max-width:767px)").matches) {  // es <= 767px
        //cuando estemos en un disposiibo movil, le desimos con after, donde queremos que aparesca
        btnCategorias.after(cajaCategorias.slideToggle("fast"));
    } else {
       cabezote.after(cajaCategorias.slideToggle("fast"));
    }
});

