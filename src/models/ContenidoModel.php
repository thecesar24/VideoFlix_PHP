<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;


class ContenidoModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "contenido";
    }

    public function get4RandPeliculas() {
        try {
            $consulta = "SELECT * FROM contenido WHERE tipo_contenido = 'pelicula' ORDER BY RAND() LIMIT 4";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }

    public function getAllPeliculas() {
        try {
            $consulta = "SELECT * FROM contenido WHERE tipo_contenido = 'pelicula'";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }
    
    
}