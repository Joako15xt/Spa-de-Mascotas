<?php
require_once 'modelo/db.php';

class AuditLog {
    private $con;

    public function __construct(){
        $db = new Db();
        $this->con = $db->conexion;
    }

    public function registrar($usuarioId, $rol, $accion){
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'desconocido';

        $stmt = $this->con->prepare("
            INSERT INTO audit_logs (usuario_id, rol, accion, ip_address, user_agent)
            VALUES (?,?,?,?,?)
        ");
        $stmt->execute([$usuarioId, $rol, $accion, $ip, $ua]);
    }

    public function listar(){
        $stmt = $this->con->query("
            SELECT 
                a.id,
                a.usuario_id,
                u.nombre_completo,
                u.username,
                a.rol,
                a.accion,
                a.ip_address,
                a.user_agent,
                a.creado_en
            FROM audit_logs a
            LEFT JOIN usuarios u ON a.usuario_id = u.id
            ORDER BY a.creado_en DESC
            LIMIT 200
        ");

        return $stmt->fetchAll();
    }
}