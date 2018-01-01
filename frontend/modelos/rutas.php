<?php

class Ruta
{


    /*==============================================
    RUTA DEL LADO DEL CLIENTE
    ================================================
    */
    public function ctrRuta()
    {
        //Ruta fija, para encontrar los archivos vinculados
        return "http://localhost:85/PROYECTO%20SISTEMA%20ECOMMERCE/frontend/";

    }


    /*==============================================
    RUTA DEL SERVIDOR, A ARCHIVO BACKEND
    ================================================
    */
    public function ctrRutaServidor()
    {
        //Ruta fija, para encontrar los archivos vinculados
        return "http://localhost:85/PROYECTO%20SISTEMA%20ECOMMERCE/backend/";

    }

}