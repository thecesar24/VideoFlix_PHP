<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;
use cesar\ProyectoTest\Config\Parameters;


class InicioModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "contenido";
    }

    public function getAllCountAlumnos(){
        try {

            $consulta = "select count(*) as cuenta from {$this->tabla} WHERE rol='A'";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            return $resultado->cuenta;

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            // Registrar en un sistema de Log
            return NULL;
        }        
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
    

    public function usernameExiste($username){
        $consulta =" SELECT * FROM usuarios WHERE username = :username";
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

    public function getUsersRegistrados() {
        try {
            $consulta = "SELECT COUNT(*) AS total FROM usuarios";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(\PDO::FETCH_OBJ);
            return $resultado;
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }
    
    public function blockAlumno($id){
        try {
            $consulta = "UPDATE usuarios
                        SET estado = '0'
                        WHERE id = $id AND rol='A'";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            $resultado = $sentencia->fetch(\PDO::FETCH_OBJ);
            return $resultado; 
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }

    public function unblockAlumno($id){
        try {
            $consulta = "UPDATE usuarios
                        SET estado = '1'
                        WHERE id = $id AND rol='A'";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            //$resultados = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            $resultados = $sentencia->fetchAll(\PDO::FETCH_OBJ);
            return $resultados;
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }

    public function blockUsuario($id){
        try {
            $consulta = "UPDATE usuarios
                        SET estado = '0'
                        WHERE id = $id AND rol!='X'";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            $resultado = $sentencia->fetch(\PDO::FETCH_OBJ);
            return $resultado; 
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }

    public function unblockUsuario($id){
        try {
            $consulta = "UPDATE usuarios
                        SET estado = '1'
                        WHERE id = $id AND rol!='X'";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            //$resultados = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            $resultados = $sentencia->fetchAll(\PDO::FETCH_OBJ);
            return $resultados;
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }

    public function getAllinfoDeAlumnos() {
        try {
            $consulta = "SELECT id, nombreCompleto, estado
                        FROM usuarios
                        WHERE rol = 'A'
                        ORDER BY nombreCompleto";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            //$resultados = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            $resultados = $sentencia->fetchAll(\PDO::FETCH_OBJ);
            return $resultados;
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }

    public function getAllinfoDeUsuarios() {
        try {
            $consulta = "SELECT *
                        FROM usuarios
                        WHERE rol = 'A' OR rol = 'D'
                        ORDER BY ultimoAcceso DESC";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute();
            //$resultados = $sentencia->fetchAll(\PDO::FETCH_ASSOC);
            $resultados = $sentencia->fetchAll(\PDO::FETCH_OBJ);
            return $resultados;
        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }
    
}