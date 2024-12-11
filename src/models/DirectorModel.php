<?php
namespace cesar\ProyectoTest\Models;

class DirectorModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "director";
    }

}