<?php

require_once 'modelo/Agenda.php';

class agendaController {

    public $view = 'agenda/index';
    public $page_title = 'Agenda Grooming';

    private function verificarSesion(){

        if(!isset($_SESSION['usuario'])){

            header("Location:index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index(){

        $this->verificarSesion();

        $agenda = new Agenda();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        return [

            'agenda' => $agenda->obtenerAgenda($fecha),
            'fecha' => $fecha
        ];
    }
}