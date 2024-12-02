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
}