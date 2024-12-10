<?php

namespace cesar\ProyectoTest\Controllers;

use cesar\ProyectoTest\Config\Parameters;
use cesar\ProyectoTest\Helpers\Authentication;
use cesar\ProyectoTest\Models\ComentariosModel;
use cesar\ProyectoTest\Models\ContenidoFavoritoModel;
use cesar\ProyectoTest\Models\ContenidoModel;
use cesar\ProyectoTest\Controllers\ViewController;

class YoutubeApiController {
    public function index(){
    }

    private $apikey;

    public function __construct(){
        $this->apikey = 'AIzaSyCxfqghJJzAL7zoJRXmVDoKjHep6cwr28g';
    }
    public function getTrailer($titulo) {
        // Verificar si ya tenemos un trailer almacenado en caché
        $cacheKey = 'trailer_' . md5($titulo); // Genera una clave única basada en el título
        $cachedTrailer = $this->getFromCache($cacheKey); // Obtener del caché (puede ser base de datos o archivos)
    
        if ($cachedTrailer) {
            return $cachedTrailer; // Devuelve el trailer almacenado en caché
        }
    
        // Si no está en caché, hacemos la solicitud a la API
        $query = urlencode($titulo . " trailer");
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . $query . "&type=video&key=" . $this->apikey . "&maxResults=1";
    
        try {
            $response = @file_get_contents($url);
    
            if ($response === FALSE) {
                throw new \Exception('Error al comunicarse con la API de YouTube.');
            }
    
            $data = json_decode($response, true);
            if (isset($data['items'][0]['id']['videoId'])) {
                $trailerUrl = "https://www.youtube.com/embed/" . $data['items'][0]['id']['videoId'];
    
                // Almacenar el trailer en caché para la próxima vez
                $this->storeInCache($cacheKey, $trailerUrl);
    
                return $trailerUrl;
            } else {
                return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
            }
        } catch (\Exception $e) {
            return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
        }
    }
    
    // Métodos de caché simples
    private function getFromCache($key) {
        // Recupera el valor de la caché (puedes implementarlo en una base de datos o archivo)
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null; // Ejemplo de caché en sesión
    }
    
    private function storeInCache($key, $value) {
        // Almacena el valor en caché (puedes implementarlo en una base de datos o archivo)
        $_SESSION[$key] = $value; // Ejemplo de caché en sesión
    }
    
    
}