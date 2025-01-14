<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Helpers\Validations;
use cesar\ProyectoTest\Models\ComentariosModel;
use cesar\ProyectoTest\Models\ContenidoFavoritoModel;
use cesar\ProyectoTest\Models\ContenidoModel;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Controllers\TraduccionController;
use cesar\ProyectoTest\Models\DirectorModel;
use cesar\ProyectoTest\Models\GeneroModel;
use cesar\ProyectoTest\Models\IdiomaModel;
use cesar\ProyectoTest\Models\SeriesModel;
use cesar\ProyectoTest\Models\PeliculasModel;
use cesar\ProyectoTest\Models\CortosModel;
use cesar\ProyectoTest\Models\DocumentalesModel;
use cesar\ProyectoTest\Models\CapitulosModel;

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
        $cortos = $contenidoModel->getAllByTipoContenido('cortos');
        
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
                $idGenero = $contenido->id_genero;
                
                $recomendadas = $contenidoModel->getRecomendadasPorGenero($idGenero, $idContenido);

                if ($tipoContenido == 'series') {
                    $seriesModel = new SeriesModel();
                    $capitulos = $seriesModel->getAllCapitulosPorSerie($idContenido);

                }

                if (Authentication::isUserLogged()) {
                    $userEntity = $_SESSION['user'];
                    $idUsuario = $userEntity->getId();

                    if ($tipoContenido == 'series') {
                        ViewController::show('views/contenido/ver.php', ['contenido'=> $contenido, 
                        'recomendadas' => $recomendadas, 'comentarios' => $comentarios, 'idUsuario' => $idUsuario, 'capitulos' => $capitulos]);   
                    }else{
                        ViewController::show('views/contenido/ver.php', ['contenido'=> $contenido, 
                        'recomendadas' => $recomendadas, 'comentarios' => $comentarios, 'idUsuario' => $idUsuario]);
                    }
                } else {
                    if ($tipoContenido == 'series') {
                        ViewController::show('views/contenido/ver.php', ['contenido'=> $contenido, 
                        'recomendadas' => $recomendadas, 'comentarios' => $comentarios, 'capitulos' => $capitulos]);   
                    }else{
                        ViewController::show('views/contenido/ver.php', ['contenido'=> $contenido, 
                        'recomendadas' => $recomendadas, 'comentarios' => $comentarios]);
                    }
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

            $peliculasModel = new PeliculasModel();
            $seriesModel = new SeriesModel();
            $generoModel = new GeneroModel();
            $directorModel = new DirectorModel();
            $idiomaModel = new IdiomaModel();
            
            if ($informacion) {
                $youtubeApiController = new YoutubeApiController();
                $youtubeTrailer = $youtubeApiController->getTrailer($informacion['Title']);
                
                $contenidoInfo = $resultado;
                $genero = $generoModel->getOne($contenidoInfo->id_genero);
                $director = $directorModel->getOne($contenidoInfo->id_director);
                $idioma = $idiomaModel->getOne($contenidoInfo->id_idioma);

                if ($contenidoInfo->tipo_contenido == "peliculas") {
                    $tipo = $peliculasModel->getPelicula($contenidoInfo->id);
                } elseif($contenidoInfo->tipo_contenido == "series") {
                    $tipo = $seriesModel->getSerie($contenidoInfo->id);
                    $capituloModel = new CapitulosModel();
                    $temporadas = $capituloModel->getTemporadasPorContenido($resultado->id);
                    $capitulosPorTemporada = [];
                    foreach ($temporadas as $temporada) {
                        $capitulosPorTemporada[$temporada] = $capituloModel->getCapitulosPorTemporada($resultado->id, $temporada);
                    }

                } else {
                    $tipo = '-';
                }

                if($contenidoInfo->tipo_contenido == 'series'){
                    ViewController::show('views/contenido/info.php', [
                        'informacion' => $informacion,
                        'slug' => $slug, 
                        'youtubeTrailer' => $youtubeTrailer,
                        'tipo' => $tipo,
                        'contenidoInfo' => $contenidoInfo,
                        'genero' => $genero,
                        'director' => $director,
                        'idioma' => $idioma,
                        'temporadas' => $temporadas,
                        'capitulosPorTemporada' => $capitulosPorTemporada
                    ]);
                }else {
                    ViewController::show('views/contenido/info.php', [
                        'informacion' => $informacion,
                        'slug' => $slug, 
                        'youtubeTrailer' => $youtubeTrailer,
                        'tipo' => $tipo,
                        'contenidoInfo' => $contenidoInfo,
                        'genero' => $genero,
                        'director' => $director,
                        'idioma' => $idioma
                    ]);
                }
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

    public function cambiarEstadoAPendiente() {
        if (Authentication::isAdminLogged()) {
            $errores = [];
    
            $contenidoModel = new ContenidoModel();
            $idContenido = $_GET['idContenido'];
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
                    $estado = 2;
                    $contenidoModel->cambiarEstadoUsuario($idContenido, $estado);
                    $_SESSION['mensaje'] = "El contenido esta pendiente de confirmación";
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

            $generoModel = new GeneroModel();
            $generos = $generoModel->getAll();
            
            ViewController::show("views/contenido/addContenido.php", 
            ['contenidos' => $contenidos, 'tipos' => $tipos, 'idiomas' => $idiomas, 'directores' => $directores, 'generos' => $generos]);
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
                    $generoTraducido = $traduccionController->traducir($informacion['Genre'], 'ES');

                    $youtubeApiController = new YoutubeApiController();
                    $tipoContenido = $informacion['Type'];
    
                    if ($tipoContenido === 'movie') {
                        $youtubeUrl = $youtubeApiController->getContenidoCompleto(trim($informacion['Title']));
                    } elseif ($tipoContenido === 'series') {
                        $youtubeUrl = $youtubeApiController->getCapituloCompleto(trim($informacion['Title']));
                    } else {
                        $youtubeUrl = '';
                    }

                    $_SESSION['Omdb'] = true;
                    
                    ViewController::show('views/contenido/addContenido.php', [
                        'informacion' => $informacion,
                        'contenidos' => $contenidos, 
                        'tipos' => $tipos,
                        'traduccion' => $traduccion,
                        'youtubeUrl' => $youtubeUrl,
                        'generoTraducido' => $generoTraducido
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
            $year = $_POST['year'] ?? NULL;
            $sinopsis = $_POST['sinopsis'] ?? NULL;
            $generoExistente = isset($_POST['genero_existente']) ?? NULL;
            $nuevoGenero = trim($_POST['nuevo_genero'] ?? '');
            $duracion = $_POST['duracion'] ?? NULL;
            $temporadas = $_POST['temporadas'] ?? NULL;
            $capitulos = $_POST['capitulos'] ?? NULL;
            $directorExistente = $_POST['director_existente'] ?? NULL;
            $nuevoDirector = trim($_POST['nuevo_director'] ?? '');
            $puntuacion = $_POST['puntuacion'] ?? NULL;
            $tipo_contenido = $_POST['tipo_contenido'] ?? NULL;
            $video = $_POST['url'] ?? NULL;
            $posterUrl = $_POST['poster_url'] ?? NULL;
            $posterFile = $_FILES['poster_file'] ?? NULL;

            if (empty($titulo)) {
                $errores['titulo'] = "Inserte un título por favor.";
            }
            if (empty($year) || !is_numeric($year)) {
                $errores['año'] = "Inserte un año válido por favor.";
            }
            if ($tipo_contenido != 'cortos' && $tipo_contenido != 'documentales') {
                if (empty($sinopsis)) {
                    $errores['sinopsis'] = "Inserte una sinopsis por favor.";
                }

                if (empty($puntuacion) || !is_numeric($puntuacion) || $puntuacion < 0 || $puntuacion > 10) {
                    $errores['puntuacion'] = "Inserte una puntuación válida (0-10).";
                }
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

            if ($_SESSION['Omdb']) {
                if (empty($nuevoGenero)) {
                    $errores['generos'] = "Seleccione un genero.";
                }
                unset($_SESSION['Omdb']);
            }else{
                if (empty($generoExistente && empty($nuevoGenero))) {
                    $errores['generos'] = "Seleccione un genero o añada uno nuevo.";
                }
            }


            $slugExiste = $this->generarSlug($titulo);
            $contenidoExiste = $contenidoModel->getContenidoUrlAmigable($slugExiste);

            if (!empty($contenidoExiste)) {
                $errores['contenido'] = "El contenido ya existe.";
            }

            if (empty($directorExistente) && empty($nuevoDirector)) {
                $errores['director'] = "Seleccione un director o añada uno nuevo.";
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

                $defaultPoster = 'Default_Portada.png';
                $rutaPoster = $defaultPoster;

                if ($posterFile['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'assets/img/Portadas/';
                    $imageName = uniqid('poster_') . '.jpg';
                    $uploadFile = $uploadDir . $imageName;
                
                    if (move_uploaded_file($posterFile['tmp_name'], $uploadFile)) {
                        $rutaPoster = basename($uploadFile);
                    } else {
                        $_SESSION['errores'][] = "Error al subir el poster.";
                        header("Location: " . Parameters::$BASE_URL . "Contenido/addContenido");
                        exit();
                    }
                }
                elseif (!empty($posterUrl)) {
                    $uploadDir = 'assets/img/Portadas/';
                    $imageName = uniqid('poster_') . '.jpg';
                    $uploadFile = $uploadDir . $imageName;
                
                    $imageData = file_get_contents($posterUrl);
                    if ($imageData !== false) {
                        file_put_contents($uploadFile, $imageData);
                        $rutaPoster = basename($uploadFile);
                    } else {
                        $_SESSION['errores'][] = "Error al descargar el poster desde OMDB.";
                        header("Location: " . Parameters::$BASE_URL . "Contenido/addContenido");
                        exit();
                    }
                }

                $slug = $this->generarSlug($titulo);

                $contenidoData = [
                    'titulo' => $titulo,
                    'slug' => $slug,
                    'year' => $year,
                   'sinopsis' => $sinopsis,
                   'duracion' => !empty($duracion) ? $duracion : null,
                   'temporadas' => !empty($temporadas) ? $temporadas : null,
                   'capitulos' => !empty($capitulos) ? $capitulos : null,
                    'id_director' => $idDirector,
                   'puntuacion' => $puntuacion,
                    'tipo_contenido' => $tipo_contenido,
                    'video' => $video,
                    'poster' => $rutaPoster
                ];

                
                $idContenido = $contenidoModel->insertarContenido($contenidoData['titulo'], $contenidoData['slug'], $contenidoData['year'], $contenidoData['id_director'], $contenidoData['tipo_contenido'], $contenidoData['video'], $contenidoData['poster']);
                
                if ($idContenido) {
                    $ultimoContenido = $contenidoModel->getOne($idContenido);
                    
                    $generoExistenteId = $_POST['genero_existente'];
                
                    $nuevoGeneroNombre = trim($_POST['nuevo_genero']);
                
                    if (!empty($generoExistenteId)) {
                        $idGenero = $generoExistenteId;
                    } elseif (!empty($nuevoGeneroNombre)) {
                        $ultimoContenido = $contenidoModel->getOne($idContenido);

                        // Separar los géneros por comas y limpiar espacios
                        $generos = array_map('trim', explode(',', $nuevoGeneroNombre));

                        // Array para almacenar los IDs de los géneros
                        $generoIds = [];

                        // Insertar o obtener los IDs de los géneros
                        foreach ($generos as $nombreGenero) {
                            $nombreGenero = strtolower(trim($nombreGenero)); // Limpiar y normalizar el nombre
                            if (!empty($nombreGenero)) {
                                $idGenero = $generoModel->obtenerOInsertarGenero($nombreGenero); // Insertar o obtener el género
                                $generoIds[] = $idGenero; // Guardar el ID del género
                            }
                        }
                    
                        // Asociar solo el primer género al contenido
                        if (!empty($generoIds)) {
                            $idPrimerGenero = $generoIds[0]; // Tomar el primer género
                            $generoModel->asociarContenidoGenero($idPrimerGenero, $idContenido); // Asociar el primer género
                        }

                    } else {
                        $_SESSION['errores'][] = "Debes seleccionar un género existente o ingresar uno nuevo.";
                        header('Location: ' . Parameters::$BASE_URL . "Contenido/addContenido");
                        exit();
                    }
                
                    $generoModel->asociarContenidoGenero($idGenero, $idContenido);

                    switch ($ultimoContenido->tipo_contenido) {
                        case 'peliculas':
                            $contenidoModel->insertarDetallesPeliculas($idContenido, $contenidoData['duracion'], $contenidoData['sinopsis'], $contenidoData['puntuacion']);
                            break;
                        case 'cortos':
                            $contenidoModel->insertarDetallesCortos($idContenido, $contenidoData['duracion']);
                            break;
                        case 'documentales':
                            $contenidoModel->insertarDetallesDocumentales($idContenido, $contenidoData['duracion']);
                            break;
                        case 'series':
                            $seriesModel->insertarDetallesSeries($idContenido, $contenidoData['sinopsis'], $contenidoData['temporadas'], $contenidoData['capitulos'], $contenidoData['puntuacion']);
                            
                            //Añadir cap 1 temp 1
                            $num_capitulo = 1;
                            $num_temporada = 1;
                            $seriesModel->insertarCapitulo($num_capitulo, $num_temporada, $contenidoData['video'], $idContenido);
                            
                            break;
                    }

                    $_SESSION['mensaje'] = 'Contenido tipo ' . $ultimoContenido->tipo_contenido . ' agregado correctamente.';
                    header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                    exit();
                } else {
                    $_SESSION['errores'][] = 'No hay id, Error al agregar el contenido.';
                    header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                    exit();
                }
            } else {
                $_SESSION['errores'][] = 'Error al agregar el contenido.';
                header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                exit();
            }
        } else {
            ViewController::showError(403);
        }
    }

    public function editarContenido(){
        if (Authentication::isAdminLogged()) {
            if (isset($_GET['idContenido']) && !empty($_GET['idContenido'])) {
                $idContenido = $_GET['idContenido'];

                $contenidoModel = new ContenidoModel();
                $contenido = $contenidoModel->getOne($idContenido);
                
                $generoModel = new GeneroModel;
                $generos = $generoModel->getAll();
                
                switch ($contenido->tipo_contenido) {
                    case 'peliculas':
                        $peliculasModel = new PeliculasModel;
                        $tipo_contenido = $peliculasModel->getPelicula($idContenido);
                        break;
                    case 'series':
                        $seriesModel = new SeriesModel;
                        $tipo_contenido = $seriesModel->getSerie($idContenido);
                        break;
                    case 'cortos':
                        $cortosModel = new CortosModel;
                        $tipo_contenido = $cortosModel->getCorto($idContenido);
                        break;
                    case 'documentales':
                        $documentalesModel = new DocumentalesModel;
                        $tipo_contenido = $documentalesModel->getDocumental($idContenido);
                        break;
                    default:
                        break;
                }

                $contenidoModel = new ContenidoModel();
                $tipos = $contenidoModel->getAllTipos();

                $idiomaModel = new IdiomaModel();
                $idiomas = $idiomaModel->getAll();

                $directorModel = new DirectorModel();
                $directores = $directorModel->getAll();

                ViewController::show("views/contenido/editarContenido.php", 
                ['contenido' => $contenido, 
                       'tipos' => $tipos, 
                       'idiomas' => $idiomas, 
                       'directores' => $directores,
                       'tipo_contenido' => $tipo_contenido,
                       'generos' => $generos]);
            } else {
                $_SESSION['errores'][] = 'ID de contenido no proporcionado.';
                header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                exit();
            }
        } else {
            ViewController::showError(403);
        }
    }

    public function editarContenidoSave() {
        $idContenido = $_GET['idContenido'] ?? null;
    
        if (!$idContenido) {
            $_SESSION['errores'] = "El contenido no existe.";
            header("Location: " . Parameters::$BASE_URL . "Contenido/lista");
            exit();
        }

        $contenidoModel = new ContenidoModel();
        $contenido = $contenidoModel->getOne($idContenido);
        $titulo = $_POST['titulo'] ?? null;
        $year = $_POST['año'] ?? null;
        $sinopsis = $_POST['sinopsis'] ?? null;
        $genero = $_POST['genero'] ?? null;
        $director = $_POST['director'] ?? null;
        $puntuacion = $_POST['puntuacion'] ?? null;
        $url = $_POST['url'] ?? null;
        
        if ($contenido->tipo_contenido == 'series') {
            $temporadas = $_POST['temporadas'] ?? null;
            $capitulos = $_POST['capitulos'] ?? null;
        } else {
            $duracion = $_POST['duracion'] ?? null;
        }
    
        $erroresSpan = [];
      
        if (!Validations::validateTitulo($titulo)) {
            $erroresSpan['titulo'] = "El título es obligatorio.";
        }
        if (!$year || !is_numeric($year)) {
            $erroresSpan['year'] = "El año es obligatorio y debe ser un número.";
        }
        if (!Validations::validateSinopsis($sinopsis)) {
            $erroresSpan['sinopsis'] = "La sinopsis es obligatoria y debe contener entre 1 y 400 caracteres. Solo se permiten letras, números y signos de puntuación básicos.";
        }
        if ($genero === null) {
            $erroresSpan['genero'] = "El género es obligatorio.";
        }
        if ($contenido->tipo_contenido == 'series') {
            if (!$temporadas || !is_numeric($temporadas)) {
                $erroresSpan['temporadas'] = "El nº de temporadas es obligatorio.";
            }
            if (!$capitulos || !is_numeric($capitulos)) {
                $erroresSpan['capitulos'] = "El nº de capitulos es obligatorio.";
            }
        }else {
            if (!$duracion || !is_numeric($duracion)) {
                $erroresSpan['duracion'] = "La duración es obligatoria.";
            }
        }
        if ($director === null) {
            $erroresSpan['director'] = "El director es obligatorio.";
        }
        if (!$puntuacion || !is_numeric($puntuacion)) {
            $erroresSpan['puntuacion'] = "La puntuación debe ser un número.";
        }
        if (!Validations::validateYouTubeEmbedUrl($url)) {
            $erroresSpan['url'] = "La URL no tiene el formato correcto de YouTube Embed.";
        }
        if (!Validations::validateFile($_FILES['portada'])) {
            $erroresSpan['portada'] = "El archivo debe ser .jpg, .png, .jpeg y no superar los 2MB.";
            if ($_FILES['portada']['name'] != 'Default_Portada.png') {
                unset($erroresSpan['portada']);
            }
        }

        if (!empty($erroresSpan)) {
            $_SESSION['errores-span'] = $erroresSpan;
            header("Location: " . Parameters::$BASE_URL . "Contenido/editarContenido?idContenido=" . $idContenido);
            exit();
        }

        $slug = $this->generarSlug($titulo);

    
        if ($contenido->tipo_contenido == 'series') {
            $datosActualizados = [
                'titulo' => $titulo,
                'year' => $year,
                'slug' => $slug,
                'sinopsis' => $sinopsis,
                'id_genero' => $genero,
                'temporadas' => $temporadas,
                'capitulos' => $capitulos,
                'id_director' => $director,
                'puntuacion' => $puntuacion,
                'video' => $url
            ];
        }else {
            $datosActualizados = [
                'titulo' => $titulo,
                'year' => $year,
                'slug' => $slug,
                'sinopsis' => $sinopsis,
                'id_genero' => $genero,
                'duracion' => $duracion,
                'id_director' => $director,
                'puntuacion' => $puntuacion,
                'video' => $url
            ];
        }

        $nombreArchivo = $contenido->portada;
       
            if (isset($_FILES['portada']) && $_FILES['portada']['error'] === UPLOAD_ERR_OK) {
                $nombreArchivo = $_FILES['portada']['name'] ?? $contenido->portada;
                $tmpName = $_FILES['portada']['tmp_name'];
                $directorioDestino = 'assets/img/Portadas/';
                $rutaDestino = $directorioDestino . $nombreArchivo;
            
                if (move_uploaded_file($tmpName, $rutaDestino)) {
                    $_SESSION['mensaje'] = "Archivo subido con éxito: $nombreArchivo.";
                } else {
                    $_SESSION['errores'][] = "Error al mover el archivo.";
                    header("Location: " . Parameters::$BASE_URL . "Contenido/editarContenido?idContenido=" . $idContenido);
                    exit();
                }
            } else {
                //$_SESSION['errores'][] = "Error en la carga del archivo.";
            }

        if (empty($erroresSpan)) {
            $contenidoModel = new ContenidoModel();

            $idContenido = (int)$idContenido;
            $year = (int)$datosActualizados['year'];
            $id_genero = (int)$datosActualizados['id_genero'];
            $id_director = (int)$datosActualizados['id_director'];

            $resultado = $contenidoModel->updateContenido(
                $idContenido,
                $datosActualizados['titulo'],
                $datosActualizados['slug'],
                $year,
                $id_genero,
                $nombreArchivo,
                $datosActualizados['video'],
                $id_director
            );

            switch ($contenido->tipo_contenido) {
                case 'peliculas':
                    $peliculasModel = new PeliculasModel();
                    $resultado2 = $peliculasModel->updateDetallesPeliculas($idContenido, $duracion, $sinopsis, $puntuacion);
                    break;
                case 'cortos':
                    $cortosModel = new CortosModel();
                    $resultado2 = $cortosModel->updateDetallesCortos($idContenido, $duracion);
                    break;
                case 'documentales':
                    $documentalesModel = new DocumentalesModel;
                    $resultado2 = $documentalesModel->updateDetallesDocumentales($idContenido, $duracion);
                    break;
                case 'series':
                    $seriesModel = new SeriesModel();
                    $resultado2 = $seriesModel->updateDetallesSeries($idContenido, $sinopsis, $temporadas, $capitulos, $puntuacion);
                    break;
            };


            if ($resultado && $resultado2) {
                $_SESSION['mensaje'] = "El contenido se actualizó correctamente.";
                header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                exit();
            } else {
                $_SESSION['errores'][] = "Error al actualizar el contenido.";
                header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                exit();
            }
        }else {
            $_SESSION['errores'][] = "Error al actualizar el contenido.";
            header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
            exit();
        }
    }

    public function aprobarContenido() {
        if (Authentication::isAdminLogged()) {
            $errores = [];
    
            $contenidoModel = new ContenidoModel();
            $idContenido = $_GET['idContenido'];
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
                if ($contenido->estado == 2) {
                    $estado = 1;
                    $contenidoModel->cambiarEstadoUsuario($idContenido, $estado);
                    $_SESSION['mensaje'] = "Aprobado, el contenido esta de alta";
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
    public function cancelarContenido() {
        if (Authentication::isAdminLogged()) {
            $errores = [];
    
            $contenidoModel = new ContenidoModel();
            $idContenido = $_GET['idContenido'];
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
                if ($contenido->estado == 2) {
                    $estado = 2;

                    $tipo_contenido = $contenido->tipo_contenido;

                    switch ($tipo_contenido) {
                        case 'peliculas':
                            $peliculasModel = new PeliculasModel();
                            $eliminar = $peliculasModel->eliminarPelicula($idContenido);
                            break;
                        case 'series':
                            $seriesModel = new SeriesModel();
                            $eliminar = $seriesModel->eliminarSerie($idContenido);
                            break;
                        case 'cortos':
                            $cortosModel = new CortosModel();
                            $eliminar = $cortosModel->eliminarCorto($idContenido);
                            break;
                        case 'documentales':
                            $documentalesModel = new DocumentalesModel();
                            $eliminar = $documentalesModel->eliminarDocumental($idContenido);
                            break;
                        default:
                            break;
                    }
                     
                    if ($eliminar) {
                        $contenidoModel->eliminarContenido($idContenido, $estado);
                        $_SESSION['mensaje'] = "Cancelado, contenido eliminado";
                        header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                        exit();
                    } else {
                        $_SESSION['errores'][] = "Error al eliminar el contenido";
                        header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                        exit();
                    }
                } else {
                    $errores[] = 'Error al cambiar el estado';
                    header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                    exit();
                }
            } else {
                $errores[] = 'El contenido no existe';
                header("Location: " . Parameters::$BASE_URL . "Contenido/gestionarContenido");
                exit();
            }
        } else {
            ViewController::showError(403);
        }
    }
    

}