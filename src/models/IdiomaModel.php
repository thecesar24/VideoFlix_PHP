<?php
namespace cesar\ProyectoTest\Models;

class IdiomaModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "idioma";
    }

}