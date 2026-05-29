<?php

require_once 'modelo/Cliente.php';

class clienteController {

    public $view = 'cliente/lista';
    public $page_title = 'Clientes';

    private function verificarSesion(){

        if(!isset($_SESSION['usuario'])){

            header("Location:index.php?controller=auth&action=login");
            exit;
        }
    }

    public function listar(){

        $this->verificarSesion();

        $cliente = new Cliente();

        return [
            'clientes' => $cliente->listar()
        ];
    }

    public function crear(){

        $this->verificarSesion();

        $this->view = 'cliente/crear';

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $cliente = new Cliente();

            $cliente->crear($_POST);

            header("Location:index.php?controller=cliente&action=listar");
            exit;
        }

        return [];
    }

    public function editar(){

        $this->verificarSesion();

        $this->view = 'cliente/editar';

        $cliente = new Cliente();

        $id = $_GET['id'] ?? null;

        if(!$id){

            header("Location:index.php?controller=cliente&action=listar");
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $cliente->actualizar($id, $_POST);

            header("Location:index.php?controller=cliente&action=listar");
            exit;
        }

        return [
            'cliente' => $cliente->obtenerPorId($id)
        ];
    }

    public function eliminar(){

        $this->verificarSesion();

        $id = $_GET['id'] ?? null;

        if($id){

            $cliente = new Cliente();
            $cliente->eliminar($id);
        }

        header("Location:index.php?controller=cliente&action=listar");
        exit;
    }
}