<?php

require_once 'modelo/Grooming.php';

class groomingController {

    public $view = 'grooming/index';
    public $page_title = 'Grooming';

    private function verificarSesion(){

        if(!isset($_SESSION['usuario'])){

            header("Location:index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index(){

        $this->verificarSesion();

        $grooming = new Grooming();

        return [
            'fichas' => $grooming->listar()
        ];
    }

    public function ficha(){

        $this->verificarSesion();

        $this->view = 'grooming/ficha';

        $grooming = new Grooming();
        $error = null;

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try {
                $grooming->crear($_POST);
                header("Location:index.php?controller=grooming&action=index");
                exit;
            } catch(Exception $e) {
                $error = $e->getMessage();
            }
        }

        return [
            'citas' => $grooming->citasDisponibles(),
            'error' => $error
        ];
    }
}