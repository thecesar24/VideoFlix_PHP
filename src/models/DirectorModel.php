<?php
namespace cesar\ProyectoTest\Models;

class DirectorModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "director";
    }

    public function nuevoDirector($nombre, $apellidos) {
        try {
            $consulta = "INSERT INTO $this->tabla (nombre, apellidos) 
                         VALUES (:nombre, :apellidos)";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':nombre', $nombre, \PDO::PARAM_STR);
            $sentencia->bindParam(':apellidos', $apellidos, \PDO::PARAM_STR);
            $sentencia->execute();
    
            return $this->conn->lastInsertId();
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }
}