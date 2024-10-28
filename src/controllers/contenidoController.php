<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Models\ContenidoModel;

class contenidoController {
    public function index(){
    }

    public function Peliculas(){
        $contenidoModel = new ContenidoModel();
        $peliculas = $contenidoModel->getAllByTipoContenido('peliculas');

        ViewController::show("views/contenido/peliculas.php", ['peliculas' => $peliculas]);

    }
    public function Series(){
        $contenidoModel = new ContenidoModel();
        $series = $contenidoModel->getAllByTipoContenido('series');

        ViewController::show("views/contenido/series.php", ['series' => $series]);

    }
    public function Cortos(){
        $contenidoModel = new ContenidoModel();
        $cortos = $contenidoModel->getAllByTipoContenido('corto');

        ViewController::show("views/contenido/cortos.php", ['cortos' => $cortos]);

    }
    public function Documentales(){
        $contenidoModel = new ContenidoModel();
        $documentales = $contenidoModel->getAllByTipoContenido('documentales');

        ViewController::show("views/contenido/documentales.php", ['documentales' => $documentales]);

    }
    
}