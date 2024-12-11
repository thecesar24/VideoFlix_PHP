<?php
namespace cesar\ProyectoTest\Models;

class GeneroModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "genero";
    }

    public function obtenerOInsertarGenero($nombreGenero) {
        $consulta = "SELECT id FROM genero WHERE nombre = :nombre";

        $sentencia = $this->conn->prepare($consulta);
        $sentencia->execute([':nombre' => $nombreGenero]);
        $idGenero = $sentencia->fetchColumn();
    
        if ($idGenero) {
            return $idGenero;
        } else {
            $sql = "INSERT INTO genero (nombre) VALUES (:nombre)";
            $sentencia = $this->conn->prepare($sql);
            $sentencia->execute([':nombre' => $nombreGenero]);
            return $this->conn->lastInsertId();
        }
    }

}