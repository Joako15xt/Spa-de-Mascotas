<?php
require_once 'modelo/Usuario.php';
require_once 'modelo/AuditLog.php';

class authController {
    public $view = 'login';
    public $page_title = 'Ingresar';

    private function csrf(){
        if(!isset($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    private function validarCSRF($token){
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], (string)$token);
    }

    private function sanitizar($txt){
        return trim(strip_tags((string)$txt));
    }

    private function iniciarSesion($row){
        session_regenerate_id(true);
        $_SESSION['usuario'] = [
            'id' => $row['id'],
            'nombre' => $row['nombre_completo'],
            'username' => $row['username'],
            'correo' => $row['correo'],
            'rol_id' => $row['rol_id'],
            'rol_nombre' => $row['rol_nombre']
        ];
        $_SESSION['last_activity'] = time();
    }

    public function login(){
        $this->view = 'login';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                if(!$this->validarCSRF($_POST['csrf'] ?? '')){
                    throw new Exception("Token CSRF inválido.");
                }

                $login = $this->sanitizar($_POST['login'] ?? '');
                $password = $_POST['password'] ?? '';

                if($login === '' || $password === ''){
                    throw new Exception("Ingrese correo/usuario y contraseña.");
                }

                $u = new Usuario();
                $log = new AuditLog();
                $row = $u->obtenerPorLogin($login);

                if(!$row){
                    $log->registrar(null, null, "Intento de login con usuario inexistente: ".$login);
                    throw new Exception("Usuario o contraseña incorrectos.");
                }

                if($row['estado'] === 'BLOQUEADO' && !empty($row['bloqueado_hasta']) && strtotime($row['bloqueado_hasta']) > time()){
                    $log->registrar($row['id'], $row['rol_nombre'], "Intento de login con cuenta bloqueada");
                    throw new Exception("Cuenta bloqueada temporalmente. Intente después.");
                }

                if($row['email_verificado'] == 0){
                    throw new Exception("Debe activar su cuenta desde el enlace enviado al correo.");
                }

                if(!password_verify($password, $row['password_hash'])){
                    $u->registrarIntentoFallido($row['id']);
                    $log->registrar($row['id'], $row['rol_nombre'], "Contraseña incorrecta");
                    throw new Exception("Usuario o contraseña incorrectos.");
                }

                $u->limpiarIntentos($row['id']);
                $log->registrar($row['id'], $row['rol_nombre'], "Login correcto");

                if($row['rol_nombre'] === 'ADMIN'){
                    $codigo = $u->generarCodigo($row['id'], 'LOGIN_2FA_ADMIN', $row['correo']);
                    $u->enviarCorreoDemo(
                        $row['correo'],
                        "Código 2FA PawSpa",
                        "Su código de acceso es: ".$codigo
                    );

                    $_SESSION['pendiente_2fa'] = [
                        'usuario_id' => $row['id'],
                        'demo_codigo' => $codigo
                    ];

                    header("Location: index.php?controller=auth&action=verificar2fa");
                    exit;
                }

                $this->iniciarSesion($row);
                header("Location: index.php");
                exit;

            } catch(Exception $e){
                return ['error' => $e->getMessage(), 'csrf' => $this->csrf()];
            }
        }

        return ['csrf' => $this->csrf()];
    }

    public function verificar2fa(){
        $this->view = 'verificar_2fa';
        $this->page_title = 'Verificación 2FA';

        if(!isset($_SESSION['pendiente_2fa'])){
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                if(!$this->validarCSRF($_POST['csrf'] ?? '')){
                    throw new Exception("Token CSRF inválido.");
                }

                $codigo = preg_replace('/\D/', '', $_POST['codigo'] ?? '');
                if(strlen($codigo) !== 4) throw new Exception("Ingrese el código de 4 dígitos.");

                $u = new Usuario();
                $usuarioId = $_SESSION['pendiente_2fa']['usuario_id'];

                if(!$u->validarCodigo($usuarioId, $codigo, 'LOGIN_2FA_ADMIN')){
                    throw new Exception("Código incorrecto o expirado.");
                }

                $row = $u->obtenerPorId($usuarioId);
                $this->iniciarSesion($row);

                unset($_SESSION['pendiente_2fa']);

                $log = new AuditLog();
                $log->registrar($row['id'], $row['rol_nombre'], "Verificación 2FA correcta");

                header("Location: index.php");
                exit;

            } catch(Exception $e){
                return [
                    'error' => $e->getMessage(),
                    'csrf' => $this->csrf(),
                    'demo_codigo' => $_SESSION['pendiente_2fa']['demo_codigo'] ?? ''
                ];
            }
        }

        return [
            'csrf' => $this->csrf(),
            'demo_codigo' => $_SESSION['pendiente_2fa']['demo_codigo'] ?? ''
        ];
    }

    public function registro(){
        $this->view = 'registro';
        $this->page_title = 'Registro de Cliente';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            try {
                if(!$this->validarCSRF($_POST['csrf'] ?? '')){
                    throw new Exception("Token CSRF inválido.");
                }

                $u = new Usuario();
                $res = $u->registrarCliente($_POST);

                $this->view = 'mensaje';
                return [
                    'titulo' => 'Cuenta creada',
                    'mensaje' => 'Se creó la cuenta del cliente correctamente. Ya puede iniciar sesión.'
                ];

            } catch(Exception $e){
                return ['error' => $e->getMessage(), 'csrf' => $this->csrf()];
            }
        }

        return ['csrf' => $this->csrf()];
    }

    public function activar(){
        $this->view = 'mensaje';
        $this->page_title = 'Activación';

        try {
            $token = $_GET['token'] ?? '';
            if($token === '') throw new Exception("Token no recibido.");

            $u = new Usuario();
            $u->activarCuenta($token);

            return [
                'titulo' => 'Cuenta activada',
                'mensaje' => 'La cuenta fue activada correctamente. Ya puede iniciar sesión.'
            ];
        } catch(Exception $e){
            return [
                'titulo' => 'Error de activación',
                'mensaje' => $e->getMessage()
            ];
        }
    }

    public function logout(){
        $_SESSION = [];
        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time()-42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        header("Location: index.php");
        exit;
    }
}