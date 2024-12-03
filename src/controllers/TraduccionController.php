<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Validations;
use cesar\ProyectoTest\Models\ComentariosModel;
use cesar\ProyectoTest\Models\ContenidoModel;

class TraduccionController {
    public function index(){
    }

    public function traducirTexto($texto, $idiomaDestino = 'es') {
        $url = "https://libretranslate.com/translate";
        $data = [
            'q' => $texto,
            'source' => 'auto',
            'target' => $idiomaDestino,
            'format' => 'text',
            'api_key' => '' // Dejar en blanco si no se requiere
        ];
    
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE));
    
        $response = curl_exec($ch);
        if ($response === false) {
            die('Error en cURL: ' . curl_error($ch));
        }
    
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($responseCode !== 200) {
            die("Error en la respuesta de la API. Código HTTP: $responseCode. Respuesta: " . $response);
        }
    
        $responseData = json_decode($response, true);
        if (!$responseData) {
            die('Error al decodificar JSON: ' . json_last_error_msg());
        }
    
        curl_close($ch);
        return $responseData['translatedText'] ?? 'Error en la traducción.';
    }
    

}