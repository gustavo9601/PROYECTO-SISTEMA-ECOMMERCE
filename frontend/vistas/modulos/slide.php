<?php
$servidor = @Ruta::ctrRutaServidor();
?>
<!--
    /*=============================================
    SLIDESHOW
     =============================================*/
-->

<div class="container-fluid" id="slide">
    <div class="row">
        <!--
    /*=============================================
    DIAPOSITIVAS
     =============================================*/
-->
        <ul>

            <?php
            $slide = ControladorSlide::ctrMostrarSlide();
            /*  var_dump($slide);*/

            foreach ($slide as $dato) {

                $estiloImgProducto = json_decode($dato['estiloImgProducto'], true);  //econdemos a json los valores yaque vienen en formato json de la bd
                //var_dump($estiloImgProducto);
                $estiloTextoSlide = json_decode($dato['estiloTextoSlide'], true);
                $titulo1 = json_decode($dato['titulo1'], true);
                $titulo2 = json_decode($dato['titulo2'], true);
                $titulo3 = json_decode($dato['titulo3'], true);
                echo '
            <li>
                <img src="' . $servidor . $dato['imgFondo'] . '"
                     alt="">
                <div class="slideOpciones ' . $dato['tipoSlide'] . '">
                    <img src="' . $servidor . $dato['imgProducto'] . '"
                         alt="" class="imgProducto" style="top:' . $estiloImgProducto['top'] . '; right:' . $estiloImgProducto['right'] . '; width:' . $estiloImgProducto['width'] . ';
                                                            left:' . $estiloImgProducto['left'] . '">

                    <div class="textosSlide" style="top:' . $estiloTextoSlide['top'] . '; right:' . $estiloTextoSlide['right'] . '; width:' . $estiloTextoSlide['width'] . ';
                                                            left:' . $estiloTextoSlide['left'] . '">
                        <h1 style="color:' . $titulo1['color'] . '">' . $titulo1['texto'] . '</h1>
                        <h2 style="color:' . $titulo2['color'] . '">' . $titulo2['texto'] . '</h2>
                        <h3 style="color:' . $titulo3['color'] . '">' . $titulo3['texto'] . '</h3>
                        <a href="' . $dato['url'] . '">
                         ' . $dato['boton'] . '
                        </a>
                    </div>
                </div>
            </li>
            ';
            }

            ?>

        </ul>

        <!--
         /*=============================================
        PAGINACION
          =============================================*/
     -->

        <ol id="paginacion">
            <?php
            $cantidad = count($slide);

            for ($i = 1; $i <= $cantidad; $i++) {
                echo '
                 <li item="' . $i . '"><span class="fa fa-circle"></span></li>
                ';
            }
            ?>
        </ol>


        <!--
           /*=============================================
          FLECHAS
            =============================================*/
       -->
        <div class="flechas" id="retroceder">
            <span class="fa fa-chevron-left"></span>
        </div>
        <div class="flechas" id="avanzar">
            <span class="fa fa-chevron-right"></span>
        </div>
    </div>

</div>
<div style="text-align: center">
    <button id="btnSlide" class="backColor">
        <i class="fa fa-angle-up"></i>
    </button>
</div>
