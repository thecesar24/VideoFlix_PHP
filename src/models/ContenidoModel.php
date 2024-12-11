<?php
namespace cesar\ProyectoTest\Models;

class ContenidoModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "contenido";
    }

    public function get4RandByTipoContenido($tipoContenido) {
        try {
            $consulta = "SELECT * FROM contenido WHERE estado != 0 AND tipo_contenido = :tipoContenido ORDER BY RAND() LIMIT 4";
    
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
            $consulta = "SELECT * FROM contenido WHERE estado != 0 AND tipo_contenido = :tipoContenido";
    
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
            $consulta = "SELECT * FROM contenido WHERE titulo LIKE :busqueda AND estado != 0";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':busqueda', $busqueda, \PDO::PARAM_STR);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    } 
    
    public function cambiarEstadoUsuario($idContenido, $estado) {
        try {
            $consulta = "UPDATE {$this->tabla}
                         SET estado = :estado
                         WHERE id = :idContenido";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam("idContenido", $idContenido, \PDO::PARAM_INT);
            $sentencia->bindParam("estado", $estado, \PDO::PARAM_INT);
            
            return $sentencia->execute();

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }
    }

    public function getAllTipos() {
        try {
            $consulta = "SELECT DISTINCT tipo_contenido FROM contenido";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }


}