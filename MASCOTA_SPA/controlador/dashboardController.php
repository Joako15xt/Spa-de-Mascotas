<?php
require_once __DIR__ . '/../modelo/Dashboard.php';

class dashboardController {

    public $view = 'dashboard/index';
    public $page_title = 'Dashboard';

    private function verificarSesion(){
        if(!isset($_SESSION['usuario'])){
            header("Location: index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index(){

        $this->verificarSesion();

        $dashboard = new Dashboard();

        return [
            'total_clientes' => $dashboard->totalClientes(),
            'total_mascotas' => $dashboard->totalMascotas(),
            'total_citas' => $dashboard->totalCitas(),
            'total_groomers' => $dashboard->totalGroomers(),
            'citas_hoy' => $dashboard->citasHoy()
        ];
    }
}