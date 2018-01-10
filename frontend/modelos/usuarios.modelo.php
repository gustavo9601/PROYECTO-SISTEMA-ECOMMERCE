<?php

require_once "conexion.php";

class ModeloUsuarios
{

    /*=============================================
    REGISTRO DE USUARIO
    =============================================*/

    static public function mdlRegistroUsuario($tabla, $datos)
    {

        $stmt = @Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, password, email, foto, modo, verificacion, emailEncriptado) VALUES (:nombre, :password, :email, :foto, :modo, :verificacion, :emailEncriptado)");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":modo", $datos["modo"], PDO::PARAM_STR);
        $stmt->bindParam(":verificacion", $datos["verificacion"], PDO::PARAM_INT);
        $stmt->bindParam(":emailEncriptado", $datos["emailEncriptado"], PDO::PARAM_STR);

        if ($stmt->execute()) {

            return "ok";

        } else {

            return "error";

        }

        $stmt->close();
        $stmt = null;

    }
}