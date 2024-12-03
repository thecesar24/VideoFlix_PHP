<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Validations;
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

            if (empty($comentario)) {
                $_SESSION['errores'][] = "El comentario no puede estar vacío.";
                header("Location: " . Parameters::$BASE_URL . "ver/" . urlencode($slug));
                exit();
            }
    
            if (!Validations::validateComentario($comentario)) {
                $_SESSION['errores'][] = "El comentario no coincide con el formato permitido.";
                header("Location: " . Parameters::$BASE_URL . "ver/" . urlencode($slug));
                exit();
            }
            
            $contenidoModel = new ContenidoModel();
            $contenido = $contenidoModel->getContenidoUrlAmigable($slug);

            if ($contenido === null) {
                $_SESSION['errores'][] = "No se encontró el contenido relacionado.";
                header("Location: " . Parameters::$BASE_URL);
                exit();
            }

            $idContenido = $contenido->id;
            $comentariosModel = new ComentariosModel();
            $comentariosModel->insertarComentario($idUsuario, $idContenido, $comentario);
            
            $_SESSION['mensaje'] = "Comentario agregado con éxito.";
            header("Location: " . Parameters::$BASE_URL . "ver/" . urlencode($slug));
            exit();

        } else {
            $slug = $_GET['slug'];

            $_SESSION['errores'][] = "Debes iniciar sesión para comentar";
            header("Location: " . Parameters::$BASE_URL . "ver/" . urlencode($slug));
            exit();
        }
    }
}