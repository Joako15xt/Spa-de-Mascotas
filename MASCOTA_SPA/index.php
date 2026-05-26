<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/config.php';
require_once 'modelo/db.php';

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

if(isset($_SESSION['usuario'])){
    if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT){
        session_destroy();
        header("Location: index.php?controller=auth&action=login&timeout=1");
        exit;
    }
    $_SESSION['last_activity'] = time();
}

spl_autoload_register(function($class){
    foreach(['modelo/', 'controlador/'] as $p){
        $file = $p.$class.'.php';
        if(file_exists($file)){
            require_once $file;
            return;
        }
    }
});

$db = new Db();
$db->seedDefaults();

$controller = isset($_GET['controller']) ? preg_replace('/[^a-zA-Z0-9_]/','', $_GET['controller']) : DEFAULT_CONTROLLER;
$action = isset($_GET['action']) ? preg_replace('/[^a-zA-Z0-9_]/','', $_GET['action']) : DEFAULT_ACTION;

$controllerFile = 'controlador/'.$controller.'Controller.php';
$controllerClass = $controller.'Controller';

if(!file_exists($controllerFile)){
    $controllerFile = 'controlador/homeController.php';
    $controllerClass = 'homeController';
}

require_once $controllerFile;
$ctrl = new $controllerClass();

$dataToView = ['data' => []];

if(method_exists($ctrl, $action)){
    $dataToView['data'] = $ctrl->{$action}();
} else {
    $dataToView['data'] = $ctrl->{DEFAULT_ACTION}();
}

require_once 'vista/template/header.php';

if(property_exists($ctrl, 'view') && !empty($ctrl->view)){
    $viewFile = 'vista/'.$ctrl->view.'.php';
    if(file_exists($viewFile)){
        if(is_array($dataToView['data'])){
            extract($dataToView['data'], EXTR_SKIP);
        }
        require_once $viewFile;
    } else {
        echo "<div class='alert alert-danger'>Vista no encontrada: ".htmlspecialchars($viewFile)."</div>";
    }
}

require_once 'vista/template/footer.php';