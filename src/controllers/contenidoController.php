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

    public function Peliculas(){
        $contenidoModel = new ContenidoModel();
        $peliculas = $contenidoModel->getAllByTipoContenido('pelicula');

        ViewController::show("views/contenido/peliculas.php", ['peliculas' => $peliculas]);

    }
    public function Series(){
        $contenidoModel = new ContenidoModel();
        $series = $contenidoModel->getAll();

        ViewController::show("views/contenido/series.php", ['series' => $series]);

    }
    public function Cortos(){
        $contenidoModel = new ContenidoModel();
        $cortos = $contenidoModel->getAllByTipoContenido('corto');

        ViewController::show("views/contenido/cortos.php", ['cortos' => $cortos]);

    }
    public function Documentales(){
        $contenidoModel = new ContenidoModel();
        $documentales = $contenidoModel->getAllByTipoContenido('documental');

        ViewController::show("views/contenido/documentales.php", ['documentales' => $documentales]);

    }
    
}