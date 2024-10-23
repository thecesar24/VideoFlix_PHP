<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Models\UsuarioModel;
use cesar\ProyectoTest\Helpers\Validations;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Models\ContenidoModel;

class contenidoController {
    public function index(){
    }

    public function getAllPeliculas(){
        $contenidoModel = new ContenidoModel();
        $peliculas = $contenidoModel->getAllPeliculas();

        ViewController::show("views/contenido/peliculas.php", ['peliculas' => $peliculas]);

    }
    
}