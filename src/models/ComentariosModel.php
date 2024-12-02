<?php
namespace cesar\ProyectoTest\Models;

class ComentariosModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "comentarios";
    }

    public function getAllByIdContenido($idContenido) {
        try {
            $consulta = "SELECT * FROM $this->tabla WHERE id_contenido = :idContenido";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':idContenido', $idContenido, \PDO::PARAM_INT);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }

    public function insertarComentario($idUsuario, $idContenido, $comentario) {
        try {
            $consulta = "INSERT INTO $this->tabla (id_usuario, id_contenido, comentario, fecha_comentario) 
                         VALUES (:idUsuario, :idContenido, :comentario, NOW()   )";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':idUsuario', $idUsuario, \PDO::PARAM_INT);
            $sentencia->bindParam(':idContenido', $idContenido, \PDO::PARAM_INT);
            $sentencia->bindParam(':comentario', $comentario, \PDO::PARAM_STR);
            
            $resultado = $sentencia->execute();
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }        
    }
}