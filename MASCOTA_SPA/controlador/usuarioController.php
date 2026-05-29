<?php
require_once __DIR__ . '/../modelo/Usuario.php';
require_once __DIR__ . '/../modelo/AuditLog.php';

class usuarioController {
    public $view = 'usuario_lista';
    public $page_title = 'Usuarios';

    private function csrf(){
        if(!isset($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    private function soloAdmin(){
        if(!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_nombre'] !== 'ADMIN'){
            throw new Exception("Acceso denegado. Solo el administrador puede gestionar usuarios.");
        }
    }

    public function listar(){
        try {
            $this->soloAdmin();
            $u = new Usuario();
            return ['usuarios' => $u->listar(), 'csrf' => $this->csrf()];
        } catch(Exception $e){
            $this->view = 'mensaje';
            return ['titulo' => 'Acceso denegado', 'mensaje' => $e->getMessage()];
        }
    }

    public function crear(){
        $this->view = 'usuario_form';
        $this->page_title = 'Crear Personal';

        try {
            $this->soloAdmin();

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if(!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf'])){
                    throw new Exception("Token CSRF inválido.");
                }

                $u = new Usuario();
                $id = $u->crearPersonal($_POST);

                $log = new AuditLog();
                $log->registrar($_SESSION['usuario']['id'], $_SESSION['usuario']['rol_nombre'], "Creó usuario personal ID ".$id);

                header("Location: index.php?controller=usuario&action=listar&ok=1");
                exit;
            }

            return ['csrf' => $this->csrf()];
        } catch(Exception $e){
            return ['error' => $e->getMessage(), 'csrf' => $this->csrf()];
        }
    }
}