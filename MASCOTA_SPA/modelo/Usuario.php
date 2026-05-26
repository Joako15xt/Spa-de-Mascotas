<?php
require_once 'modelo/db.php';

class Usuario {
    private $con;

    public function __construct(){
        $db = new Db();
        $this->con = $db->conexion;
    }

    public function obtenerPorLogin($login){
        $stmt = $this->con->prepare("
            SELECT u.*, r.nombre AS rol_nombre
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.correo = ? OR u.username = ?
            LIMIT 1
        ");
        $stmt->execute([$login, $login]);
        return $stmt->fetch();
    }

    public function obtenerPorId($id){
        $stmt = $this->con->prepare("
            SELECT u.*, r.nombre AS rol_nombre
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.id = ?
        ");
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function correoExiste($correo, $idExcluir = null){
        if($idExcluir){
            $stmt = $this->con->prepare("SELECT id FROM usuarios WHERE correo=? AND id<>?");
            $stmt->execute([$correo, $idExcluir]);
        } else {
            $stmt = $this->con->prepare("SELECT id FROM usuarios WHERE correo=?");
            $stmt->execute([$correo]);
        }

        return (bool)$stmt->fetch();
    }

    public function validarPasswordFuerte($password){
        if(strlen($password) < 8) {
            return "La contraseña debe tener mínimo 8 caracteres.";
        }

        if(!preg_match('/[A-Z]/', $password)) {
            return "Debe incluir al menos una mayúscula.";
        }

        if(!preg_match('/[a-z]/', $password)) {
            return "Debe incluir al menos una minúscula.";
        }

        if(!preg_match('/[0-9]/', $password)) {
            return "Debe incluir al menos un número.";
        }

        if(!preg_match('/[\W_]/', $password)) {
            return "Debe incluir al menos un símbolo.";
        }

        return true;
    }

    public function registrarCliente($data){
        $nombre = trim($data['nombre_completo'] ?? '');
        $correo = trim($data['correo'] ?? '');
        $telefono = trim($data['telefono'] ?? '');
        $ci = trim($data['ci_nit'] ?? '');
        $direccion = trim($data['direccion'] ?? '');
        $password = $data['password'] ?? '';
        $password_confirm = $data['password_confirm'] ?? '';

        if($password !== $password_confirm){
            throw new Exception("Las contraseñas no coinciden.");
        }

        if($nombre === '' || $correo === '' || $password === '') {
            throw new Exception("Nombre, correo y contraseña son obligatorios.");
        }

        if($this->correoExiste($correo)){
            throw new Exception("Ese correo ya está registrado.");
        }

        $val = $this->validarPasswordFuerte($password);
        if($val !== true) {
            throw new Exception($val);
        }

        $username = explode('@', $correo)[0] . rand(10,99);
        $hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $this->con->beginTransaction();

            $stmt = $this->con->prepare("
                INSERT INTO usuarios
                (rol_id, nombre_completo, username, correo, telefono, password_hash, estado, email_verificado)
                VALUES (4, ?, ?, ?, ?, ?, 'ACTIVO', 1)
            ");

            $stmt->execute([
                $nombre,
                $username,
                $correo,
                $telefono,
                $hash
            ]);

            $usuarioId = $this->con->lastInsertId();

            $stmt2 = $this->con->prepare("
                INSERT INTO clientes
                (nombre_completo, ci_nit, telefono, correo, direccion)
                VALUES (?, ?, ?, ?, ?)
            ");

            $stmt2->execute([
                $nombre,
                $ci,
                $telefono,
                $correo,
                $direccion
            ]);

            $this->con->commit();

            return [
                'usuario_id' => $usuarioId,
                'correo' => $correo
            ];

        } catch(Exception $e){
            $this->con->rollBack();
            throw new Exception("Error al registrar cliente: " . $e->getMessage());
        }
    }

    public function activarCuenta($token){
        $stmt = $this->con->prepare("
            SELECT id
            FROM usuarios
            WHERE activation_token = ?
              AND activation_expira > NOW()
              AND email_verificado = 0
            LIMIT 1
        ");

        $stmt->execute([$token]);
        $u = $stmt->fetch();

        if(!$u) {
            throw new Exception("Token inválido o expirado.");
        }

        $upd = $this->con->prepare("
            UPDATE usuarios
            SET email_verificado = 1,
                activation_token = NULL,
                activation_expira = NULL
            WHERE id = ?
        ");

        $upd->execute([$u['id']]);

        return true;
    }

    public function crearPersonal($data){
        $rol_id = (int)($data['rol_id'] ?? 0);
        $nombre = trim($data['nombre_completo'] ?? '');
        $username = trim($data['username'] ?? '');
        $correo = trim($data['correo'] ?? '');
        $telefono = trim($data['telefono'] ?? '');
        $password = $data['password'] ?? '';
        $password_confirm = $data['password_confirm'] ?? '';

        if($password !== $password_confirm){
            throw new Exception("Las contraseñas no coinciden.");
        }

        if(!in_array($rol_id, [1,2,3])){
            throw new Exception("Rol inválido para personal.");
        }

        if($nombre === '' || $username === '' || $correo === '' || $password === '') {
            throw new Exception("Complete todos los campos obligatorios.");
        }

        if($this->correoExiste($correo)) {
            throw new Exception("Ese correo ya existe.");
        }

        $val = $this->validarPasswordFuerte($password);
        if($val !== true) {
            throw new Exception($val);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);

        try {
            $this->con->beginTransaction();

            $stmt = $this->con->prepare("
                INSERT INTO usuarios
                (rol_id, nombre_completo, username, correo, telefono, password_hash, estado, email_verificado)
                VALUES (?, ?, ?, ?, ?, ?, 'ACTIVO', 1)
            ");

            $stmt->execute([
                $rol_id,
                $nombre,
                $username,
                $correo,
                $telefono,
                $hash
            ]);

            $id = $this->con->lastInsertId();

            if($rol_id == 3){
                $g = $this->con->prepare("
                    INSERT INTO groomers
                    (usuario_id, especialidad, hora_inicio, hora_fin, activo)
                    VALUES (?, ?, '09:00:00', '18:00:00', 1)
                ");

                $g->execute([
                    $id,
                    $data['especialidad'] ?? 'Grooming general'
                ]);
            }

            $this->con->commit();

            return $id;

        } catch(Exception $e){
            $this->con->rollBack();
            throw new Exception("Error al crear usuario: " . $e->getMessage());
        }
    }

    public function listar(){
        $stmt = $this->con->query("
            SELECT 
                u.id,
                u.nombre_completo,
                u.username,
                u.correo,
                u.telefono,
                u.estado,
                u.email_verificado,
                r.nombre AS rol
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            ORDER BY u.id DESC
        ");

        return $stmt->fetchAll();
    }

    public function registrarIntentoFallido($id){
        $u = $this->obtenerPorId($id);

        if(!$u){
            return;
        }

        $intentos = ((int)$u['intentos_fallidos']) + 1;

        if($intentos >= MAX_LOGIN_ATTEMPTS){
            $bloqueado = date('Y-m-d H:i:s', time() + LOCK_MINUTES * 60);

            $stmt = $this->con->prepare("
                UPDATE usuarios
                SET intentos_fallidos = ?,
                    estado = 'BLOQUEADO',
                    bloqueado_hasta = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $intentos,
                $bloqueado,
                $id
            ]);
        } else {
            $stmt = $this->con->prepare("
                UPDATE usuarios
                SET intentos_fallidos = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $intentos,
                $id
            ]);
        }
    }

    public function limpiarIntentos($id){
        $stmt = $this->con->prepare("
            UPDATE usuarios
            SET intentos_fallidos = 0,
                bloqueado_hasta = NULL,
                estado = 'ACTIVO',
                ultimo_acceso = NOW()
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }

    public function generarCodigo($usuarioId, $tipo, $correo){
        $codigo = str_pad((string)random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        $expira = date('Y-m-d H:i:s', time() + TOKEN_EXPIRE_MINUTES * 60);

        $stmt = $this->con->prepare("
            INSERT INTO codigos_verificacion
            (usuario_id, codigo, tipo, enviado_a, usado, expira_en)
            VALUES (?, ?, ?, ?, 0, ?)
        ");

        $stmt->execute([
            $usuarioId,
            $codigo,
            $tipo,
            $correo,
            $expira
        ]);

        return $codigo;
    }

    public function validarCodigo($usuarioId, $codigo, $tipo){
        $stmt = $this->con->prepare("
            SELECT id
            FROM codigos_verificacion
            WHERE usuario_id = ?
              AND codigo = ?
              AND tipo = ?
              AND usado = 0
              AND expira_en > NOW()
            ORDER BY id DESC
            LIMIT 1
        ");

        $stmt->execute([
            $usuarioId,
            $codigo,
            $tipo
        ]);

        $row = $stmt->fetch();

        if(!$row) {
            return false;
        }

        $upd = $this->con->prepare("
            UPDATE codigos_verificacion
            SET usado = 1
            WHERE id = ?
        ");

        $upd->execute([$row['id']]);

        return true;
    }

    public function enviarCorreoDemo($destino, $asunto, $mensaje){
        @mail($destino, $asunto, $mensaje, "From: " . MAIL_FROM);

        $stmt = $this->con->prepare("
            INSERT INTO notificaciones
            (usuario_id, tipo, canal, destinatario, asunto, mensaje, estado, fecha_envio)
            VALUES (NULL, 'CODIGO_2FA', 'CORREO', ?, ?, ?, 'ENVIADA', NOW())
        ");

        $stmt->execute([
            $destino,
            $asunto,
            $mensaje
        ]);
    }
}