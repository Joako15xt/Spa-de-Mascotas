<?php
require_once __DIR__ . '/db.php';

class Dashboard {

    private $con;

    public function __construct(){
        $db = new Db();
        $this->con = $db->conexion;
    }

    public function totalClientes(){

        $sql = "SELECT COUNT(*) total FROM clientes";
        return $this->con->query($sql)->fetch()['total'];
    }

    public function totalMascotas(){

        $sql = "SELECT COUNT(*) total FROM mascotas";
        return $this->con->query($sql)->fetch()['total'];
    }

    public function totalCitas(){

        $sql = "SELECT COUNT(*) total FROM citas";
        return $this->con->query($sql)->fetch()['total'];
    }

    public function totalGroomers(){

        $sql = "SELECT COUNT(*) total FROM groomers";
        return $this->con->query($sql)->fetch()['total'];
    }

    public function citasHoy(){

        $sql = "
            SELECT 
                c.id,
                m.nombre AS mascota,
                s.nombre AS servicio,
                c.fecha,
                c.hora_inicio,
                c.estado
            FROM citas c
            INNER JOIN mascotas m ON c.mascota_id = m.id
            INNER JOIN servicios s ON c.servicio_id = s.id
            WHERE DATE(c.fecha) = CURDATE()
            ORDER BY c.hora_inicio ASC
            LIMIT 10
        ";

        return $this->con->query($sql)->fetchAll();
    }
}