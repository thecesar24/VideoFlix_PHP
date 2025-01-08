<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Models\ComentariosModel;
use cesar\ProyectoTest\Models\ContenidoModel;
use cesar\ProyectoTest\Models\CapitulosModel;

class SeriesController {
    public function index(){
    }

    public function verSerie() {
        $slug = $_GET['slug'];
        $numeroTemporada = 1; // número de temporada por defecto
        $numeroCapitulo = 1; // número de capítulo por defecto
        $this->verSeriePorCapitulos($slug, $numeroTemporada, $numeroCapitulo);
    }

    public function verSeriePorCapitulos($slug, $temporada, $capitulo) {
        // Lógica para obtener la serie, temporada y capítulo
        $contenidoModel = new ContenidoModel();
        $serie = $contenidoModel->getContenidoUrlAmigable($slug);
    
        if ($serie) {
            $idContenido = $serie->id;
            $serie = $contenidoModel->getOne($idContenido);
    
            // Obtener el capítulo actual
            $capituloModel = new CapitulosModel();
            $capituloActual = $capituloModel->getCapituloPorNumero($idContenido, $temporada, $capitulo);
    
            if ($capituloActual) {
                // Obtener el capítulo anterior y siguiente
                $capituloAnterior = $capituloModel->getCapituloAnterior($idContenido, $capituloActual['num_capitulo'], $capituloActual['num_temporada']);
                $capituloSiguiente = $capituloModel->getCapituloSiguiente($idContenido, $capituloActual['num_capitulo'], $capituloActual['num_temporada']);
    
                // Obtener todas las temporadas y capítulos de la serie
                $temporadas = $capituloModel->getTemporadasPorContenido($idContenido);
                $capitulosPorTemporada = [];
                foreach ($temporadas as $temp) {
                    $capitulosPorTemporada[$temp] = $capituloModel->getCapitulosPorTemporada($idContenido, $temp);
                }
    
                // Obtener series recomendadas
                $recomendadas = $contenidoModel->getRecomendadasPorGenero($serie->id_genero, $idContenido);
                $comentariosModel = new ComentariosModel;
                $comentarios = $comentariosModel->getAllByIdContenido($idContenido);
    
                // Pasar los datos a la vista
                ViewController::show('views/contenido/ver.php', [
                    'contenido' => $serie,
                    'capituloActual' => $capituloActual,
                    'capituloAnterior' => $capituloAnterior,
                    'capituloSiguiente' => $capituloSiguiente,
                    'temporadas' => $temporadas,
                    'capitulosPorTemporada' => $capitulosPorTemporada,
                    'recomendadas' => $recomendadas,
                    'comentarios' => $comentarios
                ]);
            } else {
                // Manejar el caso en que el capítulo no existe
                $_SESSION['errores'][] = "Capítulo no encontrado.";
                header("Location: " . Parameters::$BASE_URL . "verSerie/" . $slug);
                exit;
            }
        } else {
            // Manejar el caso en que la serie no existe
            $_SESSION['errores'][] = "Serie no encontrada.";
            header("Location: " . Parameters::$BASE_URL);
            exit;
        }
    }

}