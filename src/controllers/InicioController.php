<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Models\UsuarioModel;
use cesar\ProyectoTest\Helpers\Validations;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Models\ContenidoModel;

class InicioController {
    public function index(){
        $contenidoModel = new ContenidoModel();

        $peliculas = $contenidoModel->get4RandByTipoContenido('pelicula');
     //   $series = $contenidoModel->get4RandByTipoContenido('pelicula');
        $cortos = $contenidoModel->get4RandByTipoContenido('corto');
        $documentales = $contenidoModel->get4RandByTipoContenido('documental');

        ViewController::show("views/inicio/inicio.php", ['peliculas' => $peliculas, 'cortos' => $cortos, 'documentales' => $documentales]);
    }

    
}