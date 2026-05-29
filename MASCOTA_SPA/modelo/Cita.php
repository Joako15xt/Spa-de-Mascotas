<?php

require_once 'modelo/db.php';

class Cita {

    private $con;

    public function __construct(){

        $db = new Db();
        $this->con = $db->conexion;
    }

    public function listar($clienteId = null){

        $sql = "

            SELECT

                c.*,

                m.nombre AS mascota,

                m.cliente_id AS cliente_id,

                s.nombre AS servicio,

                s.duracion_minutos,

                s.precio_base,

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
        ";

        if($clienteId !== null){
            $sql .= " WHERE m.cliente_id = ?";
            $stmt = $this->con->prepare($sql . " ORDER BY c.fecha DESC, c.hora_inicio DESC");
            $stmt->execute([(int)$clienteId]);
            return $stmt->fetchAll();
        }

        $sql .= " ORDER BY c.fecha DESC, c.hora_inicio DESC";

        return $this->con->query($sql)->fetchAll();
    }

    public function listarSolicitudes($clienteId = null){

        $sql = "

            SELECT

                c.*,

                m.nombre AS mascota,

                m.cliente_id AS cliente_id,

                s.nombre AS servicio,

                s.duracion_minutos,

                s.precio_base,

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

            WHERE c.motivo_cancelacion IS NOT NULL
              AND c.motivo_cancelacion <> ''
        ";

        if($clienteId !== null){
            $sql .= " AND m.cliente_id = ?";
            $stmt = $this->con->prepare($sql . " ORDER BY c.fecha DESC, c.hora_inicio DESC");
            $stmt->execute([(int)$clienteId]);
            return $stmt->fetchAll();
        }

        $sql .= " ORDER BY c.fecha DESC, c.hora_inicio DESC";

        return $this->con->query($sql)->fetchAll();
    }

    public function obtenerPorId($id){

        $stmt = $this->con->prepare(" 
            SELECT c.*, m.cliente_id AS cliente_id
            FROM citas c
            INNER JOIN mascotas m ON c.mascota_id = m.id
            WHERE c.id = ?
        ");

        $stmt->execute([(int)$id]);

        return $stmt->fetch();
    }

    public function mascotasPorCliente($clienteId){

        $stmt = $this->con->prepare(" 
            SELECT *
            FROM mascotas
            WHERE cliente_id = ?
            ORDER BY nombre ASC
        ");

        $stmt->execute([(int)$clienteId]);

        return $stmt->fetchAll();
    }

    public function verificarDisponibilidad($groomerId, $fecha, $horaInicio, $horaFin){

        $stmt = $this->con->prepare("SELECT hora_inicio, hora_fin, activo FROM groomers WHERE id = ? LIMIT 1");
        $stmt->execute([(int)$groomerId]);
        $g = $stmt->fetch();

        if(!$g || !$g['activo']){
            return "El groomer no está disponible.";
        }

        if($horaInicio < $g['hora_inicio'] || $horaFin > $g['hora_fin']){
            return "El horario seleccionado no está dentro de la disponibilidad del groomer ({$g['hora_inicio']} - {$g['hora_fin']}).";
        }

        $stmt = $this->con->prepare("SELECT COUNT(*) AS total FROM citas WHERE groomer_id = ? AND fecha = ? AND estado <> 'CANCELADA' AND hora_inicio < ? AND hora_fin > ?");
        $stmt->execute([$groomerId, $fecha, $horaFin, $horaInicio]);
        $conflictos = $stmt->fetch();

        if($conflictos && $conflictos['total'] > 0){
            return "Ya existe una cita en ese horario para el groomer seleccionado.";
        }

        return true;
    }

    public function solicitarAnulacion($id, $motivo){

        $stmt = $this->con->prepare(" 
            UPDATE citas
            SET motivo_cancelacion = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            trim($motivo),
            (int)$id
        ]);
    }

    public function cancelar($id){

        $stmt = $this->con->prepare(" 
            UPDATE citas
            SET estado = 'CANCELADA'
            WHERE id = ?
        ");

        return $stmt->execute([(int)$id]);
    }

    public function mascotas(){

        return $this->con
            ->query("SELECT * FROM mascotas ORDER BY nombre")
            ->fetchAll();
    }

    public function servicios(){

        return $this->con
            ->query("SELECT * FROM servicios WHERE activo=1")
            ->fetchAll();
    }

    public function groomers(){

        $sql = "

            SELECT

                g.*,
                u.nombre_completo

            FROM groomers g

            INNER JOIN usuarios u
                ON g.usuario_id = u.id

            WHERE g.activo = 1
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function crear($data){

        $servicio = $this->obtenerServicio($data['servicio_id']);

        $duracion = $servicio['duracion_minutos'];

        $hora_inicio = $data['hora_inicio'];

        $hora_fin = date(
            'H:i:s',
            strtotime("+$duracion minutes", strtotime($hora_inicio))
        );

        $stmt = $this->con->prepare("

            INSERT INTO citas
            (
                mascota_id,
                servicio_id,
                groomer_id,
                fecha,
                hora_inicio,
                hora_fin,
                estado,
                observaciones,
                duracion_minutos,
                precio_final,
                creado_por
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([

            $data['mascota_id'],
            $data['servicio_id'],
            $data['groomer_id'],
            $data['fecha'],
            $hora_inicio,
            $hora_fin,
            $data['estado'],
            $data['observaciones'],
            $duracion,
            $servicio['precio_base'],
            $_SESSION['usuario']['id']
        ]);
    }

    public function obtenerServicio($id){

        $stmt = $this->con->prepare("
            SELECT *
            FROM servicios
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}