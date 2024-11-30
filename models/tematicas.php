<?php

require_once 'connection.php';

class Tematicas extends Connection {

    public function consultarTematicaPorId($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE tematicas.idTematica=:idTematica ORDER BY nombreTematica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarNombreTematicaPorId($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT tematicas.nombreTematica "
                . "FROM tematicas "
                . "WHERE tematicas.idTematica=:idTematica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        $nombreTematica = $stmt->fetch()['nombreTematica'];
        return $nombreTematica;
    }
    
     public function listarTematicasPorConjunto($idConjunto) {
        $stmt = Connection::connect()->prepare("SELECT nombreTematica 
            FROM tematicas
            INNER JOIN dimensiones
            ON tematicas.idDimension =  dimensiones.idDimension
            WHERE dimensiones.idConjuntoIndicadores= :idConjunto ");
        $stmt->bindParam(":idConjunto", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicasSisPorDimensionCali($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "AND indicadores.idIndicador=seriedatos.idIndicador "
                . "AND seriedatos.zonaGeografica ='Cali'");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function consultarTematicasPorDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "AND indicadores.idIndicador=seriedatos.idIndicador "
                . "AND seriedatos.tipoZonaGeografica != 'Comuna' "
                . "AND seriedatos.tipoZonaGeografica != 'Corregimiento' "
                . "ORDER BY tematicas.posicion, tematicas.nombreTematica ASC");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicasPorDimensionComunasCorregimientos($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "AND indicadores.idIndicador=seriedatos.idIndicador "
                . "AND (seriedatos.tipoZonaGeografica='Comuna' OR seriedatos.tipoZonaGeografica='Corregimiento')");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicasPorDimensionDadii($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "ORDER BY tematicas.posicion, tematicas.nombreTematica ASC");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    
    public function consultarTematicasSisPorDimensionYZonaActualComunasCorregimientos($idDimension, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "AND indicadores.idIndicador=seriedatos.idIndicador "
                . "AND (seriedatos.tipoZonaGeografica='Comuna' OR seriedatos.tipoZonaGeografica='Corregimiento')"
                . "AND seriedatos.zonaGeografica=:zonaGeografica");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicasSisPorDimensionComparativos($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "AND indicadores.idIndicador=seriedatos.idIndicador "
                . "AND (seriedatos.tipoZonaGeografica!='Comuna' AND seriedatos.tipoZonaGeografica!='Corregimiento') "
                . "AND seriedatos.zonaGeografica!='Cali'");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicasIgcPorDimensionCali($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "AND indicadores.idIndicador=seriedatos.idIndicador ");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicasPorDimensionGlobalesCiudad($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas "
                . "WHERE tematicas.idDimension=:idDimension ");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function consultarTematicasPorIdDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE tematicas.idDimension = :idDimension "
                . "ORDER BY tematicas.nombreTematica");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
     public function consultarDimensionPorIdTematica($idTematica) {
        $stmt = Connection::connect()->prepare("SELECT idDimension "
                . "FROM tematicas "
                . "WHERE idTematica=:idTematica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        $idDimension = $stmt->fetch()['idDimension'];
        return $idDimension;
    }

    public function consultarTematicasPorDimensionExpediente($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT * "
                . "FROM tematicas "
                . "WHERE tematicas.idDimension=:idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicasExpPorDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tematicas.nombreTematica, tematicas.idTematica "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE tematicas.idDimension=:idDimension "
                . "AND tematicas.idTematica=indicadores.idTematica "
                . "AND indicadores.idIndicador=seriedatos.idIndicador ");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
     public function listarTematicasPorProceso($idConjunto, $idDimension) {
        $resp = array();
//      ESTRATEGICO
        $stmt = Connection::connect()->prepare("SELECT * 
            FROM tematicas
            INNER JOIN dimensiones
            ON tematicas.idDimension =  dimensiones.idDimension
            WHERE dimensiones.idConjuntoIndicadores= :idConjunto 
            AND dimensiones.idDimension= :idDimension 
            AND tematicas.idDimension LIKE 'me%' ");
        $stmt->bindParam(":idConjunto", $idConjunto, PDO::PARAM_STR);
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        $resp[] = $stmt->fetchAll();

//      MISIONAL
        $stmt = Connection::connect()->prepare("SELECT * 
            FROM tematicas
            INNER JOIN dimensiones
            ON tematicas.idDimension =  dimensiones.idDimension
            WHERE dimensiones.idConjuntoIndicadores= :idConjunto 
            AND dimensiones.idDimension= :idDimension 
            AND tematicas.idDimension LIKE 'mm%' ");
        $stmt->bindParam(":idConjunto", $idConjunto, PDO::PARAM_STR);
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        $resp[] = $stmt->fetchAll();

//          APOYO
        $stmt = Connection::connect()->prepare("SELECT * 
            FROM tematicas
            INNER JOIN dimensiones
            ON tematicas.idDimension =  dimensiones.idDimension
            WHERE dimensiones.idConjuntoIndicadores= :idConjunto 
            AND dimensiones.idDimension= :idDimension 
            AND tematicas.idDimension LIKE 'ma%' ");
        $stmt->bindParam(":idConjunto", $idConjunto, PDO::PARAM_STR);
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        $resp[] = $stmt->fetchAll();

//          CONTROL
        $stmt = Connection::connect()->prepare("SELECT * 
            FROM tematicas
            INNER JOIN dimensiones
            ON tematicas.idDimension =  dimensiones.idDimension
            WHERE dimensiones.idConjuntoIndicadores= :idConjunto 
            AND dimensiones.idDimension= :idDimension 
            AND tematicas.idDimension LIKE 'mc%' ");
        $stmt->bindParam(":idConjunto", $idConjunto, PDO::PARAM_STR);
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        $resp[] = $stmt->fetchAll();

        return $resp;
    }

}
