<?php
require_once 'vendor/autoload.php';

session_start();

use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Controllers\ViewController;


// CONTROLADOR FRONTAL:
    $nameController = "cesar\ProyectoTest\Controllers\\";
    $nameController = $nameController . (($_GET['controller'])??Parameters::$CONTROLLER_DEFAULT) . "Controller";
    $action = $_GET['action']??Parameters::$ACTION_DEFAULT;
    
    // Método class_exists
    if (class_exists($nameController)){
        $controller = new $nameController();
        if (method_exists($controller, $action)){
            $controller->$action();
        }else (new ViewController())->showError(404);   
    }else (new ViewController())->showError(404);
    

    