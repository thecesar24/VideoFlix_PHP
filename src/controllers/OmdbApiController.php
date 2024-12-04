<?php

namespace cesar\ProyectoTest\Controllers;

class OmdbApiController {
    public function index(){
    }

    private $apikey;

    public function __construct(){
        $this->apikey = '68fbbd15';
    }
    
    public function obtenerDatosOMDb($slug) {
        $url = "http://www.omdbapi.com/?t=" . urlencode($slug) . "&apikey=" . $this->apikey . "&language=es";

        $response = file_get_contents($url);

        if (!$response) {
            throw new \Exception('No se pudo conectar a la API de OMDb.');
        }

        $data = json_decode($response, true);

        if ($data === null) {
            throw new \Exception('Error al decodificar JSON: ' . json_last_error_msg());
        }

        return $data['Response'] === 'True' ? $data : null;
    }
}