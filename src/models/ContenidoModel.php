<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;


class ContenidoModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "contenido";
    }

    public function get4RandByTipoContenido($tipoContenido) {
        try {
            $consulta = "SELECT * FROM contenido WHERE tipo_contenido = :tipoContenido ORDER BY RAND() LIMIT 4";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':tipoContenido', $tipoContenido, \PDO::PARAM_STR);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }

    public function getAllByTipoContenido($tipoContenido) {
        try {
            $consulta = "SELECT * FROM contenido WHERE tipo_contenido = :tipoContenido";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':tipoContenido', $tipoContenido, \PDO::PARAM_STR);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }
    
    
}