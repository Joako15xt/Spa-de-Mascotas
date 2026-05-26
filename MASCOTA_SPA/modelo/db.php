<?php
class Db {
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host=".DB_HOST.";dbname=".DB.";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("<div style='color:red'>Error DB: ".htmlspecialchars($e->getMessage())."</div>");
        }
    }

    public function seedDefaults(){
        $this->conexion->exec("INSERT IGNORE INTO roles (id,nombre) VALUES
            (1,'ADMIN'),(2,'RECEPCION'),(3,'GROOMER'),(4,'CLIENTE')");

        $stmt = $this->conexion->prepare("SELECT id FROM usuarios WHERE correo=?");
        $stmt->execute(['admin@pawspa.com']);

        if(!$stmt->fetch()){
            $hash = password_hash('Admin123!', PASSWORD_BCRYPT);
            $this->conexion->prepare("
                INSERT INTO usuarios
                (rol_id,nombre_completo,username,correo,telefono,password_hash,estado,email_verificado)
                VALUES (?,?,?,?,?,?,?,?)
            ")->execute([
                1,
                'Administrador PawSpa',
                'admin',
                'admin@pawspa.com',
                '77777777',
                $hash,
                'ACTIVO',
                1
            ]);
        }
    }
}