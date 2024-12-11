<?php
namespace cesar\ProyectoTest\Entities;

class ContenidoEntity {
    private $id;
    private $titulo;
    private $slug;
    private $año;
    private $tipo_contenido;
    private $id_genero;
    private $id_idioma;
    private $portada;
    private $video;
    private $id_director;
    private $estado;

    public function __construct() {}

    // Setters
    public function setId($id) { $this->id = $id; return $this; }
    public function setTitulo($titulo) { $this->titulo = $titulo; return $this; }
    public function setSlug($slug) { $this->slug = $slug; return $this; }
    public function setAño($año) { $this->año = $año; return $this; }
    public function setTipoContenido($tipo_contenido) { $this->tipo_contenido = $tipo_contenido; return $this; }
    public function setIdGenero($id_genero) { $this->id_genero = $id_genero; return $this; }
    public function setIdIdioma($id_idioma) { $this->id_idioma = $id_idioma; return $this; }
    public function setPortada($portada) { $this->portada = $portada; return $this; }
    public function setVideo($video) { $this->video = $video; return $this; }
    public function setIdDirector($id_director) { $this->id_director = $id_director; return $this; }
    public function setEstado($estado) { $this->estado = $estado; return $this; }

    // Getters
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getSlug() { return $this->slug; }
    public function getAño() { return $this->año; }
    public function getTipoContenido() { return $this->tipo_contenido; }
    public function getIdGenero() { return $this->id_genero; }
    public function getIdIdioma() { return $this->id_idioma; }
    public function getPortada() { return $this->portada; }
    public function getVideo() { return $this->video; }
    public function getIdDirector() { return $this->id_director; }
    public function getEstado() { return $this->estado; }
}
