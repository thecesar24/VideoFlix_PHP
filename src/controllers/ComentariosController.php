<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Models\ComentariosModel;
use cesar\ProyectoTest\Models\ContenidoModel;

class ComentariosController {
    public function index(){
    }

    public function insertarComentario(){

        if (Authentication::isUserLogged()) {
            
            $userEntity = $_SESSION['user'];
            
            $comentario = $_POST['comentario'];
            $slug = $_GET['slug'];
            $idUsuario = $userEntity->getId();
            
            $contenidoModel = new ContenidoModel();
            $idContenido = $contenidoModel->getContenidoUrlAmigable($slug)->id;
            
            $comentariosModel = new ComentariosModel();
            $comentariosModel->insertarComentario($idUsuario, $idContenido, $comentario);
            
            header("Location: " . Parameters::$BASE_URL . "ver/" . urlencode($slug));
            exit();

        } else {
            ViewController::showError(403);
        }
    }
}