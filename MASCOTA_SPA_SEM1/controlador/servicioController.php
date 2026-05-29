<?php

require_once 'modelo/Servicio.php';

class servicioController {

    public $view = 'servicio/lista';
    public $page_title = 'Servicios';

    private function verificarSesion(){

        if(!isset($_SESSION['usuario'])){

            header("Location:index.php?controller=auth&action=login");
            exit;
        }
    }

    public function listar(){

        $this->verificarSesion();

        $servicio = new Servicio();

        return [
            'servicios' => $servicio->listar()
        ];
    }

    public function crear(){

        $this->verificarSesion();

        $this->view = 'servicio/crear';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $servicio = new Servicio();

            $servicio->crear($_POST);

            header("Location:index.php?controller=servicio&action=listar");
            exit;
        }

        return [];
    }

    public function editar(){

        $this->verificarSesion();

        $this->view = 'servicio/editar';

        $servicio = new Servicio();

        $id = $_GET['id'] ?? null;

        if(!$id){

            header("Location:index.php?controller=servicio&action=listar");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $servicio->actualizar($id, $_POST);

            header("Location:index.php?controller=servicio&action=listar");
            exit;
        }

        return [
            'servicio' => $servicio->obtenerPorId($id)
        ];
    }

    public function eliminar(){

        $this->verificarSesion();

        $id = $_GET['id'] ?? null;

        if($id){

            $servicio = new Servicio();
            $servicio->eliminar($id);
        }

        header("Location:index.php?controller=servicio&action=listar");
        exit;
    }
}