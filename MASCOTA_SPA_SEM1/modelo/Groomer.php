<?php

require_once 'modelo/db.php';

class Groomer {

    private $con;

    public function __construct(){

        $db = new Db();
        $this->con = $db->conexion;
    }

    public function listar(){

        $sql = "

            SELECT

                g.*,
                u.nombre_completo AS nombre,
                u.username AS usuario,
                u.correo AS email

            FROM groomers g

            INNER JOIN usuarios u
                ON g.usuario_id = u.id

            ORDER BY u.nombre_completo ASC
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function usuariosDisponibles($usuario_actual = null){

        $sql = "

            SELECT u.id, u.nombre_completo, u.username, r.nombre AS rol_nombre

            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id

            WHERE u.rol_id IN (1, 3)
              AND (
                    u.id NOT IN (SELECT usuario_id FROM groomers)
                    OR u.id = :usuario_actual
                  )

            ORDER BY u.nombre_completo
        ";

        $stmt = $this->con->prepare($sql);
        $stmt->execute(['usuario_actual' => $usuario_actual ?? 0]);

        return $stmt->fetchAll();
    }

    public function obtenerPorId($id){

        $stmt = $this->con->prepare("

            SELECT *
            FROM groomers
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function crear($data){

        $stmt = $this->con->prepare("

            INSERT INTO groomers
            (
                usuario_id,
                especialidad,
                hora_inicio,
                hora_fin,
                activo
            )
            VALUES
            (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([

            $data['usuario_id'],
            $data['especialidad'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $data['activo']
        ]);
    }

    public function actualizar($data){

        $stmt = $this->con->prepare("

            UPDATE groomers
            SET

                usuario_id = ?,
                especialidad = ?,
                hora_inicio = ?,
                hora_fin = ?,
                activo = ?

            WHERE id = ?
        ");

        return $stmt->execute([

            $data['usuario_id'],
            $data['especialidad'],
            $data['hora_inicio'],
            $data['hora_fin'],
            $data['activo'],
            $data['id']
        ]);
    }
}