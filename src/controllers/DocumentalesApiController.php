<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Models\ContenidoModel;

class DocumentalesApiController {
    public function index(){
    }

    public function getDocumentales(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $contenidoModel = new ContenidoModel();
            $documentales = $contenidoModel->getAllByTipoContenido('documentales');
            
            if ($documentales) {
                foreach ($documentales as &$documental) {
                    $documental->url = "http://localhost/VideoFlix_PHP/ver/" . $documental->slug;
                }
                
                echo json_encode($documentales);
            } else {
                echo json_encode(['error' => 'No se encontraron documentales.']);
            }
            exit();
        } else {
            echo json_encode(['error' => 'Método no permitido.']);
            exit();
        }
    }
}






