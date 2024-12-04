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
    public function getTrailer($titulo){


        if (!$titulo) {
            $_SESSION['errores'][] = 'No se encontraron resultados para la película.';
            header("Location: " . Parameters::$BASE_URL . 'Inicio/index');
            exit();
        }

        $query = urlencode($titulo . " trailer") ;

        $url = "https://www.googleapis.com/youtube/v3/search?part=snippet&q=" . $query . "&type=video&key=" . $this->apikey . "&maxResults=2";
        $response = file_get_contents($url);
        
        if (!$response) {
            throw new \Exception('Error al comunicarse con YouTube API.');
        }

        $data = json_decode($response, true);

        if (!isset($data['items'][0]['id']['videoId'])) {
            return null;
        }

        return "https://www.youtube.com/embed/" . $data['items'][0]['id']['videoId'];
    }
}