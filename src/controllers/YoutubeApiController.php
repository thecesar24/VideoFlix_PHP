<?php

namespace cesar\ProyectoTest\Controllers;

class YoutubeApiController {
    public function index(){
    }

    private $apikey;

    public function __construct(){
        $this->apikey = 'AIzaSyCxfqghJJzAL7zoJRXmVDoKjHep6cwr28g';
    }
    public function getTrailer($titulo) {
        $cacheKey = 'trailer_' . md5($titulo); 
        $cachedTrailer = $this->getFromCache($cacheKey); 
    
        if ($cachedTrailer) {
            return $cachedTrailer; 
        }
    
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
    
                $this->storeInCache($cacheKey, $trailerUrl);
    
                return $trailerUrl;
            } else {
                return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
            }
        } catch (\Exception $e) {
            return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
        }
    }

    public function getContenidoCompleto($titulo) {
        $cacheKey = 'fullcontenido_' . md5($titulo); 
        $cachedContent = $this->getFromCache($cacheKey); 
    
        if ($cachedContent) {
            return $cachedContent;
        }
    
        $query = urlencode($titulo . " pelicula completa castellano");
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . $query . "&type=video&key=" . $this->apikey . "&maxResults=1";
    
        try {
            $response = @file_get_contents($url);
    
            if ($response === FALSE) {
                throw new \Exception('Error al comunicarse con la API de YouTube.');
            }
    
            $data = json_decode($response, true);
            if (isset($data['items'][0]['id']['videoId'])) {
                $contentUrl = "https://www.youtube.com/embed/" . $data['items'][0]['id']['videoId'];
    
                $this->storeInCache($cacheKey, $contentUrl);
    
                return $contentUrl;
            } else {
                return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
            }
        } catch (\Exception $e) {
            return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
        }
    }
    public function getCapituloCompleto($titulo) {
        $cacheKey = 'capituloFull_' . md5($titulo); 
        $cachedCapitulo = $this->getFromCache($cacheKey); 
    
        if ($cachedCapitulo) {
            return $cachedCapitulo;
        }
    
        $query = urlencode($titulo . " capitulo 1 temporada 1 completo castellano");
        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . $query . "&type=video&key=" . $this->apikey . "&maxResults=1";
    
        try {
            $response = @file_get_contents($url);
    
            if ($response === FALSE) {
                throw new \Exception('Error al comunicarse con la API de YouTube.');
            }
    
            $data = json_decode($response, true);
            if (isset($data['items'][0]['id']['videoId'])) {
                $capituloUrl = "https://www.youtube.com/embed/" . $data['items'][0]['id']['videoId'];
    
                $this->storeInCache($cacheKey, $capituloUrl);
    
                return $capituloUrl;
            } else {
                return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
            }
        } catch (\Exception $e) {
            return "https://www.youtube.com/embed/VIDEO_ID_PREDETERMINADO";
        }
    }
    
    private function getFromCache($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
    
    private function storeInCache($key, $value) {
        $_SESSION[$key] = $value; 
    }
    
    
}



