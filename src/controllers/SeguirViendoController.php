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

    public function Add() {
        if (isset($_GET['slug'])) {
            $slug = $_GET['slug'];
            $userEntity = $_SESSION['user'];
            $idUsuario = $userEntity->getId();
            $contenidoModel = new ContenidoModel;
            $idContenido = $contenidoModel->getContenidoUrlAmigable($slug)->id;

            $seguirViendoModel = new SeguirViendoModel;

            $comprobar = $seguirViendoModel->getContenidosByUser($idUsuario);

            if (!$comprobar) {
                $resultado = $seguirViendoModel->nuevoContenidoVisto($idUsuario, $idContenido);
            }


            if ($resultado) {
                echo "Añadido a 'Seguir viendo'";
            } else {
                echo "Error al añadir a 'Seguir viendo'";
            }
        }
    }

}