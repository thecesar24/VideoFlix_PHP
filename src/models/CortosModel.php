<?php
namespace cesar\ProyectoTest\Models;


class CortosModel extends Model{

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

    public function getCorto($id){
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
}