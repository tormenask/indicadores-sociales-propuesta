<?php

require_once 'connection.php';

class Indicadores extends Connection {

    public function consultarIndicadoresActivosPorNombre($nombreIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE MATCH(nombreIndicador) "
                . "AGAINST (CONCAT(:nombreIndicador, '*') IN BOOLEAN MODE) "
                . "AND activado = 1 "
                . "ORDER BY nombreIndicador ASC");
        $stmt->bindParam(":nombreIndicador", $nombreIndicador, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $count = count($result);
        if ($count > 0) {
            return $result;
        } else {
            return "empty";
        }
    }

    public function consultarIndicadoresPorNombreExacto($nombreIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE nombreIndicador = :nombreIndicador");
        $stmt->bindParam(":nombreIndicador", $nombreIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIndicadoresActivosPorIdTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE indicadores.idTematica = :idTematica "
                . "AND indicadores.activado = 1 "
                . "ORDER BY indicadores.posicion, indicadores.nombreIndicador ASC");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresActivosPorTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT indicadores.idIndicador, indicadores.nombreIndicador "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE indicadores.idTematica = :idTematica "
                . "AND indicadores.activado = 1 "
                . "AND indicadores.idIndicador=seriedatos.idIndicador "
                . "AND seriedatos.tipoZonaGeografica != 'Comuna' "
                . "AND seriedatos.tipoZonaGeografica != 'Corregimiento' "
                . "ORDER BY indicadores.posicion, indicadores.nombreIndicador ASC");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresActivosPorTematicaTotal($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT indicadores.idIndicador, indicadores.nombreIndicador "
                . "FROM tematicas, indicadores, seriedatos "
                . "WHERE indicadores.idTematica = :idTematica "
                . "AND indicadores.activado = 1 "
                . "AND indicadores.idIndicador = seriedatos.idIndicador "
                . "ORDER BY indicadores.posicion, indicadores.nombreIndicador ASC");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadorPorId($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarMapaIndicadorPorId($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT mapa "
                . "FROM indicadores WHERE "
                . "idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()['mapa'];
    }

    public function consultarNombreIndicadorPorId($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreIndicador "
                . "FROM indicadores "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()['nombreIndicador'];
    }

    public function consultarIndicadoresActivosPorTematicaComunasCorregimientos($idTematica) {
        $stmt = Connection::connect()->prepare("
            SELECT DISTINCT indicadores.idIndicador, indicadores.nombreIndicador 
            FROM tematicas, indicadores, seriedatos 
            WHERE indicadores.idTematica=:idTematica 
            AND indicadores.activado = 1 
            AND indicadores.idIndicador = seriedatos.idIndicador 
            AND (seriedatos.tipoZonaGeografica = 'Comuna' OR seriedatos.tipoZonaGeografica = 'Corregimiento')");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresSisPorTematicaYZonaActualComunasCorregimientos($idTematica, $zonaGeografica) {
        $stmt = Connection::connect()->prepare("
            SELECT DISTINCT indicadores.idIndicador, indicadores.nombreIndicador 
            FROM tematicas, indicadores, seriedatos 
            WHERE indicadores.idTematica = :idTematica
            AND indicadores.idIndicador = seriedatos.idIndicador 
            AND (seriedatos.tipoZonaGeografica = 'Comuna' OR seriedatos.tipoZonaGeografica = 'Corregimiento') 
            AND seriedatos.zonaGeografica = :zonaGeografica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresSisPorTematicaComparativos($idTematica) {
        $stmt = Connection::connect()->prepare("
            SELECT DISTINCT indicadores.idIndicador, indicadores.nombreIndicador 
            FROM tematicas, indicadores, seriedatos 
            WHERE indicadores.idTematica = :idTematica
            AND indicadores.idIndicador = seriedatos.idIndicador 
            AND (seriedatos.tipoZonaGeografica != 'Comuna' AND seriedatos.tipoZonaGeografica != 'Corregimiento') 
            AND seriedatos.zonaGeografica != 'Cali'");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresIGCPorTematica($idTematica) {
        $stmt = Connection::connect()->prepare("
            SELECT DISTINCT * 
            FROM indicadores 
            WHERE indicadores.idTematica = :idTematica 
            AND idTematica LIKE '%IGC%' 
            ORDER BY indicadores.nombreIndicador");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresExpPorTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT indicadores.idIndicador, indicadores.nombreIndicador "
                . "FROM indicadores "
                . "WHERE indicadores.idTematica = :idTematica "
                . "AND idTematica LIKE '%EXP%'");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarIndicadoresActivosPorIdTematica($idTematica, $categoria) {
        if ($categoria == 'Comuna') {
            $stmt = Connection::connect()->prepare("
                SELECT COUNT(DISTINCT indicadores.idIndicador) 
                FROM indicadores, seriedatos 
                WHERE indicadores.idTematica = :idTematica 
                AND indicadores.activado = 1 
                AND seriedatos.idIndicador = indicadores.idIndicador 
                AND (seriedatos.tipoZonaGeografica = 'Comuna' || seriedatos.tipoZonaGeografica = 'Corregimiento')");
            $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } elseif ($categoria == 'Municipal') {
            $stmt = Connection::connect()->prepare("
                SELECT COUNT(DISTINCT indicadores.idIndicador) 
                FROM indicadores, seriedatos 
                WHERE indicadores.idTematica = :idTematica 
                AND indicadores.activado = 1 
                AND seriedatos.idIndicador = indicadores.idIndicador 
                AND seriedatos.tipoZonaGeografica != 'Comuna' 
                AND seriedatos.tipoZonaGeografica != 'Corregimiento'");
            $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } elseif ($categoria == 'Total') {
            $stmt = Connection::connect()->prepare("
                SELECT COUNT(DISTINCT indicadores.idIndicador) 
                FROM indicadores, seriedatos 
                WHERE indicadores.idTematica = :idTematica 
                AND indicadores.activado = 1 
                AND seriedatos.idIndicador = indicadores.idIndicador");
            $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        }
    }
    
      public function listarIndicadoresDadii($idConjunto) {
       $stmt = Connection::connect()->prepare(""
               . "SELECT indicadores.idIndicador, indicadores.nombreIndicador FROM indicadores 
                   INNER JOIN tematicas ON indicadores.idTematica = tematicas.idTematica 
                   INNER JOIN dimensiones ON tematicas.idDimension =  dimensiones.idDimension 
                   WHERE dimensiones.idConjuntoIndicadores= :idConjunto 
                   AND indicadores.activado = 1
                   ORDER BY indicadores.posicion  ASC");
       $stmt->bindParam(":idConjunto", $idConjunto, PDO::PARAM_STR);
       $stmt->execute();
       return $stmt->fetchAll();
   }
    
     public function contarIndicadoresDadii($idConjunto) {
       $stmt = Connection::connect()->prepare(""
               . "SELECT COUNT(indicadores.idIndicador) FROM indicadores 
                   INNER JOIN tematicas ON indicadores.idTematica = tematicas.idTematica 
                   INNER JOIN dimensiones ON tematicas.idDimension =  dimensiones.idDimension 
                   WHERE dimensiones.idConjuntoIndicadores= :idConjunto 
                   AND indicadores.activado = 1
                   ORDER BY indicadores.posicion  ASC");
       $stmt->bindParam(":idConjunto", $idConjunto, PDO::PARAM_STR);
       $stmt->execute();
       return $stmt->fetch();
   }

    public function consultarInformacionEnlacePorIdIndicadorYGeografia($idIndicador, $categoria) {
        if ($categoria == "Comuna") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador, seriedatos.fuenteDatos "
                    . "FROM dimensiones, tematicas, indicadores, seriedatos "
                    . "WHERE indicadores.idIndicador = :idIndicador "
                    . "AND dimensiones.idDimension = tematicas.idDimension "
                    . "AND tematicas.idTematica = indicadores.idTematica "
                    . "AND indicadores.idIndicador = seriedatos.idIndicador "
                    . "AND (seriedatos.tipoZonaGeografica = 'Comuna'||seriedatos.tipoZonaGeografica = 'Corregimiento')");
            $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } elseif ($categoria == "Municipal") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador, seriedatos.fuenteDatos, seriedatos.tipoZonaGeografica, seriedatos.zonaGeografica "
                    . "FROM dimensiones, tematicas, indicadores, seriedatos "
                    . "WHERE indicadores.idIndicador = :idIndicador "
                    . "AND dimensiones.idDimension = tematicas.idDimension "
                    . "AND tematicas.idTematica = indicadores.idTematica "
                    . "AND indicadores.idIndicador = seriedatos.idIndicador "
                    . "AND seriedatos.tipoZonaGeografica != 'Comuna' "
                    . "AND seriedatos.tipoZonaGeografica != 'Corregimiento'");
            $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } elseif ($categoria == "Exp") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT DISTINCT dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador, seriedatos.tipoZonaGeografica, seriedatos.zonaGeografica "
                    . "FROM dimensiones, tematicas, indicadores, seriedatos "
                    . "WHERE indicadores.idIndicador = :idIndicador "
                    . "AND dimensiones.idDimension = tematicas.idDimension "
                    . "AND tematicas.idTematica = indicadores.idTematica "
                    . "AND indicadores.idIndicador = seriedatos.idIndicador");
            $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        } elseif ($categoria == "Total") {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT dimensiones.idDimension, tematicas.idTematica, indicadores.idIndicador, seriedatos.fuenteDatos, seriedatos.tipoZonaGeografica, seriedatos.zonaGeografica "
                    . "FROM dimensiones, tematicas, indicadores, seriedatos "
                    . "WHERE indicadores.idIndicador = :idIndicador "
                    . "AND dimensiones.idDimension = tematicas.idDimension "
                    . "AND tematicas.idTematica = indicadores.idTematica "
                    . "AND indicadores.idIndicador = seriedatos.idIndicador");
            $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch();
        }
    }

    public function indicadorTieneNombreYId($idIndicador,$nombreIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE idIndicador Like '$idIndicador%' "
                . "AND nombreIndicador = :nombreIndicador");
        $stmt->bindParam(":nombreIndicador", $nombreIndicador);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function consultar5ndicadoresMasBuscados() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "ORDER BY numeroConsultas DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function adicionarNumeroDeVisita($idIndicador,$numeroConsultas) {
        $stmt = Connection::connect()->prepare(''
            . 'UPDATE indicadores '
            . 'SET numeroConsultas = :numeroConsultas '
            . 'WHERE idIndicador= :idIndicador');
        $stmt->bindValue(':numeroConsultas', $numeroConsultas);
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->execute();
    }    

}
