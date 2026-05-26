<?php
require_once 'modelo/AuditLog.php';

class auditoriaController {
    public $view = 'auditoria_lista';
    public $page_title = 'Auditoría';

    private function soloAdmin(){
        if(!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol_nombre'] !== 'ADMIN'){
            throw new Exception("Acceso denegado. Solo el administrador puede ver la auditoría.");
        }
    }

    public function listar(){
        try {
            $this->soloAdmin();

            $log = new AuditLog();
            $registros = $log->listar();

            return ['registros' => $registros];

        } catch(Exception $e){
            $this->view = 'mensaje';
            return [
                'titulo' => 'Acceso denegado',
                'mensaje' => $e->getMessage()
            ];
        }
    }
}