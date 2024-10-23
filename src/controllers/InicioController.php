<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Models\UsuarioModel;
use cesar\ProyectoTest\Helpers\Validations;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;

class InicioController {
    public function index(){
        if (Authentication::isUserLogged()) {
            // Si el usuario ya está logueado, redirigir a la página de datos
            header("Location: " . Parameters::$BASE_URL . "Usuario/datos");
            exit();
        }

        ViewController::show("views/inicio/inicio.php");
    }

    
}