<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;


class CapitulosModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "capitulos";
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

    public function getCapituloAnterior($idContenido, $numeroCapitulo) {
        try {
            $consulta = "SELECT * FROM capitulos 
                         WHERE id_serie = :idContenido AND num_capitulo < :numeroCapitulo  
                         LIMIT 1";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute([
                'idContenido' => $idContenido,
                'numeroCapitulo' => $numeroCapitulo
            ]);

            return $sentencia->fetch();
            
        } catch (\Exception $e) {
            echo "Error en getCapituloAnterior: " . $e->getMessage();
            exit();
        }
    }
    
    public function getCapituloSiguiente($idContenido, $numeroCapitulo) {
        try {
            $consulta = "SELECT * FROM capitulos 
                         WHERE id_serie = :idContenido AND num_capitulo > :numeroCapitulo 
                         ORDER BY num_capitulo ASC 
                         LIMIT 1";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute([
                'idContenido' => $idContenido,
                'numeroCapitulo' => $numeroCapitulo
            ]);

            return $sentencia->fetch();
            
        } catch (\Exception $e) {
            echo "Error en getCapituloSiguiente: " . $e->getMessage();
            exit();
        }
    }

    public function getCapituloPorNumero($idContenido, $numeroTemporada, $numeroCapitulo) {
        try{
            $consulta = "SELECT * FROM capitulos 
                         WHERE id_serie = :idContenido 
                         AND num_temporada = :numeroTemporada 
                         AND num_capitulo = :numeroCapitulo";
                         
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute([
                'idContenido' => $idContenido,
                'numeroTemporada' => $numeroTemporada,
                'numeroCapitulo' => $numeroCapitulo
            ]);
            return $sentencia->fetch();

        }catch (\Exception $e) {
            echo "Error en getCapitulosPorNumero: " . $e->getMessage();
            exit();
        }
    }

    public function getTemporadasPorContenido($idContenido) {
        try {
            $consulta = "SELECT DISTINCT num_temporada FROM capitulos 
                         WHERE id_serie = :idContenido 
                         ORDER BY num_temporada";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->execute(['idContenido' => $idContenido]);
            return $sentencia->fetchAll(\PDO::FETCH_COLUMN);
        }catch(\Exception $e) {
            echo "Error en getTemporadasPorContenido: " . $e->getMessage();
            exit();
        }
    }
    
    public function getCapitulosPorTemporada($idContenido, $numeroTemporada) {
        try{

            $consulta = "SELECT * FROM capitulos 
                         WHERE id_serie = :idContenido 
                         AND num_temporada = :numeroTemporada 
                         ORDER BY num_capitulo";
            $sentencia = $this->conn->prepare($consulta);
            
            $sentencia->execute([
                'idContenido' => $idContenido,
                'numeroTemporada' => $numeroTemporada
            ]);
            
            return $sentencia->fetchAll(\PDO::FETCH_OBJ);

        } catch(\Exception $e){
            echo "Error en getCapitulosPorTemporada: " . $e->getMessage();
            exit();
        }
    }
}