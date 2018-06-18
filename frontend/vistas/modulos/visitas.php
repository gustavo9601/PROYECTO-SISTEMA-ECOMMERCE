
<?php

/*=============================================
CREADOR DE IP
=============================================*/

//https://www.browserling.com/tools/random-ip

//$ip = $_SERVER['REMOTE_ADDR'];   // nos devuelve la informacion de la ip publica

$ip = "153.205.198.22";

//http://www.geoplugin.net/  // de acuerdo a la IP que yop le envie me devuelve informacion de la IP Publica

$informacionPais = file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip);  // con file_get_contents // obtenemos lo que contega la URL

$datosPais = json_decode($informacionPais);  // convertimos a Json

$pais = $datosPais->geoplugin_countryName;
$codigo = $datosPais->geoplugin_countryCode;

//insertamos la visita . con la IP publica
$enviarIp = ControladorVisitas::ctrEnviarIp($ip, $pais, $codigo);

//consultamos la cantidad de visitas
$totalVisitas = ControladorVisitas::ctrMostrarTotalVisitas();

?>

<!--=====================================
BREADCRUMB VISITAS
======================================-->
<div class="container-fluid well well-sm">

    <div class="container">

        <div class="row">

            <ul class="breadcrumb lead">

                <h2 class="pull-right"><small>Tu eres nuestro visitante # <?php echo $totalVisitas["total"];?></small></h2>

            </ul>

        </div>

    </div>

</div>

<!--=====================================
MÓDULO VISITAS
======================================-->

<div class="container-fluid">

    <div class="container">

        <div class="row">

            <?php

            $paises = ControladorVisitas::ctrMostrarPaises();

            $coloresPaises = array("#09F","#900","#059","#260","#F09","#02A");

            $indice = -1;

            foreach($paises as $key => $value){

                $promedio = $value["cantidad"] * 100 / $totalVisitas["total"];  // es la cantidad de personas visitadas por 1 pais dividiendo al 100% de personas visitadas

                $indice++;

                echo '<div class="col-md-2 col-sm-4 col-xs-12 text-center">
				
					<h2 class="text-muted">'.$value["pais"].'</h2>

					<input type="text" class="knob" value="'.round($promedio).'" data-width="90" data-height="90" data-fgcolor="'.$coloresPaises[$indice].'" data-readonly="true">
 
					<p class="text-muted text-center" style="font-size:12px"> '.round($promedio).'% de las visitas</p>
	
				</div>';
            }


            ?>

        </div>

    </div>

</div>