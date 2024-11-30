<?php

require_once 'connection.php';

class SerieDatos extends Connection {

    public function crearSerieDatos($idSerieDatos, $nombreUnicoSerie, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicador) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO seriedatos '
                . 'VALUES(:idSerieDatos, :nombreUnicoSerie,:tipoDato, '
                . ':tipoZonaGeografica, :zonaGeografica, :periodicidad, :entidadCompiladora, '
                . ':fuenteDatos, :urlFuenteDatos, :desagregacionTematica, '
                . ':notas, :unidadMedida, :numeroConsultas, :idIndicador)');
        $stmt->bindValue(':idSerieDatos', $idSerieDatos);
        $stmt->bindValue(':nombreUnicoSerie', $nombreUnicoSerie);
        $stmt->bindValue(':tipoDato', $tipoDato);
        $stmt->bindValue(':tipoZonaGeografica', $geografia);
        $stmt->bindValue(':zonaGeografica', $zonaActual);
        $stmt->bindValue(':periodicidad', $periodicidad);
        $stmt->bindValue(':entidadCompiladora', $entidadGeneradora);
        $stmt->bindValue(':fuenteDatos', $fuenteDatos);
        $stmt->bindValue(':urlFuenteDatos', $urlDatos);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->bindValue(':notas', $notas);
        $stmt->bindValue(':unidadMedida', $unidadMedicion);
        $stmt->bindValue(':numeroConsultas', $numeroConsultas);
        $stmt->bindValue(':idIndicador', $idIndicador);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            return "Error al crear la serie";
        }
    }

    public function listarSeriesDatos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarSerieDatos($idSerieDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos "
                . "WHERE idSerieDatos = :idSerieDatos");
        $stmt->bindParam(":idSerieDatos", $idSerieDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function idSerieDatosExiste($idSerieDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos "
                . "WHERE idSerieDatos = :idSerieDatos");
        $stmt->bindParam(":idSerieDatos", $idSerieDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreUnicoSerieExiste($nombreUnicoSerie) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos "
                . "WHERE nombreUnicoSerie = :nombreUnicoSerie");
        $stmt->bindParam(":nombreUnicoSerie", $nombreUnicoSerie, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreUnicoSerieExisteIndicador($nombreUnicoSerie, $idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos "
                . "WHERE nombreUnicoSerie = :nombreUnicoSerie "
                . "AND idIndicador = :idIndicador");
        $stmt->bindParam(":nombreUnicoSerie", $nombreUnicoSerie, PDO::PARAM_STR);
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarSerieDatos($idSerieDatos, $nombreUnicoSerie, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE seriedatos '
                . 'SET nombreUnicoSerie = :nombreUnicoSerie , '
                . 'tipoDato = :tipoDato, '
                . 'tipoZonaGeografica = :tipoZonaGeografica, '
                . 'zonaGeografica = :zonaGeografica, '
                . 'periodicidad = :periodicidad, '
                . 'entidadCompiladora = :entidadCompiladora, '
                . 'fuenteDatos = :fuenteDatos, '
                . 'urlFuenteDatos = :urlFuenteDatos, '
                . 'desagregacionTematica = :desagregacionTematica, '
                . 'notas= :notas, '
                . 'unidadMedida = :unidadMedida '
                . 'WHERE seriedatos.idSerieDatos = :idSerieDatos');
        $stmt->bindValue(':idSerieDatos', $idSerieDatos);
        $stmt->bindValue(':nombreUnicoSerie', $nombreUnicoSerie);
        $stmt->bindValue(':tipoDato', $tipoDato);
        $stmt->bindValue(':tipoZonaGeografica', $geografia);
        $stmt->bindValue(':zonaGeografica', $zonaActual);
        $stmt->bindValue(':periodicidad', $periodicidad);
        $stmt->bindValue(':entidadCompiladora', $entidadGeneradora);
        $stmt->bindValue(':fuenteDatos', $fuenteDatos);
        $stmt->bindValue(':urlFuenteDatos', $urlDatos);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->bindValue(':notas', $notas);
        $stmt->bindValue(':unidadMedida', $unidadMedicion);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la serie";
        }
    }

    public function eliminarSerieDatos($idSerieDatos) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM serieDatos '
                . 'WHERE idSerieDatos = :idSerieDatos');
        $stmt->bindValue(':idSerieDatos', $idSerieDatos);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }
    
    public function serieDatosTieneDatos($idSerieDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * FROM datos "
                . "WHERE idSerieDatos = :idSerieDatos");
        $stmt->bindParam(":idSerieDatos", $idSerieDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeries() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idSerieDatos "
                . "FROM seriedatos "
                . "ORDER BY idSerieDatos ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdSeriePorIdIndicadorZonaTipoDesagregacionTematica($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica = :tipoZonaGeografica "
                . "AND zonaGeografica = :zonaGeografica "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':tipoZonaGeografica', $tipoZonaGeografica);
        $stmt->bindValue(':zonaGeografica', $zonaGeografica);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function contarSeries() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idSerieDatos) "
                . "FROM seriedatos");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function contarSeriesPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idSerieDatos) "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
     public function consultarUltimoId($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idSerieDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "ORDER by LENGTH (idSerieDatos) DESC , idSerieDatos DESC LIMIT 1 "
        );
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarTiposZonasGeograficasPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT tipoZonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "ORDER BY tipoZonaGeografica ASC");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarZonasGeograficasPorTipo($idIndicador, $tipoZonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT zonaGeografica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica = :tipoZonaGeografica "
                . "ORDER BY length(zonaGeografica),zonaGeografica");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':tipoZonaGeografica', $tipoZonaGeografica);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDesagregacionesTematicasPorIndicadorTipoZona($idIndicador, $tipoZonaGeografica, $zonaGeografica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT desagregacionTematica "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica = :tipoZonaGeografica "
                . "AND zonaGeografica = :zonaGeografica ");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':tipoZonaGeografica', $tipoZonaGeografica);
        $stmt->bindValue(':zonaGeografica', $zonaGeografica);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarFuentesPorIndicadorTipoZonaDesagregacion($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fuenteDatos "
                . "FROM seriedatos "
                . "WHERE idIndicador = :idIndicador "
                . "AND tipoZonaGeografica = :tipoZonaGeografica "
                . "AND zonaGeografica = :zonaGeografica "
                . "AND desagregacionTematica = :desagregacionTematica");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':tipoZonaGeografica', $tipoZonaGeografica);
        $stmt->bindValue(':zonaGeografica', $zonaGeografica);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarSeriesPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos, indicadores, tematicas, dimensiones "
                . "WHERE seriedatos.idIndicador = indicadores.idIndicador "
                . "AND indicadores.idTematica = tematicas.idTematica "
                . "AND tematicas.idDimension = dimensiones.idDimension "
                . "AND dimensiones.idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarSeriesPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM seriedatos "
                . "WHERE seriedatos.idIndicador = :idIndicador");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
