<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Models\ContenidoFavoritoModel;
use cesar\ProyectoTest\Models\SeguirViendoModel;
use cesar\ProyectoTest\Models\ContenidoModel;
use cesar\ProyectoTest\Helpers\Authentication;

class SeguirViendoController {
    public function index()
    {
    }

    public function miEspacio() {
        if (Authentication::isUserLogged()) {
            $userEntity = $_SESSION['user'];
            $idUsuario = $userEntity->getId();

            $seguirViendoModel = new SeguirViendoModel();
            $contenidoModel = new ContenidoModel();

            $idContenidos = $seguirViendoModel->getContenidosByUser($idUsuario);

            $contenidos = [];

            foreach ($idContenidos as $idContenido) {
                $contenido = $contenidoModel->getOne($idContenido->id_contenido);
                $contenidos[] = $contenido;
            }

            $contenidofavoritoModel = new ContenidoFavoritoModel();

            $favoritos = $contenidofavoritoModel->getAllPorUser($idUsuario);

            ViewController::show("views/usuarios/miEspacio.php", ['contenidos' => $contenidos,
                                                                                  'userEntity' => $userEntity,
                                                                                  'favoritos' => $favoritos]);
            exit();

        } else {
            ViewController::showError(403);
            exit();
        }
    }

    /*
    public function dashboard() {
        // Verificar si el usuario está logueado
        if (!Authentication::isUserLogged()) {
            header("Location: " . Parameters::$BASE_URL . "/login");
            exit();
        }

        // Obtener el usuario logueado desde la sesión
        $userEntity = $_SESSION['user'];

        // Modelo de videos para obtener videos que el usuario ha estado viendo
     //   $videoModel = new VideoModel();
      //  $videosVistos = $videoModel->getVideosVistosByUser($userEntity->getId());

        // Cargar la vista del dashboard con los datos del usuario y sus videos
        ViewController::show('views/usuarios/dashboard.php', [
            'usuario' => $userEntity
      //      'videosVistos' => $videosVistos
        ]);
    }

    */
    
}