<?php

require_once "../controladores/plantilla.controlador.php";
require_once "../modelos/plantilla.modelo.php";

class AjaxPlantilla
{
    public function ajaxEstiloPlantilla()
    {
        $respuesta = @ControladorPlantilla::ctrEstilosPlantilla();
        //devolvemos un Json que entienda javascript, de array -> string
        echo json_encode($respuesta);
    }
}

$objeto = new AjaxPlantilla();
$objeto->ajaxEstiloPlantilla();
