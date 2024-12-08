<?php

namespace cesar\ProyectoTest\Controllers;

class TraduccionController
{
    private $auth_key = '24f92c75-f86b-4295-b1a1-97aa1ddcb471:fx';

    // Método para traducir el texto
    public function traducir($text, $target_lang)
    {
        $url = "https://api-free.deepl.com/v2/translate";
        $data = array(
            'auth_key' => $this->auth_key,
            'text' => $text,
            'target_lang' => strtoupper($target_lang) 
        );

        // Inicializa cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Ejecuta la solicitud
        $response = curl_exec($ch);

        // Verifica si hubo algún error con cURL
        if(curl_errno($ch)) {
            echo 'Error de cURL: ' . curl_error($ch);
        }

        // Cierra la conexión cURL
        curl_close($ch);

        // Decodifica la respuesta JSON
        $response_data = json_decode($response, true);

        // Si la respuesta contiene una traducción, devuelve el texto traducido
        if (isset($response_data['translations'][0]['text'])) {
            return $response_data['translations'][0]['text'];
        } else {
            return "Error al traducir el texto.";
        }
    }
}