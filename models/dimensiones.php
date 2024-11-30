<?php

require_once 'connection.php';

class Dimensiones extends Connection {

    public function consultarDimensionPorId($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE idDimension = :idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarNombreDimensionPorId($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT dimensiones.nombreDimension "
                . "FROM dimensiones "
                . "WHERE idDimension = :idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        $nombreDimension = $stmt->fetch()['nombreDimension'];
        return $nombreDimension;
    }
    
     public function listarDimensionesPorConjunto($idConjunto) {
        $stmt = Connection::connect()->prepare("SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores=:idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
        
    }

    public function consultarDimensionesPorConjuntoIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "ORDER BY posicion, nombreDimension ASC");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDimensionesParaComunasCorregimientosPorConjuntoIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT dimensiones.nombreDimension, dimensiones.idDimension, dimensiones.idConjuntoIndicadores, dimensiones.posicion, dimensiones.icono, dimensiones.color "
                . "FROM dimensiones, tematicas, indicadores, seriedatos "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "AND dimensiones.idDimension = tematicas.idDimension "
                . "AND tematicas.idTematica = indicadores.idTematica "
                . "AND indicadores.idIndicador = seriedatos.idIndicador "
                . "AND (seriedatos.tipoZonaGeografica = 'Comuna' OR seriedatos.tipoZonaGeografica = 'Corregimiento')");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDimensionesParaComparativosPorConjuntoIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare("SELECT DISTINCT dimensiones.nombreDimension, dimensiones.idDimension "
                . "FROM dimensiones, tematicas, indicadores, seriedatos "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "AND dimensiones.idDimension = tematicas.idDimension "
                . "AND tematicas.idTematica = indicadores.idTematica "
                . "AND indicadores.idIndicador = seriedatos.idIndicador "
                . "AND (seriedatos.tipoZonaGeografica != 'Comuna' AND seriedatos.tipoZonaGeografica != 'Corregimiento') "
                . "AND seriedatos.zonaGeografica != 'Cali'");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDimensionesPorSistemaIndicadoresGlobalesCiudad($idConjuntoIndicadores) {

        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT dimensiones.nombreDimension, dimensiones.idDimension "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores ");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDimensionesPorSistemaIndicadoresExpediente($idConjuntoIndicadores) {

        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT dimensiones.nombreDimension, dimensiones.idDimension "
                . "FROM dimensiones, tematicas, indicadores, seriedatos "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "AND dimensiones.idDimension=tematicas.idDimension "
                . "AND tematicas.idTematica = indicadores.idTematica "
                . "AND indicadores.idIndicador = seriedatos.idIndicador ");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function listarDimensionesPorMacroproceso($idConjunto) {
        $resp = array();
        $stmt = Connection::connect()->prepare("SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores=:idConjuntoIndicadores "
                . "AND idDimension LIKE 'me%' ");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        $resp[]=$stmt->fetchAll();
//        return $estrategico;
        
        $stmt = Connection::connect()->prepare("SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores=:idConjuntoIndicadores "
                . "AND idDimension LIKE 'mm%' ");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        $resp[]=$stmt->fetchAll();
//        return $misional;
        
        $stmt = Connection::connect()->prepare("SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores=:idConjuntoIndicadores "
                . "AND idDimension LIKE 'ma%' ");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        $resp[]=$stmt->fetchAll();
//        return $apoyo;
        
        $stmt = Connection::connect()->prepare("SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores=:idConjuntoIndicadores "
                . "AND idDimension LIKE 'mc%' ");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        $resp[]=$stmt->fetchAll();
//        return $control;        
        return $resp;        
    }

}
