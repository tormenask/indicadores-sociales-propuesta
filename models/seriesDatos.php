<?php

require_once 'connection.php';

class SeriesDatos extends Connection {

    public function consultarComunasCorregimientosPorSistemaIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare("SELECT DISTINCT zonaActual "
                . "FROM seriedatos  "
                . "WHERE (tipoZonaGeografica = 'Comuna' or tipoZonaGeografica = 'Corregimiento') "
                . "AND idSerieDatos LIKE CONCAT ('%',:idConjuntoIndicadores,'%') "
                . "ORDER by zonaGeografica, tipoZonaGeografica ASC");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarComunasCorregimientosPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE tipoZonaGeografica = 'Comuna' "
                . "AND idIndicador = :idIndicador "
                . "ORDER BY tipoZonaGeografica, LPAD(lower(zonaGeografica), 10,0) ASC");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarComunasCorregimientosPorIndicadorLimit($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE (tipoZonaGeografica = 'Comuna' or tipoZonaGeografica = 'Corregimiento') "
                . "AND idIndicador =:idIndicador "
                . "ORDER BY tipoZonaGeografica, LPAD(lower(zonaGeografica), 10,0) ASC "
                . "LIMIT 1 ");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesGeograficasPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE tipoZonaGeografica != 'Comuna' "
                . "AND tipoZonaGeografica != 'Corregimiento' "
                . "AND idIndicador =:idIndicador "
                . "ORDER BY idSerieDatos ASC");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesGeograficasPorIndicadorYFuente($idIndicador, $fuenteDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE tipoZonaGeografica != 'Comuna' "
                . "AND tipoZonaGeografica != 'Corregimiento' "
                . "AND idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "ORDER BY LPAD(lower(zonaGeografica), 10,0) ASC");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuenteDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesGeograficasPorIndicadorTotal($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "ORDER BY LPAD(lower(zonaGeografica), 10,0) ASC");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteCali($idIndicador, $fuente) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT "
                . "desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND zonaGeografica = 'Cali'");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuente($idIndicador, $fuenteDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND (seriedatos.tipoZonaGeografica = 'Municipal' || seriedatos.tipoZonaGeografica = 'Departamental' || seriedatos.tipoZonaGeografica = 'Nacional')");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuenteDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYDesagregacionesGeograficas($idIndicador, $desagregacionGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = :zonaGeografica "
                . "ORDER BY desagregacionTematica DESC");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $desagregacionGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorDesagregacionesGeograficasYFuente($idIndicador, $desagregacionGeografica, $fuenteDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = :zonaGeografica "
                . "AND fuenteDatos = :fuenteDatos");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $desagregacionGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuenteDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteComparativos($idIndicador, $fuente) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND (seriedatos.tipoZonaGeografica!='Comuna' AND seriedatos.tipoZonaGeografica!='Corregimiento') "
                . "AND tipoDato != 'Dato oficial' "
                . "ORDER BY desagregacionTematica DESC LIMIT 1");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteComparativosRegionales($idIndicador, $fuente) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM serieDatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND tipoDato != 'Dato oficial' "
                . "AND (seriedatos.tipoZonaGeografica!='Comuna' AND seriedatos.tipoZonaGeografica!='Corregimiento') "
                . "ORDER BY desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteComunasCorregimientos($idIndicador, $fuente) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND (seriedatos.tipoZonaGeografica = 'Comuna' OR seriedatos.tipoZonaGeografica = 'Corregimiento')");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentesPorIndicadorCali($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = 'Cali'");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentesPorIndicadorComunasCorregimientos($idIndicador, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND (tipoZonaGeografica = 'Comuna' or tipoZonaGeografica = 'Corregimiento') "
                . "AND zonaGeografica = :zonaGeografica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentesComunasCorregimientos($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND (tipoZonaGeografica = 'Comuna' or tipoZonaGeografica = 'Corregimiento')");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentesPorIndicadorComparativos($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND (tipoZonaGeografica != 'Comuna' AND tipoZonaGeografica != 'Corregimiento') "
                . "AND tipoDato != 'Dato oficial'");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentesPorIndicadorDiferenteComunas($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND (tipoZonaGeografica != 'Comuna' AND tipoZonaGeografica != 'Corregimiento') ");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionCali($idIndicador, $fuente, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND zonaGeografica = 'Cali'");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorDesGeoDesTemExp($idIndicador, $desagregacionGeografica, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = :zonaGeografica "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $desagregacionGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionMunicipal($idIndicador, $fuente, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND (tipoZonaGeografica = 'Municipal' || tipoZonaGeografica = 'Departamental' || tipoZonaGeografica = 'Nacional') "
                . "ORDER BY cast(zonaGeografica as unsigned)");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionComparativos1($idIndicador, $fuente, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND (tipoZonaGeografica != 'Comuna' AND tipoZonaGeografica != 'Corregimiento') "
                . "AND tipoDato != 'Dato oficial' "
                . "ORDER BY cast(zonaGeografica as unsigned)");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregaciones($idIndicador, $fuente, $desagregacionTematica, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND zonaGeografica = :zonaGeografica "
                . "ORDER BY desagregacionTematica DESC");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionComparativos($idIndicador, $fuente, $desagregacionTematica, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND (tipoZonaGeografica != 'Comuna' AND tipoZonaGeografica != 'Corregimiento') "
                . "AND zonaGeografica = :zonaGeografica ");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionComunasCorregimientos($idIndicador, $fuente, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND (tipoZonaGeografica = 'Comuna' OR tipoZonaGeografica = 'Corregimiento')"
                . "ORDER BY cast(zonaGeografica as unsigned)");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionComunasPerfiles($idIndicador, $fuente, $desagregacionTematica, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND zonaGeografica = :zonaGeografica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionTematicaGeograficaComunasCorregimientos($idIndicador, $fuente, $desagregacionTematica, $comuna) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "AND zonaGeografica = :zonaGeografica ORDER BY cast(zonaGeografica as unsigned)");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $comuna, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarEntidadGeneradoraSeriePorIdSerie($idSerie) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT entidadCompiladora "
                . "FROM seriedatos "
                . "WHERE idSerieDatos = :idSerieDatos");
        $stmt->bindParam("idSerieDatos", $idSerie, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarNotasSeriePorIdSerie($idSerie) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT notas "
                . "FROM seriedatos "
                . "WHERE idSerieDatos = :idSerieDatos");
        $stmt->bindParam("idSerieDatos", $idSerie, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarUnidadMedidaSeriePorIdIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT unidadMedida "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam("idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarPeriodicidadSeriePorIdIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT periodicidad "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam("idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarFuenteSeriePorIdIndicadorZonaGeografica($idIndicador, $tipoZonaGeografica) {
        $stmt = "";
        if ($tipoZonaGeografica !== 'Comunas' && $tipoZonaGeografica !== 'ODRAF') {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT DISTINCT fuenteDatos "
                    . "FROM seriedatos "
                    . "WHERE idIndicador = :idIndicador "
                    . "AND tipoZonaGeografica != 'Comuna'");
            $stmt->bindParam("idIndicador", $idIndicador, PDO::PARAM_STR);
        } elseif ($tipoZonaGeografica == 'ODRAF') {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT DISTINCT fuenteDatos "
                    . "FROM seriedatos "
                    . "WHERE idIndicador = :idIndicador");
            $stmt->bindParam("idIndicador", $idIndicador, PDO::PARAM_STR);
        } else {
            $stmt = Connection::connect()->prepare(""
                    . "SELECT DISTINCT fuenteDatos "
                    . "FROM seriedatos "
                    . "WHERE idIndicador = :idIndicador "
                    . "AND tipoZonaGeografica = 'Comuna'");
            $stmt->bindParam("idIndicador", $idIndicador, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarFuentePorIdIndicadorZonaGeograficaYFuenteInicial($idIndicador, $zonaGeografica, $fuenteInicial) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = :zonaGeografica "
                . "AND fuenteDatos= :fuenteDatos");
        $stmt->bindParam("idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam("zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->bindParam("fuenteDatos", $fuenteInicial, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarDesagregacionesGeograficasPorFuenteYDesagregacion($idIndicador, $fuente, $desagregacion) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica ");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacion, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesGeograficasPorFuenteYDesagregacionComparativos($idIndicador, $fuente, $desagregacion) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica ");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacion, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentesPorIndicadorGlobalesCiudad($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteGlobalesCiudad($idIndicador, $fuente) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos ");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionGlobalesCiudad($idIndicador, $fuente, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorGeografiaZonaActualDesagregacionTematica($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica = :tipoZonaGeografica "
                . "AND zonaGeografica = :zonaGeografica "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":tipoZonaGeografica", $tipoZonaGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorGeografiaZonaActualDesagregacionTematicaExpediente($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica = :tipoZonaGeografica "
                . "AND zonaGeografica = :zonaGeografica "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":tipoZonaGeografica", $tipoZonaGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIndicadorDesagregacionGeograficaYDesagregacionTematicaExpediente($idIndicador, $desagregacionGeografica, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaActual = :desagregacionGeografica "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionGeografica", $desagregacionGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYFuenteExp($idIndicador, $fuente) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "ORDER BY desagregacionTematica DESC LIMIT 1");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIdSeriePorIndicadorFuenteYDesagregacionExp($idIndicador, $fuente, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos "
                . "AND desagregacionTematica = :desagregacionTematica "
                . "ORDER BY cast(zonaGeografica as unsigned)");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuente, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYDesagregacionGeograficaExp($idIndicador, $desagregacionGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = :zonaGeografica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $desagregacionGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorYDesagregacionGeografica($idIndicador, $desagregacionGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = :zonaGeografica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $desagregacionGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorTipoZonaZonaExp($idIndicador, $tipoZonaGeografica, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica = :tipoZonaGeografica "
                . "AND zonaGeografica = :zonaGeografica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":tipoZonaGeografica", $tipoZonaGeografica, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorZonaGeografica($idIndicador, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND zonaGeografica = :zonaGeografica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":zonaGeografica", $zonaGeografica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarGeografiasPorIndicadorExpediente($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tipoZonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionGeograficaPorIndicadorExpediente($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarZonaActualPorIndicadorGeografiaExpediente($idIndicador, $tipoZonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica=:tipoZonaGeografica "
                . "ORDER BY length(zonaGeografica),zonaGeografica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":tipoZonaGeografica", $tipoZonaGeografica
                , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarGeografiaZonaActualPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT tipoZonaGeografica, zonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIdIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIdIndicadorDesagregacionTematica($idIndicador, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":desagregacionTematica", $desagregacionTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarDesagregacionesTematicasPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentePorIdSerie($idSerieDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idSerieDatos = :idSerieDatos");
        $stmt->bindParam(":idSerieDatos", $idSerieDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarUnidadMedidaPorIdSerie($idSerieDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT unidadMedida "
                . "FROM seriedatos "
                . "WHERE idSerieDatos = :idSerieDatos");
        $stmt->bindParam(":idSerieDatos", $idSerieDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function consultarSeriePorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT  * "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "ORDER BY desagregacionTematica");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
