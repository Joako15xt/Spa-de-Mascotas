<?php

require_once 'modelo/db.php';

class Grooming {

    private $con;

    public function __construct(){

        $db = new Db();
        $this->con = $db->conexion;
    }

    public function listar(){

        $sql = "

            SELECT

                gf.*,
                m.nombre AS mascota,
                s.nombre AS servicio

            FROM grooming_fichas gf

            INNER JOIN citas c
                ON gf.cita_id = c.id

            INNER JOIN mascotas m
                ON c.mascota_id = m.id

            INNER JOIN servicios s
                ON c.servicio_id = s.id

            ORDER BY gf.id DESC
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function citasDisponibles(){

        $sql = "

            SELECT

                c.id,
                m.nombre AS mascota,
                s.nombre AS servicio

            FROM citas c

            INNER JOIN mascotas m
                ON c.mascota_id = m.id

            INNER JOIN servicios s
                ON c.servicio_id = s.id

            WHERE c.estado != 'FINALIZADA'
              AND c.id NOT IN (SELECT cita_id FROM grooming_fichas)

            ORDER BY c.fecha DESC, c.hora_inicio DESC
        ";

        return $this->con->query($sql)->fetchAll();
    }

    public function crear($data){

        $stmt = $this->con->prepare("

            INSERT INTO grooming_fichas
            (
                cita_id,
                estado_mascota,
                comportamiento,
                recomendaciones,
                observaciones,
                tiempo_real_minutos
            )
            VALUES
            (?, ?, ?, ?, ?, ?)
        ");

        if(empty($data['cita_id'])){
            throw new Exception("Debe seleccionar una cita para crear la ficha de grooming.");
        }

        $stmt->execute([

            $data['cita_id'],
            $data['estado_mascota'],
            $data['comportamiento'],
            $data['recomendaciones'],
            $data['observaciones'],
            $data['tiempo_real_minutos']
        ]);

        $ficha_id = $this->con->lastInsertId();

        $updateCita = $this->con->prepare("UPDATE citas SET estado = 'FINALIZADA' WHERE id = ?");
        $updateCita->execute([$data['cita_id']]);

        $stmt2 = $this->con->prepare("

            INSERT INTO grooming_checklist
            (
                ficha_id,
                bano,
                corte,
                unas,
                oidos,
                perfume,
                glandulas
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt2->execute([

            $ficha_id,

            isset($data['bano']) ? 1 : 0,
            isset($data['corte']) ? 1 : 0,
            isset($data['unas']) ? 1 : 0,
            isset($data['oidos']) ? 1 : 0,
            isset($data['perfume']) ? 1 : 0,
            isset($data['glandulas']) ? 1 : 0
        ]);

        return true;
    }
}