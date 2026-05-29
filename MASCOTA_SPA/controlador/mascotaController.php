<?php

require_once 'modelo/Mascota.php';
require_once 'modelo/Cliente.php';

class mascotaController {

    public $view = 'mascota/lista';
    public $page_title = 'Mascotas';

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

        $mascota = new Mascota();
        $cliente = $this->clienteActual();

        return [
            'mascotas' => $cliente ? $mascota->listarPorCliente($cliente['id']) : $mascota->listar()
        ];
    }

    public function crear(){

        $this->verificarSesion();

        $this->view = 'mascota/crear';

        $mascota = new Mascota();
        $cliente = $this->clienteActual();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($cliente){
                $_POST['cliente_id'] = $cliente['id'];
            }

            $mascota->crear($_POST);

            header("Location:index.php?controller=mascota&action=listar");
            exit;
        }

        return [
            'clientes' => $cliente ? [] : $mascota->clientes(),
            'currentCliente' => $cliente
        ];
    }

    public function editar(){

        $this->verificarSesion();

        $this->view = 'mascota/editar';

        $mascota = new Mascota();
        $cliente = $this->clienteActual();

        $id = $_GET['id'] ?? null;

        if(!$id){
            header("Location:index.php?controller=mascota&action=listar");
            exit;
        }

        $registro = $mascota->obtenerPorId($id);

        if($cliente && $registro && $registro['cliente_id'] != $cliente['id']){
            header("Location:index.php?controller=mascota&action=listar");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if($cliente){
                $_POST['cliente_id'] = $cliente['id'];
            }

            $mascota->actualizar($id, $_POST);

            header("Location:index.php?controller=mascota&action=listar");
            exit;
        }

        return [
            'mascota' => $registro,
            'clientes' => $cliente ? [] : $mascota->clientes(),
            'currentCliente' => $cliente
        ];
    }

    public function eliminar(){

        $this->verificarSesion();

        $id = $_GET['id'] ?? null;
        $mascota = new Mascota();
        $cliente = $this->clienteActual();

        if($id){
            $registro = $mascota->obtenerPorId($id);
            if(!$cliente || ($registro && $registro['cliente_id'] == $cliente['id'])){
                $mascota->eliminar($id);
            }
        }

        header("Location:index.php?controller=mascota&action=listar");
        exit;
    }
}