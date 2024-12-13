<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Models\ComentariosModel;
use cesar\ProyectoTest\Models\ContenidoFavoritoModel;
use cesar\ProyectoTest\Models\ContenidoModel;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Controllers\TraduccionController;
use cesar\ProyectoTest\Models\DirectorModel;
use cesar\ProyectoTest\Models\GeneroModel;
use cesar\ProyectoTest\Models\IdiomaModel;
use cesar\ProyectoTest\Models\SeriesModel;

class ContenidoController {
    public function index(){
    }

    private function generarSlug($titulo) {
        $slug = strtolower($titulo);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT', $slug);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
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

            $traduccionController = new TraduccionController();
            
            if ($informacion) {
                $youtubeApiController = new YoutubeApiController();
                $youtubeTrailer = $youtubeApiController->getTrailer($informacion['Title']);
                $traduccion = $traduccionController->traducir($informacion['Plot'], 'ES');

                ViewController::show('views/contenido/info.php', [
                    'informacion' => $informacion,
                    'slug' => $slug, 
                    'youtubeTrailer' => $youtubeTrailer,
                    'traduccion' => $traduccion
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

    public function gestionarContenido(){
        if (Authentication::isAdminLogged()) {
            $contenidoModel = new ContenidoModel();
            $contenidos = $contenidoModel->getAll();
            
            $generoModel = new GeneroModel();
            $generos = $generoModel->getAll();
            
            $idiomaModel = new IdiomaModel();
            $idiomas = $idiomaModel->getAll();
            
            $directorModel = new DirectorModel();
            $directores = $directorModel->getAll();
            
            ViewController::show("views/contenido/gestionarContenido.php", 
            ['contenidos' => $contenidos, 'generos' => $generos, 'idiomas' => $idiomas, 'directores' => $directores]);
        } else {
            ViewController::showError(403);
        }

    }

    public function cambiarEstadoContenido() {
        if (Authentication::isAdminLogged()) {
            $errores = [];
    
            $contenidoModel = new ContenidoModel();
            $idContenido = $_GET['idContenido'];
            var_dump($_GET);
            $contenido = $contenidoModel->getOne($idContenido);

            if (!isset($_GET['idContenido']) || empty($_GET['idContenido'])) {
                $errores = 'ID de contenido no proporcionado.';
            }

            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                exit();
            }
    
            if ($contenido) {
                if ($contenido->estado == 1) {
                    $estado = 0;
                    $contenidoModel->cambiarEstadoUsuario($idContenido, $estado);
                    $_SESSION['mensaje'] = "El contenido esta de baja";
                    header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                    exit();
                } if ($contenido->estado == 0) {
                    $estado = 1;
                    $contenidoModel->cambiarEstadoUsuario($idContenido, $estado);
                    $_SESSION['mensaje'] = "El contenido esta de alta";
                    header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                    exit();
                } else {
                    $errores[] = 'Error al cambiar el estado';
                }
            } else {
                $errores[] = 'El contenido no existe';
            }
        } else {
            ViewController::showError(403);
        }
    }

    public function addContenido(){
        if (Authentication::isAdminLogged()) {
            $contenidoModel = new ContenidoModel();
            $contenidos = $contenidoModel->getAll();
            
            $contenidoModel = new ContenidoModel();
            $tipos = $contenidoModel->getAllTipos();
            
            $idiomaModel = new IdiomaModel();
            $idiomas = $idiomaModel->getAll();
            
            $directorModel = new DirectorModel();
            $directores = $directorModel->getAll();
            
            ViewController::show("views/contenido/addContenido.php", 
            ['contenidos' => $contenidos, 'tipos' => $tipos, 'idiomas' => $idiomas, 'directores' => $directores]);
        } else {
            ViewController::showError(403);
        }
    }

    public function buscarNuevoContenido(){
        if (Authentication::isAdminLogged()) {
            $titulo = $_POST['titulo'];
            
            $contenidoModel = new ContenidoModel();
            $contenidos = $contenidoModel->getAll();

            $contenidoModel = new ContenidoModel();
            $tipos = $contenidoModel->getAllTipos();

            try {
                $omdbController = new OmdbApiController();
                $informacion = $omdbController->obtenerDatosOMDb($titulo);

                $traduccionController = new TraduccionController();

                if (isset($_POST['btnReset'])) {
                    $informacion = '';
                    header("Location: " . Parameters::$BASE_URL . 'Contenido/addContenido');
                    exit();
                }

                if ($informacion) {
                    $traduccion = $traduccionController->traducir($informacion['Plot'], 'ES');

                    $youtubeApiController = new YoutubeApiController();
                    $tipoContenido = $informacion['Type']; // 'movie' o 'series'
    
                    if ($tipoContenido === 'movie') {
                        $youtubeUrl = $youtubeApiController->getContenidoCompleto(trim($informacion['Title']));
                    } elseif ($tipoContenido === 'series') {
                        $youtubeUrl = $youtubeApiController->getCapituloCompleto(trim($informacion['Title']));
                    } else {
                        $youtubeUrl = ''; // Manejar otros tipos si es necesario
                    }
                    
                    ViewController::show('views/contenido/addContenido.php', [
                        'informacion' => $informacion,
                        'contenidos' => $contenidos, 
                        'tipos' => $tipos,
                        'traduccion' => $traduccion,
                        'youtubeUrl' => $youtubeUrl
                    ]);
                } else {
                    $_SESSION['errores'][] = 'No se encontraron resultados para la película.';
                    header("Location: " . Parameters::$BASE_URL . 'Contenido/addContenido');
                    exit();
                }
            } catch (\Exception $e) {
                $_SESSION['errores'][] = 'Error al obtener información: ' . $e->getMessage();
                ViewController::show('views/inicio/inicio.php');
                exit();
            }
        } else {
            ViewController::showError(403);        
        }
    }

    public function addContenidoSave()  {
        if (Authentication::isAdminLogged()) {
            $errores = [];
            $contenidoModel = new ContenidoModel();
            $generoModel = new GeneroModel();
            $directorModel = new DirectorModel();
            $seriesModel = new SeriesModel();

            $titulo = $_POST['titulo'] ?? NULL;
            $año = $_POST['año'] ?? NULL;
            $sinopsis = $_POST['sinopsis'] ?? NULL;
            $generos = isset($_POST['generos']) ? explode(', ', $_POST['generos']) : [];
            $duracion = $_POST['duracion'] ?? NULL;
            $temporadas = $_POST['temporadas'] ?? NULL;
            $capitulos = $_POST['capitulos'] ?? NULL;
            $directorExistente = $_POST['director_existente'] ?? NULL;
            $nuevoDirector = trim($_POST['nuevo_director'] ?? '');
            $puntuacion = $_POST['puntuacion'] ?? NULL;
            $tipo_contenido = $_POST['tipo_contenido'] ?? NULL;

            if (empty($titulo)) {
                $errores['titulo'] = "Inserte un título por favor.";
            }
            if (empty($año) || !is_numeric($año)) {
                $errores['año'] = "Inserte un año válido por favor.";
            }
            if (empty($sinopsis)) {
                $errores['sinopsis'] = "Inserte una sinopsis por favor.";
            }
            if (empty($generos)) {
                $errores['generos'] = "Seleccione al menos un género por favor.";
            }
            if (!empty($temporadas)) {
                if (!is_numeric($temporadas) || $temporadas <= 0) {
                    $errores['temporadas'] = "Inserte un número válido de temporadas.";
                }
            } if (!empty($capitulos)) {
                if (!is_numeric($capitulos) || $capitulos <= 0) {
                    $errores['capitulos'] = "Inserte un número válido de capítulos.";
                }
            } else {
                if (empty($duracion) || !is_numeric($duracion) || $duracion <= 0) {
                    $errores['duracion'] = "Inserte una duración válida por favor.";
                }
            }

            $slugExiste = $this->generarSlug($titulo);
            $contenidoExiste = $contenidoModel->getContenidoUrlAmigable($slugExiste);

            if (!empty($contenidoExiste)) {
                $errores['contenido'] = "El contenido ya exsite.";
            }

            
            if (empty($directorExistente) && empty($nuevoDirector)) {
                $errores['director'] = "Seleccione un director o añada uno nuevo.";
            }
            if (empty($puntuacion) || !is_numeric($puntuacion) || $puntuacion < 0 || $puntuacion > 10) {
                $errores['puntuacion'] = "Inserte una puntuación válida (0-10).";
            }
            if (empty($tipo_contenido)) {
                $errores['tipo_contenido'] = "Seleccione un tipo de contenido por favor.";
            }

            if (!empty($errores)) {
                $_SESSION['errores'] = $errores;
                header('Location: ' . Parameters::$BASE_URL . "Contenido/addContenido");
                exit();
            }

            if (empty($errores)) {
                if (!empty($nuevoDirector)) {
                    $nombreArray = explode(' ', trim($nuevoDirector));

                    $nombre = $nombreArray[0] ?? '';
                    $apellidos = isset($nombreArray[1]) ? implode(' ', array_slice($nombreArray, 1)) : '';
                
                    if (!empty($nombre)) {
                        $directorEncontrado = $directorModel->getDirector($nombre, $apellidos);
                
                        if ($directorEncontrado) {
                            $idDirector = $directorEncontrado->id;
                        } else {
                            $idDirector = $directorModel->nuevoDirector($nombre, $apellidos);
                        }
                    } else {
                        $idDirector = $directorModel->nuevoDirector($nombre, $apellidos);
                    }
                
                } else {
                    $idDirector = $directorExistente;
                }
                
                $slug = $this->generarSlug($titulo);

                $contenidoData = [
                    'titulo' => $titulo,
                    'slug' => $slug,
                    'año' => $año,
                   'sinopsis' => $sinopsis,
                   'duracion' => !empty($duracion) ? $duracion : null,
                   'temporadas' => !empty($temporadas) ? $temporadas : null,
                   'capitulos' => !empty($capitulos) ? $capitulos : null,
                    'id_director' => $idDirector,
                   'puntuacion' => $puntuacion,
                    'tipo_contenido' => $tipo_contenido
                ];
                
                $idContenido = $contenidoModel->insertarContenido($contenidoData['titulo'], $contenidoData['slug'], $contenidoData['año'], $contenidoData['id_director'], $contenidoData['tipo_contenido']);
                
                $ultimoContenido = $contenidoModel->getOne($idContenido);
                // Manejar géneros
                $generoIds = [];
                foreach ($generos as $nombreGenero) {
                    $nombreGenero = strtolower(trim($nombreGenero));

                    $idGenero = $generoModel->obtenerOInsertarGenero($nombreGenero);
                    $generoIds[] = $idGenero;
                }

                $generoModel->asociarContenidoGenero($idGenero, $idContenido);

                var_dump($ultimoContenido->tipo_contenido);
                
                switch ($ultimoContenido->tipo_contenido) {
                    case 'peliculas':
                        $contenidoModel->insertarDetallesPeliculas($idContenido, $contenidoData['duracion'], $contenidoData['sinopsis']);
                        break;
                    case 'cortos':
                        $contenidoModel->insertarDetallesCortos($idContenido, $contenidoData['duracion']);
                        break;
                    case 'documentales':
                        $contenidoModel->insertarDetallesDocumentales($idContenido, $contenidoData['duracion']);
                        break;
                    case 'series':
                        $seriesModel->insertarDetallesSeries($idContenido, $contenidoData['sinopsis'], $contenidoData['temporadas'], $contenidoData['capitulos']);
                        break;
                }

                header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                exit();
            }


        } else {
            ViewController::showError(403);
        }
    }

}