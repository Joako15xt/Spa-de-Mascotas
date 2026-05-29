<?php

require_once 'modelo/Cita.php';
require_once 'modelo/Cliente.php';
require_once 'modelo/Mascota.php';

class citaController {

    public $view = 'cita/lista';
    public $page_title = 'Agenda de Citas';

    private function verificarSesion(){

        if(!isset($_SESSION['usuario'])){

            header("Location:index.php?controller=auth&action=login");
            exit;
        }
    }

    private function clienteActual(){
        if($_SESSION['usuario']['rol_nombre'] !== 'CLIENTE'){
            return null;
        }

        $cliente = new Cliente();
        return $cliente->obtenerPorCorreo($_SESSION['usuario']['correo']);
    }

    public function listar(){

        $this->verificarSesion();

        $cita = new Cita();
        $cliente = $this->clienteActual();

        if($_SESSION['usuario']['rol_nombre'] === 'CLIENTE' && !$cliente){
            return ['citas' => []];
        }

        return [
            'citas' => $cita->listar($cliente['id'] ?? null)
        ];
    }

    public function crear(){

        $this->verificarSesion();

        $this->view = 'cita/crear';

        $cita = new Cita();
        $cliente = $this->clienteActual();
        $errors = [];
        $formData = [];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $formData = $_POST;

            if($cliente){
                $formData['cliente_id'] = $cliente['id'];
            }

            $motivo = $cita->verificarDisponibilidad(
                $formData['groomer_id'], 
                $formData['fecha'], 
                $formData['hora_inicio'], 
                date('H:i:s', strtotime("+" . $cita->obtenerServicio($formData['servicio_id'])['duracion_minutos'] . " minutes", strtotime($formData['hora_inicio'])))
            );

            if($motivo !== true){
                $errors[] = $motivo;
            }

            if($cliente && !empty($formData['mascota_id'])){
                $mascota = (new Mascota())->obtenerPorId($formData['mascota_id']);
                if(!$mascota || $mascota['cliente_id'] != $cliente['id']){
                    $errors[] = 'No puedes usar una mascota que no es tuya.';
                }
            }

            if(empty($errors)){
                if($cliente){
                    $formData['estado'] = 'PENDIENTE';
                }

                $cita->crear($formData);
                header("Location:index.php?controller=cita&action=listar");
                exit;
            }
        }

        return [
            'mascotas' => $cliente ? $cita->mascotasPorCliente($cliente['id']) : $cita->mascotas(),
            'servicios' => $cita->servicios(),
            'groomers' => $cita->groomers(),
            'errors' => $errors,
            'formData' => $formData,
            'currentCliente' => $cliente
        ];
    }

    public function solicitudes(){

        $this->verificarSesion();
        $this->view = 'cita/solicitudes';

        $cita = new Cita();
        $cliente = $this->clienteActual();

        if($_SESSION['usuario']['rol_nombre'] === 'CLIENTE' && !$cliente){
            return ['citas' => []];
        }

        return [
            'citas' => $cita->listarSolicitudes($cliente['id'] ?? null)
        ];
    }

    public function solicitarAnulacion(){

        $this->verificarSesion();
        $this->view = 'cita/solicitud';

        $cita = new Cita();
        $cliente = $this->clienteActual();
        $id = $_GET['id'] ?? null;

        if(!$id){
            header("Location:index.php?controller=cita&action=listar");
            exit;
        }

        $registro = $cita->obtenerPorId($id);

        if(!$registro){
            header("Location:index.php?controller=cita&action=listar");
            exit;
        }

        if($cliente && $registro['cliente_id'] != $cliente['id']){
            header("Location:index.php?controller=cita&action=listar");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $cita->solicitarAnulacion($id, $_POST['motivo_cancelacion'] ?? '');
            header("Location:index.php?controller=cita&action=solicitudes");
            exit;
        }

        return [
            'cita' => $registro
        ];
    }

    public function cancelar(){

        $this->verificarSesion();

        if($_SESSION['usuario']['rol_nombre'] !== 'ADMIN'){
            header("Location:index.php?controller=cita&action=listar");
            exit;
        }

        $id = $_GET['id'] ?? null;

        if($id){
            $cita = new Cita();
            $cita->cancelar($id);
        }

        header("Location:index.php?controller=cita&action=solicitudes");
        exit;
    }
}