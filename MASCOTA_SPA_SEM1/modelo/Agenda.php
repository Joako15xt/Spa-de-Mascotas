<?php

require_once 'modelo/db.php';

class Agenda {

    private $con;

    public function __construct(){

        $db = new Db();
        $this->con = $db->conexion;
    }

    public function obtenerAgenda($fecha){

        $sql = "

            SELECT

                c.*,

                m.nombre AS mascota,

                s.nombre AS servicio,

                u.nombre_completo AS groomer

            FROM citas c

            INNER JOIN mascotas m
                ON c.mascota_id = m.id

            INNER JOIN servicios s
                ON c.servicio_id = s.id

            INNER JOIN groomers g
                ON c.groomer_id = g.id

            INNER JOIN usuarios u
                ON g.usuario_id = u.id

            WHERE c.fecha = ?

            ORDER BY c.hora_inicio ASC
        ";

        $stmt = $this->con->prepare($sql);

        $stmt->execute([$fecha]);

        return $stmt->fetchAll();
    }
}