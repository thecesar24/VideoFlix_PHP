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
    public function insertarContenido($titulo, $slug ,$año, $id_director, $tipo_contenido) {
        try {    
            $consultaContenido = "INSERT INTO $this->tabla (titulo, slug, year, tipo_contenido, id_idioma, id_director, estado) 
                                  VALUES (:titulo, :slug, :ano, :tipo_contenido, '1', :id_director, '1')";
    
            $sentenciaContenido = $this->conn->prepare($consultaContenido);
    
            $sentenciaContenido->bindParam("titulo", $titulo, \PDO::PARAM_STR);
            $sentenciaContenido->bindParam("slug", $slug, \PDO::PARAM_STR);
            $sentenciaContenido->bindParam("ano", $año, \PDO::PARAM_INT);
            $sentenciaContenido->bindParam("id_director", $id_director, \PDO::PARAM_INT);
            $sentenciaContenido->bindParam("tipo_contenido", $tipo_contenido, \PDO::PARAM_STR);
    
            $sentenciaContenido->execute();
            return $this->conn->lastInsertId(); 
    
        } catch (\Exception $e) {
            error_log("Error in insertarContenido: " . $e->getMessage());
            return false;
        }
    }

    public function insertarDetallesPeliculas($idContenido, $duracion, $sinopsis) {
        try {
            $sqlPeliculas = "INSERT INTO peliculas (id_contenido, duracion, sinopsis)
                             VALUES (:id_contenido, :duracion, :sinopsis)";
            $stmtPeliculas = $this->conn->prepare($sqlPeliculas);
            $stmtPeliculas->execute([
                'id_contenido' => $idContenido,
                'duracion' => (int)$duracion,
                'sinopsis' => $sinopsis,
            ]);
        } catch (\Exception $e) {
            echo "Error en insertarDetallesPeliculas: " . $e->getMessage();
        }
    }

    // Función para insertar detalles de cortos
    public function insertarDetallesCortos($idContenido, $duracion) {
        try {
            $sqlCortos = "INSERT INTO cortos (id_contenido, duracion)
                          VALUES (:id_contenido, :duracion)";
            $stmtCortos = $this->conn->prepare($sqlCortos);
            $stmtCortos->execute([
                'id_contenido' => $idContenido,
                'duracion' => (int)$duracion,
            ]);
        } catch (\Exception $e) {
            echo "Error en insertarDetallesCortos: " . $e->getMessage();
        }
    }

    // Función para insertar detalles de documentales
    public function insertarDetallesDocumentales($idContenido, $duracion) {
        try {
            $sqlDocumentales = "INSERT INTO documentales (id_contenido, duracion)
                                VALUES (:id_contenido, :duracion)";
            $stmtDocumentales = $this->conn->prepare($sqlDocumentales);
            $stmtDocumentales->execute([
                'id_contenido' => $idContenido,
                'duracion' => (int)$duracion,
            ]);
        } catch (\Exception $e) {
            echo "Error en insertarDetallesDocumentales: " . $e->getMessage();
        }
    }

}