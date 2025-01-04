<?php
namespace cesar\ProyectoTest\Models;


class PeliculasModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "peliculas";
    }

    public function insertarDetallesSeries($idContenido, $sinopsis, $temporadas, $capitulos) {
        try {
            $sqlSeries = "INSERT INTO series (id_contenido, sinopsis, temporadas, capitulos)
                          VALUES (:id_contenido, :sinopsis, :temporadas, :capitulos)";
            $stmtSeries = $this->conn->prepare($sqlSeries);
            $stmtSeries->execute([
                'id_contenido' => $idContenido,
                'sinopsis' => $sinopsis,
                'temporadas' => (int)$temporadas,
                'capitulos' => (int)$capitulos,
            ]);
        } catch (\Exception $e) {
            echo "Error en insertarDetallesSeries: " . $e->getMessage();
        }
    }

    public function updateDetallesPeliculas($idContenido, $duracion, $sinopsis, $puntuacion) {
        try {   

            $puntuacion = (float)$puntuacion;

            $consulta = "UPDATE $this->tabla 
                         SET sinopsis = :sinopsis,
                             duracion = :duracion, 
                             puntuacion = :puntuacion
                         WHERE id_contenido = :id_contenido";
    
            $sentencia = $this->conn->prepare($consulta);
    
            $sentencia->bindParam(":id_contenido", $idContenido, \PDO::PARAM_INT);
            $sentencia->bindParam(":sinopsis", $sinopsis, \PDO::PARAM_STR);
            $sentencia->bindParam(":duracion", $duracion, \PDO::PARAM_INT);
            $sentencia->bindParam(":puntuacion", $puntuacion, \PDO::PARAM_STR);

            return $sentencia->execute();
    
        } catch (\Exception $e) {
            var_dump("Error en updateDetallesPeliculas: " . $e->getMessage());
            return false;
        }
    }

    public function getPelicula($id){
        try {
            $consulta = "select * from {$this->tabla} where id_contenido = :id";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id', $id);
            
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            
            $resultado = $sentencia->fetch();
            return $resultado;

        } catch (\PDOException $e) {
            echo '<p>Fallo en la conexion:' . $e->getMessage() . '</p>';
            // Registrar en un sistema de Log
            return NULL;
        }
    }

    public function eliminarPelicula($idContenido) {
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