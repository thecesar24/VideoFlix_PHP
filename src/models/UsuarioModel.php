<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;


class UsuarioModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "usuarios";
    }
    
    public function register(UserEntity $userEntity) {
        try {
            $consulta = "INSERT INTO {$this->tabla}(nombre, apellidos, email, username, password, estado) 
                         VALUES(:nombre, :apellidos, :email, :username, :password, 1)";
    
            $nombre = $userEntity->getNombre();
            $apellidos = $userEntity->getApellidos();
            $email = $userEntity->getEmail();
            $username = $userEntity->getUsername();
            $passwordSecure = password_hash($userEntity->getPassword(), PASSWORD_DEFAULT);
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':apellidos', $apellidos);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':username', $username);
            $sentencia->bindParam(':password', $passwordSecure);
    
            return $sentencia->execute();

        } catch (\PDOException $e) {
            echo "<p>Falló la conexion: {$e->getMessage()}</p>";
            return false; // Falló el registro
        }
    }

    public function login($username){
        $consulta ="SELECT * FROM usuarios WHERE username = :username";
        try{
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':username', $username);
            $sentencia->execute();
            return $sentencia->fetch(\PDO::FETCH_OBJ);
            
        }catch(\PDOException $e){
            return NULL;
        }
    }

    public function update(UserEntity $userEntity) {
        try {
            $consulta = "UPDATE {$this->tabla} SET nombre = :nombre, apellidos = :apellidos, email = :email, username = :username
                         WHERE id = :id";
            
            $sentencia = $this->conn->prepare($consulta);
    
            $nombre = $userEntity->getNombre();
            $apellidos = $userEntity->getApellidos();
            $email = $userEntity->getEmail();
            $id = $userEntity->getId();
            $username = $userEntity->getUsername();
    
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':apellidos', $apellidos);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':id', $id);
            $sentencia->bindParam(':username', $username);
            
            return $sentencia->execute();
    
        } catch (\PDOException $e) {
            return NULL;
        }
    }

    public function mailExistente($email){
        $consulta ="SELECT email FROM $this->tabla WHERE email = :email";
        try{
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':email', $email);
            $sentencia->execute();
            // Se retorna el objeto:
            return $sentencia->fetch(\PDO::FETCH_OBJ);
        }catch(\PDOException $e){
            return NULL;
        }
    }

    public function getAllMenosAdmin($username){

        $consulta ="SELECT * FROM $this->tabla WHERE username != :username";
        try{
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':username', $username);
            $sentencia->execute();

            return $sentencia->fetchAll(\PDO::FETCH_OBJ);

        }catch(\PDOException $e){
            return NULL;
        }
    }

    public function cambiarEstadoUsuario($idUsuario, $estado) {
        try {
            $consulta = "UPDATE {$this->tabla}
                         SET estado = :estado
                         WHERE id = :idUsuario";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam("idUsuario", $idUsuario, \PDO::PARAM_INT);
            $sentencia->bindParam("estado", $estado, \PDO::PARAM_INT);
            
            return $sentencia->execute();

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }
    }

}