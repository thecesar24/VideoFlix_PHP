<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;


class SeriesModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "series";
    }

    public function insertarDetallesSeries($idContenido, $sinopsis, $temporadas, $capitulos, $puntuacion) {
        try {
            $sqlSeries = "INSERT INTO $this->tabla (id_contenido, sinopsis, temporadas, capitulos, puntuacion)
                          VALUES (:id_contenido, :sinopsis, :temporadas, :capitulos, :puntuacion)";
            $stmtSeries = $this->conn->prepare($sqlSeries);
            $stmtSeries->execute([
                'id_contenido' => $idContenido,
                'sinopsis' => $sinopsis,
                'temporadas' => (int)$temporadas,
                'capitulos' => (int)$capitulos,
                'puntuacion' => $puntuacion
            ]);
        } catch (\Exception $e) {
            echo "Error en insertarDetallesSeries: " . $e->getMessage();
        }
    }

    public function updateDetallesSeries($idContenido, $sinopsis, $temporadas, $capitulos, $puntuacion) {
        try {   

            $puntuacion = (float)$puntuacion;

            $consulta = "UPDATE $this->tabla 
                         SET sinopsis = :sinopsis, 
                             temporadas = :temporadas, 
                             capitulos = :capitulos, 
                             puntuacion = :puntuacion
                         WHERE id_contenido = :id_contenido";
    
            $sentencia = $this->conn->prepare($consulta);
    
            $sentencia->bindParam(":id_contenido", $idContenido, \PDO::PARAM_INT);
            $sentencia->bindParam(":sinopsis", $sinopsis, \PDO::PARAM_STR);
            $sentencia->bindParam(":temporadas", $temporadas, \PDO::PARAM_INT);
            $sentencia->bindParam(":capitulos", $capitulos, \PDO::PARAM_INT);
            $sentencia->bindParam(":puntuacion", $puntuacion, \PDO::PARAM_STR);

            return $sentencia->execute();
    
        } catch (\Exception $e) {
            var_dump("Error en updateDetallesSeries: " . $e->getMessage());
            exit();
            return false;
        }
    }

    public function insertarCapitulo($num_capitulo, $num_temporada, $url_cap, $id_serie) {
        try {
            $consulta = "INSERT INTO capitulos (num_capitulo, num_temporada, url_cap, id_serie)
                         VALUES (:num_capitulo, :num_temporada, :url_cap, :id_serie)";
            
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute([
                'num_capitulo' => $num_capitulo,
                'num_temporada' => $num_temporada,
                'id_serie' => $id_serie,
                'url_cap' => $url_cap
            ]);
        } catch (\Exception $e) {
            echo "Error en insertarDetallesSeries: " . $e->getMessage();
            exit();
        }
    }

    public function getAllCapitulosPorSerie($id_serie){
        try {
            $consulta = "SELECT * FROM capitulos WHERE id_serie = :id_serie";
            
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id_serie' , $id_serie);

            $sentencia->execute();
            return $sentencia->fetchAll(\PDO::FETCH_OBJ);
            
        } catch (\Exception $e) {
            echo "Error en getAllCapitulos: " . $e->getMessage();
            exit();
        }
    }

    public function getSerie($id){
        try {
            $consulta = "SELECT * FROM {$this->tabla} WHERE id_contenido = :id";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id', $id);
            
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            
            $resultado = $sentencia->fetch();
            return $resultado;

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            return NULL;
        }
    }

    public function eliminarSerie($idContenido) {
        try {
            $consulta = "DELETE FROM {$this->tabla}
                         WHERE id_contenido = :idContenido";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam("idContenido", $idContenido, \PDO::PARAM_INT);

            return $sentencia->execute();

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion: ' . $e->getMessage() . '</p>';
        }
    }
}