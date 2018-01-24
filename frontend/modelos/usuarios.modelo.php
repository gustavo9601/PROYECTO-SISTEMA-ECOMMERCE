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

    /*=============================================
    MOSTRAR USUARIO
    =============================================*/
    static public function mdlMostrarUsuario($tabla, $item, $valor)
    {

        $stmt = @Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
        $stmt->close();
        $stmt = null;
    }


    /*=============================================
       ACTUALIZAR USUARIO
       =============================================*/
    static public function mdlActualizarUsuario($tabla, $id, $item2, $valor2)
    {

        $stmt = @Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :$item2 WHERE id = :id");
        $stmt->bindParam(':' . $item2, $valor2, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }
        $stmt->close();
        $stmt = null;
    }


    static public function mdlActualizarPerfil($tabla, $datos)
    {

        /* $sql = "UPDATE $tabla SET nombre = {$datos['nombre']}, email = {$datos['email']}, password = {$datos['password']}, foto = {$datos['foto']} WHERE id = {$datos['id']}";
         echo $sql;
        */
        $stmt = @Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, email = :email, password = :password, foto = :foto WHERE id = :id");

        $stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);
        $stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
        $stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);


        if ($stmt->execute()) {

            return "ok";

        } else {

            return "error";

        }

        $stmt->close();
        $stmt = null;
    }


    /*=============================================
MOSTRAR USUARIO
=============================================*/
    static public function mdlMostrarCompras($tabla, $item, $valor)
    {

        $stmt = @Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
        $stmt->bindParam(':' . $item, $valor, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt = null;
    }

    /*=============================================
MOSTRAR EL COMENTRIO POR ID USUARIO Y ID PRODUCTO
=============================================*/

    static public function mdlMostrarComentariosPerfil($tabla, $datos)
    {

        if ($datos['idUsuario'] != "") {
            $stmt = @Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario AND id_producto = :id_producto");
            $stmt->bindParam(':id_usuario', $datos['idUsuario'], PDO::PARAM_INT);
            $stmt->bindParam(':id_producto', $datos['idProducto'], PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
            $stmt->close();
            $stmt = null;
        } else {
            //generamos aleatorio los comentarios
            $stmt = @Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE  id_producto = :id_producto ORDER BY Rand()");
            $stmt->bindParam(':id_producto', $datos['idProducto'], PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
            $stmt = null;
        }

    }

    /*=============================================
    ACTUALIZAR COMENTARIO
    =============================================*/

    static public function mdlActualizarComentario($tabla, $datos)
    {

        $stmt = @Conexion::conectar()->prepare("UPDATE $tabla SET calificacion = :calificacion, comentario = :comentario WHERE id = :id");

        $stmt->bindParam(":calificacion", $datos["calificacion"], PDO::PARAM_STR);
        $stmt->bindParam(":comentario", $datos["comentario"], PDO::PARAM_STR);
        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_STR);


        if ($stmt->execute()) {
            return 'ok';
        } else {
            return "error";
        }

        $stmt->close();

        $stmt = null;

    }

    /*=============================================
   AGREGAR LISTA DE DESEOS
    =============================================*/

    static public function mdlAgregarDeseo($tabla, $datos)
    {
        $stmt = @Conexion::conectar()->prepare("INSERT INTO $tabla (id_usuario, id_producto, fecha) VALUES (:id_usuario, :id_producto , now())");

        $stmt->bindParam(":id_usuario", $datos["idUsuario"], PDO::PARAM_STR);
        $stmt->bindParam(":id_producto", $datos["idProducto"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return "error";
        }

        $stmt->close();

        $stmt = null;

    }

    /*=============================================
MOSTRAR LISTA DE DESEOS
=============================================*/
    static public function mdlMostrarDeseos($tabla, $item)
    {
        $stmt = @Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id_usuario = :id_usuario ORDER BY id DESC");

        $stmt->bindParam(":id_usuario", $item, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt->close();

        $stmt = null;

    }


    /*=============================================
QUITAR DE LA LISTA DE DE DESEOS
=============================================*/
    static public function mdlQuitarDeseos($tabla, $item)
    {
        $stmt = @Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_producto = :id");

        $stmt->bindParam(":id", $item, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $stmt->close();

        $stmt = null;

    }


    /*=============================================
 ELIMINAR USUARIO
 =============================================*/
    static public function mdlEliminarUsuario($tabla, $id)
    {
        $stmt = @Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

        $stmt->bindParam(":id", $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $stmt->close();

        $stmt = null;

    }

    /*=============================================
     ELIMINAR COMENTARIOS DE USUARIO
     =============================================*/
    static public function mdlEliminarComentarios($tabla, $id)
    {
        $stmt = @Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_usuario= :id_usuario");

        $stmt->bindParam(":id_usuario", $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $stmt->close();

        $stmt = null;

    }


    /*=============================================
     ELIMINAR COMPRAS DE USUARIO
     =============================================*/
    static public function mdlEliminarCompras($tabla, $id)
    {
        $stmt = @Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_usuario= :id_usuario");

        $stmt->bindParam(":id_usuario", $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $stmt->close();

        $stmt = null;

    }

    /*=============================================
     ELIMINAR DESEOS DE USUAIO
     =============================================*/
    static public function mdlEliminarListaDeseos($tabla, $id)
    {
        $stmt = @Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id_usuario= :id_usuario");

        $stmt->bindParam(":id_usuario", $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return 'ok';
        } else {
            return 'error';
        }

        $stmt->close();

        $stmt = null;

    }

}
