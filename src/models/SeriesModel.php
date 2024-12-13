<?php
namespace cesar\ProyectoTest\Models;
use cesar\ProyectoTest\Entities\UserEntity;


class SeriesModel extends Model{

    public function __construct(){
        parent::__construct();
        $this->tabla = "series";
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

    public function insertarCapitulo($idContenido, $sinopsis, $temporadas, $capitulos) {
        try {
            $sqlSeries = "INSERT INTO capitulos (id_contenido, sinopsis, temporadas, capitulos)
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
}