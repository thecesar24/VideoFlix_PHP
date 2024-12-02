<?php
namespace cesar\ProyectoTest\Models;

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
    
    public function getContenidoUrlAmigable($slug) {
        try {
            $consulta = "SELECT * FROM contenido WHERE slug = :slug";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':slug', $slug, \PDO::PARAM_STR);
            $sentencia->execute();
            
            $resultado = $sentencia->fetch(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }

    public function getAllByIdContenido($idContenido) {
        try {
            $consulta = "SELECT * FROM $this->tabla WHERE id = :idContenido";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':idContenido', $idContenido, \PDO::PARAM_INT);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }
    

    public function buscarContenido($busqueda) {
        try {
            $consulta = "SELECT * FROM contenido WHERE titulo LIKE :busqueda";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':busqueda', $busqueda, \PDO::PARAM_STR);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }   


}