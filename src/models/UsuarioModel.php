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
            $consulta = "INSERT INTO {$this->tabla}(nombre, apellidos, telefono, email, username, password) 
                         VALUES(:nombre, :apellidos, :telefono, :email, :username, :password)";
    
            $nombre = $userEntity->getNombre();
            $apellidos = $userEntity->getApellidos();
            $telefono = $userEntity->getTelefono();
            $email = $userEntity->getEmail();
            $username = $userEntity->getUsername();
            $passwordSecure = password_hash($userEntity->getPassword(), PASSWORD_DEFAULT);
    
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':nombre', $nombre);
            $sentencia->bindParam(':apellidos', $apellidos);
            $sentencia->bindParam(':telefono', $telefono);
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
            // Se retorna el objeto:
            return $sentencia->fetch(\PDO::FETCH_OBJ);
        }catch(\PDOException $e){
            return NULL;
        }
    }
}