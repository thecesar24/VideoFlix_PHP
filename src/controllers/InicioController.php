<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Models\InicioModel;

class InicioController {
    public function index(){
        $inicioModel = new inicioModel();

        $peliculas = $inicioModel->get4RandByTipoContenido('peliculas');
        $series = $inicioModel->get4RandByTipoContenido('series');
        $cortos = $inicioModel->get4RandByTipoContenido('cortos');
        $documentales = $inicioModel->get4RandByTipoContenido('documentales');

        ViewController::show("views/inicio/inicio.php", ['peliculas' => $peliculas, 'cortos' => $cortos, 'documentales' => $documentales, 'series' => $series]);
    }

    
}