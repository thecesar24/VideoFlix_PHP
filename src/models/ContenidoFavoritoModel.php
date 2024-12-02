<?php
namespace cesar\ProyectoTest\Models;

class ContenidoFavoritoModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "contenidoFavorito";
    }

    public function aniadirFavorito($idContenido, $idUsuario) {
        try {
            $consulta = "INSERT INTO $this->tabla (id_contenido, id_usuario)
                         VALUES (:idContenido, :idUsuario)";
    
            $sentencia = $this->conn->prepare($consulta);

            $sentencia->bindParam(':idContenido', $idContenido, \PDO::PARAM_INT);
            $sentencia->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
            
            $resultado = $sentencia->execute();
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }

    public function eliminarFavorito($idContenido, $idUsuario) {
        try {
            // Consulta SQL para eliminar el favorito
            $consulta = "DELETE FROM $this->tabla WHERE id_contenido = :idContenido AND id_usuario = :idUsuario";
    
            // Preparamos la consulta
            $sentencia = $this->conn->prepare($consulta);
    
            // Enlazamos los parámetros
            $sentencia->bindParam(':idContenido', $idContenido, \PDO::PARAM_INT);
            $sentencia->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
    
            // Ejecutamos la consulta
            $resultado = $sentencia->execute();
    
            // Confirmación de eliminación
            return $resultado;
    
        } catch (\PDOException $e) {
            // En caso de error, retornamos el mensaje de error
            return ['status' => 'error', 'message' => 'Fallo en la conexión: ' . $e->getMessage()];
        }
    }
    public function getAllPorUser($idUsuario) {
        try {
            $consulta = "SELECT * 
                         FROM $this->tabla f
                         JOIN contenido c ON f.id_contenido = c.id 
                         WHERE f.id_usuario = :idUsuario";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado;
    
        } catch (\PDOException $e) {
            // En caso de error, retornamos el mensaje de error
            return ['status' => 'error', 'message' => 'Fallo en la conexión: ' . $e->getMessage()];
        }
    }


    
}