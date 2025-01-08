<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;


class SeguirViendoModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "seguirviendo";
    }
    
    public function nuevoContenidoVisto($idUsuario, $idContenido) {
        try {
            $consulta = "INSERT INTO seguirviendo (id_usuario, id_contenido) VALUES (:id_usuario, :id_contenido)";
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id_contenido', $idContenido, \PDO::PARAM_INT); 
            $sentencia->bindParam(':id_usuario', $idUsuario, \PDO::PARAM_INT); 
    
            $resultado = $sentencia->execute();
    
            return $resultado; 
    
        } catch (\PDOException $e) {
            return $e;
        }
    }

    public function getContenidosByUser($idUsuario) {
        try {
            $consulta = "SELECT id_contenido
                         FROM {$this->tabla} 
                         WHERE id_usuario = :id_usuario";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id_usuario', $idUsuario);
            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_OBJ);

        } catch (\PDOException $e) {
            return null;
        }
    }

    public function dejarDeSeguirContenido($userId, $contenidoId) {
        try {
            $consulta = "DELETE FROM {$this->tabla} 
                         WHERE usuario_id = :usuario_id 
                         AND contenido_id = :contenido_id";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':usuario_id', $userId);
            $sentencia->bindParam(':contenido_id', $contenidoId);
            return $sentencia->execute();
        } catch (\PDOException $e) {
            return null;
        }
    }

}