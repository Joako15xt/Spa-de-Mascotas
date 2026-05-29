<?php

require_once 'modelo/db.php';

class Cliente {

    private $con;

    public function __construct(){

        $db = new Db();
        $this->con = $db->conexion;
    }

    public function listar(){

        $sql = "
            SELECT *
            FROM clientes
            ORDER BY id DESC
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function obtenerPorId($id){

        $stmt = $this->con->prepare("
            SELECT *
            FROM clientes
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }
    public function obtenerPorCorreo($correo){

        $stmt = $this->con->prepare(
            "SELECT *
            FROM clientes
            WHERE correo = ?
            LIMIT 1
        ");

        $stmt->execute([trim($correo)]);

        return $stmt->fetch();
    }
    public function crear($data){

        $stmt = $this->con->prepare("
            INSERT INTO clientes
            (
                nombre_completo,
                ci_nit,
                telefono,
                correo,
                direccion
            )
            VALUES
            (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['nombre_completo'],
            $data['ci_nit'],
            $data['telefono'],
            $data['correo'],
            $data['direccion']
        ]);
    }

    public function actualizar($id, $data){

        $stmt = $this->con->prepare("
            UPDATE clientes
            SET
                nombre_completo = ?,
                ci_nit = ?,
                telefono = ?,
                correo = ?,
                direccion = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['nombre_completo'],
            $data['ci_nit'],
            $data['telefono'],
            $data['correo'],
            $data['direccion'],
            $id
        ]);
    }

    public function eliminar($id){

        $stmt = $this->con->prepare("
            DELETE FROM clientes
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}