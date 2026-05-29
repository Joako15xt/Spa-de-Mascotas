<?php

require_once 'modelo/db.php';

class Mascota {

    private $con;

    public function __construct(){

        $db = new Db();
        $this->con = $db->conexion;
    }

    public function listar(){

        $sql = "
            SELECT 
                m.*,
                c.nombre_completo AS cliente
            FROM mascotas m
            INNER JOIN clientes c
                ON m.cliente_id = c.id
            ORDER BY m.id DESC
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function listarPorCliente($clienteId){

        $stmt = $this->con->prepare(" 
            SELECT 
                m.*,
                c.nombre_completo AS cliente
            FROM mascotas m
            INNER JOIN clientes c
                ON m.cliente_id = c.id
            WHERE m.cliente_id = ?
            ORDER BY m.id DESC
        ");

        $stmt->execute([(int)$clienteId]);
        return $stmt->fetchAll();
    }

    public function clientes(){

        $sql = "
            SELECT *
            FROM clientes
            ORDER BY nombre_completo ASC
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function obtenerPorId($id){

        $stmt = $this->con->prepare("
            SELECT *
            FROM mascotas
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function crear($data){

        $stmt = $this->con->prepare("
            INSERT INTO mascotas
            (
                cliente_id,
                nombre,
                especie,
                raza,
                sexo,
                peso,
                color,
                fecha_nacimiento,
                tamano,
                vacunas,
                alergias,
                comportamiento,
                observaciones,
                temperamento,
                tiempo_mascota
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([

            $data['cliente_id'],
            $data['nombre'],
            $data['especie'],
            $data['raza'],
            $data['sexo'],
            $data['peso'],
            $data['color'],
            $data['fecha_nacimiento'] ?? null,
            $data['tamano'] ?? 'PEQUENO',
            $data['vacunas'],
            $data['alergias'],
            $data['comportamiento'] ?? null,
            $data['observaciones'] ?? null,
            $data['temperamento'],
            $data['tiempo_mascota']
        ]);
    }

    public function actualizar($id, $data){

        $stmt = $this->con->prepare("
            UPDATE mascotas
            SET
                cliente_id = ?,
                nombre = ?,
                especie = ?,
                raza = ?,
                sexo = ?,
                peso = ?,
                color = ?,
                fecha_nacimiento = ?,
                tamano = ?,
                vacunas = ?,
                alergias = ?,
                comportamiento = ?,
                observaciones = ?,
                temperamento = ?,
                tiempo_mascota = ?
            WHERE id = ?
        ");

        return $stmt->execute([

            $data['cliente_id'],
            $data['nombre'],
            $data['especie'],
            $data['raza'],
            $data['sexo'],
            $data['peso'],
            $data['color'],
            $data['fecha_nacimiento'] ?? null,
            $data['tamano'] ?? 'PEQUENO',
            $data['vacunas'],
            $data['alergias'],
            $data['comportamiento'] ?? null,
            $data['observaciones'] ?? null,
            $data['temperamento'],
            $data['tiempo_mascota'],
            $id
        ]);
    }

    public function eliminar($id){

        $stmt = $this->con->prepare("
            DELETE FROM mascotas
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }
}