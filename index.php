<?php
require_once 'vendor/autoload.php';

session_start();

use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Controllers\ViewController;

// CONTROLADOR FRONTAL:
$nameController = "cesar\ProyectoTest\Controllers\\";
$nameController = $nameController . (($_GET['controller']) ?? Parameters::$CONTROLLER_DEFAULT) . "Controller";
$action = $_GET['action'] ?? Parameters::$ACTION_DEFAULT;

// Verifica si la clase existe
if (class_exists($nameController)) {
    $controller = new $nameController();

    if (method_exists($controller, $action)) {
        // Extrae todos los parámetros GET y pásalos al método como argumentos
        $params = array_values(array_filter($_GET, fn($key) => !in_array($key, ['controller', 'action']), ARRAY_FILTER_USE_KEY));
        
        // Llama al método con los parámetros extraídos
        call_user_func_array([$controller, $action], $params);
    } else {
        (new ViewController())->showError(404);
    }
} else {
    (new ViewController())->showError(404);
}