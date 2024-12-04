<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Models\ComentariosModel;
use cesar\ProyectoTest\Models\ContenidoFavoritoModel;
use cesar\ProyectoTest\Models\ContenidoModel;
use cesar\ProyectoTest\Config\Parameters;

class ContenidoController {
    public function index(){
    }

    public function Peliculas(){
        $contenidoModel = new ContenidoModel();
        $peliculas = $contenidoModel->getAllByTipoContenido('peliculas');
        
        $contenidoFavoritoModel = new ContenidoFavoritoModel();
        $favoritos = $contenidoFavoritoModel->getAll();

        ViewController::show("views/contenido/peliculas.php", ['peliculas' => $peliculas, 'favoritos' => $favoritos]);

    }
    public function Series(){
        $contenidoModel = new ContenidoModel();
        $series = $contenidoModel->getAllByTipoContenido('series');

        $contenidoFavoritoModel = new ContenidoFavoritoModel();
        $favoritos = $contenidoFavoritoModel->getAll();

        ViewController::show("views/contenido/series.php", ['series' => $series, 'favoritos' => $favoritos]);

    }
    public function Cortos(){
        $contenidoModel = new ContenidoModel();
        $cortos = $contenidoModel->getAllByTipoContenido('corto');
        
        $contenidoFavoritoModel = new ContenidoFavoritoModel();
        $favoritos = $contenidoFavoritoModel->getAll();

        ViewController::show("views/contenido/cortos.php", ['cortos' => $cortos, 'favoritos' => $favoritos]);

    }
    public function Documentales(){
        $contenidoModel = new ContenidoModel();
        $documentales = $contenidoModel->getAllByTipoContenido('documentales');

        $contenidoFavoritoModel = new ContenidoFavoritoModel();
        $favoritos = $contenidoFavoritoModel->getAll();

        ViewController::show("views/contenido/documentales.php", ['documentales' => $documentales, 'favoritos' => $favoritos]);

    }

    public function verContenido() {
        $slug = $_GET['slug'];
        $contenidoModel = new ContenidoModel();
        $contenido = $contenidoModel->getContenidoUrlAmigable($slug);
        
        if ($contenido) {
            $idContenido = $contenidoModel->getContenidoUrlAmigable($slug)->id;
            
            $contenido = $contenidoModel->getOne($idContenido);

            $tipoContenido = $contenido->tipo_contenido;

            $comentariosModel = new ComentariosModel();

            $comentarios = $comentariosModel->getAllByIdContenido($idContenido);
            
            if ($contenido) {
                $recomendadas = $contenidoModel->get4RandByTipoContenido($tipoContenido);

                if (Authentication::isUserLogged()) {
                    $userEntity = $_SESSION['user'];
                    $idUsuario = $userEntity->getId();
                    ViewController::show('views/contenido/ver.php', ['contenido'=> $contenido, 
                    'recomendadas' => $recomendadas, 'comentarios' => $comentarios, 'idUsuario' => $idUsuario]);
                } else {
                    ViewController::show('views/contenido/ver.php', ['contenido'=> $contenido, 
                    'recomendadas' => $recomendadas, 'comentarios' => $comentarios]);
                }
                exit();
            } else {
                ViewController::showError(404);
                exit();
            }
        } else {
            ViewController::showError(404);
            exit();
        }
    }
    
    public function buscarContenido() {
        $busqueda = $_POST['busqueda'];
        $busquedaConComodines = "%".$busqueda."%";
        $contenidoModel = new ContenidoModel;

        $resultados = $contenidoModel->buscarContenido($busquedaConComodines);

        ViewController::show('views/contenido/buscarContenido.php', ['resultados' => $resultados]);
    }


    public function verInfo(){

        $slug = $_GET['slug'];

        $contenidoModel = new ContenidoModel();
        $resultado = $contenidoModel->getContenidoUrlAmigable($slug);

        if ($resultado->slug != $slug) {
            $_SESSION['errores'][] = 'No se encontraron resultados para la película.';
            header("Location: " . Parameters::$BASE_URL . 'Inicio/index');
            exit();
        }
        
        try {
            $omdbController = new OmdbApiController();
            $informacion = $omdbController->obtenerDatosOMDb($slug);

            if ($informacion) {
                $youtubeApiController = new YoutubeApiController();
                $youtubeTrailer = $youtubeApiController->getTrailer($informacion['Title']);

                ViewController::show('views/contenido/info.php', [
                    'informacion' => $informacion,
                    'slug' => $slug, 
                    'youtubeTrailer' => $youtubeTrailer
                ]);
            } else {
                $_SESSION['errores'][] = 'No se encontraron resultados para la película.';
                header("Location: " . Parameters::$BASE_URL . 'Inicio/index');
                exit();
            }
        } catch (\Exception $e) {
            $_SESSION['errores'][] = 'Error al obtener información: ' . $e->getMessage();
            ViewController::show('views/inicio/inicio.php');
            exit();
        }
    }

}