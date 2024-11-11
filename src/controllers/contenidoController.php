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

    public function  verContenido() {
        $idCodificado = $_GET['idContenido'];
        $idContenido = base64_decode($idCodificado);

        $contenidoModel = new ContenidoModel();
        $contenido = $contenidoModel->getOne($idContenido);

        $tipoContenido = $contenido->tipo_contenido;

        if ($contenido) {
            $recomendadas = $contenidoModel->get4RandByTipoContenido($tipoContenido);

            ViewController::show('views/contenido/ver.php', ['contenido'=> $contenido, 
                                                                             'recomendadas' => $recomendadas]);
            exit();
        } else {
            ViewController::showError(404);
            exit();
        }
    }
}