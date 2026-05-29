<?php

require_once 'modelo/db.php';

class Servicio {

    private $con;

    public function __construct(){

        $db = new Db();
        $this->con = $db->conexion;
    }

    public function listar(){

        $sql = "
            SELECT *
            FROM servicios
            ORDER BY id DESC
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function obtenerPorId($id){

        $stmt = $this->con->prepare("
            SELECT *
            FROM servicios
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function crear($data){

        $stmt = $this->con->prepare("
            INSERT INTO servicios
            (
                nombre,
                descripcion,
                duracion_minutos,
                precio_base,
                activo
            )
            VALUES
            (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([

            $data['nombre'],
            $data['descripcion'],
            $data['duracion_minutos'],
            $data['precio_base'],
            $data['activo']
        ]);
    }

    public function actualizar($id, $data){

        $stmt = $this->con->prepare("
            UPDATE servicios
            SET
                nombre = ?,
                descripcion = ?,
                duracion_minutos = ?,
                precio_base = ?,
                activo = ?
            WHERE id = ?
        ");

        return $stmt->execute([

            $data['nombre'],
            $data['descripcion'],
            $data['duracion_minutos'],
            $data['precio_base'],
            $data['activo'],
            $id
        ]);
    }

    public function eliminar($id){

        $stmt = $this->con->prepare("
            DELETE FROM servicios
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}