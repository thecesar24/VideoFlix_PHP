<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Models\ContenidoFavoritoModel;


class ContenidoFavoritoController {
    public function index(){
    }

    public function aniadirFavorito()  {
        if (Authentication::isUserLogged()) {
            $favorito = $_POST['favorito'];
            $idContenido = $_POST['idContenido'];
            $userEntity = $_SESSION['user'];
            $idUsuario = $userEntity->getId();

            $contenidoFavoritoModel = new ContenidoFavoritoModel();

            if ($favorito == "1") {
                $contenidoFavoritoModel->aniadirFavorito($idContenido, $idUsuario);
            }
            if ($favorito == "0") {
                $contenidoFavoritoModel->eliminarFavorito($idContenido, $idUsuario);
            }
        } else {
            ViewController::showError(403);
        }
    }
}