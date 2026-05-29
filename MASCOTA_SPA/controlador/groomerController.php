<?php

require_once 'modelo/Groomer.php';

class groomerController {

    public $view = 'groomer/index';
    public $page_title = 'Groomers';

    private function verificarSesion(){

        if(!isset($_SESSION['usuario'])){

            header("Location:index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index(){

        $this->verificarSesion();

        $groomer = new Groomer();

        return [

            'groomers' => $groomer->listar()
        ];
    }

    public function crear(){

        $this->verificarSesion();

        $this->view = 'groomer/crear';

        $groomer = new Groomer();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $groomer->crear($_POST);

            header("Location:index.php?controller=groomer&action=index");
            exit;
        }

        return [

            'usuarios' => $groomer->usuariosDisponibles()
        ];
    }

    public function editar(){

        $this->verificarSesion();

        $this->view = 'groomer/editar';

        $groomer = new Groomer();

        $id = $_GET['id'];

        $datos = $groomer->obtenerPorId($id);

        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $groomer->actualizar($_POST);

            header("Location:index.php?controller=groomer&action=index");
            exit;
        }

        return [

            'groomer' => $datos,

            'usuarios' => $groomer->usuariosDisponibles(
                $datos['usuario_id']
            )
        ];
    }
}