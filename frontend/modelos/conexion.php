<?php

class Conexion
{

    public function conectar()
    {
        try {
            $conexion = new PDO("mysql:host=localhost;dbname=ecommerce",
                "root",
                "",
            /*Especificamos que los caracteres latinos no sean alterados*/
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );

            return $conexion;
        } catch (PDOException $e) {
            return die("Error de conexion Error" . $e->getMessage());
        }
    }
}



