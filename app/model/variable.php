<?php

require_once 'connection.php';

class Variable extends Connection {

    public function crearVariable($idVariable, $nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida, $idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO variables '
                . 'VALUES(:idVariable, :nombreVariable,:tipoDato, '
                . ':tipoZonaGeografica, :zonaGeografica, :periodicidad, :entidadCompiladora, '
                . ':fuenteDatos, :urlFuenteDatos, :desagregacionTematica, '
                . ':notas, :unidadMedida, :idConjuntoIndicadores)');
        $stmt->bindValue(':idVariable', $idVariable);
        $stmt->bindValue(':nombreVariable', $nombreVariable);
        $stmt->bindValue(':tipoDato', $tipoDato);
        $stmt->bindValue(':tipoZonaGeografica', $tipoZonaGeografica);
        $stmt->bindValue(':zonaGeografica', $zonaGeografica);
        $stmt->bindValue(':periodicidad', $periodicidad);
        $stmt->bindValue(':entidadCompiladora', $entidadCompiladora);
        $stmt->bindValue(':fuenteDatos', $fuenteDatos);
        $stmt->bindValue(':urlFuenteDatos', $urlFuenteDatos);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->bindValue(':notas', $notas);
        $stmt->bindValue(':unidadMedida', $unidadMedida);
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            return "Error al crear la variable";
        }
    }

    public function listarVariables() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM variables");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarVariable($idVariable) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM variables "
                . "WHERE idVariable = :idVariable");
        $stmt->bindParam(":idVariable", $idVariable, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function idVariableExiste($idVariable) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM variables "
                . "WHERE idVariable = :idVariable");
        $stmt->bindParam(":idVariable", $idVariable, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreVariableExiste($nombreVariable, $idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM variables "
                . "WHERE nombreVariable = :nombreVariable "
                . "AND idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":nombreVariable", $nombreVariable, PDO::PARAM_STR);
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarVariable($idVariable, $nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE variables '
                . 'SET nombreVariable = :nombreVariable , '
                . 'tipoDato = :tipoDato, '
                . 'tipoZonaGeografica = :tipoZonaGeografica, '
                . 'zonaGeografica = :zonaGeografica, '
                . 'periodicidad = :periodicidad, '
                . 'entidadCompiladora = :entidadCompiladora, '
                . 'fuenteDatos = :fuenteDatos, '
                . 'urlFuenteDatos = :urlFuenteDatos, '
                . 'desagregacionTematica = :desagregacionTematica, '
                . 'notas = :notas, '
                . 'unidadMedida = :unidadMedida '
                . 'WHERE variables.idVariable = :idVariable');
        $stmt->bindValue(':idVariable', $idVariable);
        $stmt->bindValue(':nombreVariable', $nombreVariable);
        $stmt->bindValue(':tipoDato', $tipoDato);
        $stmt->bindValue(':tipoZonaGeografica', $tipoZonaGeografica);
        $stmt->bindValue(':zonaGeografica', $zonaGeografica);
        $stmt->bindValue(':periodicidad', $periodicidad);
        $stmt->bindValue(':entidadCompiladora', $entidadCompiladora);
        $stmt->bindValue(':fuenteDatos', $fuenteDatos);
        $stmt->bindValue(':urlFuenteDatos', $urlFuenteDatos);
        $stmt->bindValue(':desagregacionTematica', $desagregacionTematica);
        $stmt->bindValue(':notas', $notas);
        $stmt->bindValue(':unidadMedida', $unidadMedida);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la variable";
        }
    }

    public function eliminarVariable($idVariable) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM variables '
                . 'WHERE idVariable = :idVariable');
        $stmt->bindValue(':idVariable', $idVariable);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function consultarIdVariables() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idVariable "
                . "FROM variables "
                . "ORDER BY idVariable ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarVariablesPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idVariable) "
                . "FROM variables "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function listarVariablesPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM variables "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "ORDER BY variables.nombreVariable ASC");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarDatosPorIdVariable($idVariable) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datosvariables "
                . "WHERE idVariable = :idVariable "
                . "ORDER BY fechaDatoVariable ASC");
        $stmt->bindValue(':idVariable', $idVariable);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function existeDatoVariable($idVariable, $fechaDato) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datosVariables "
                . "WHERE idVariable = :idVariable "
                . "AND fechaDatoVariable = :fechaDatoVariable");
        $stmt->bindParam(":idVariable", $idVariable, PDO::PARAM_STR);
        $stmt->bindParam(":fechaDatoVariable", $fechaDato, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function crearDatoVariable($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idVariable) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO datosvariables '
                . 'VALUES(:idDatoVariable, :fechaDatoVariable, :valorDatoVariable, :idVariable, '
                . ':estadoObservacionDatoVariable)');
        $stmt->bindValue(':idDatoVariable', $idDato);
        $stmt->bindValue(':fechaDatoVariable', $fechaDato);
        $stmt->bindValue(':valorDatoVariable', $valorDato);
        $stmt->bindValue(':idVariable', $idVariable);
        $stmt->bindValue(':estadoObservacionDatoVariable', $estadoObservacionDato);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el dato";
        }
    }

    public function editarDatoVariable($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idVariable) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE datosvariables '
                . 'SET valorDatoVariable = :valorDato, '
                . 'estadoObservacionDatoVariable = :estadoObservacionDato '
                . 'WHERE datosVariables.idDatoVariable = :idDato '
                . 'AND datosVariables.fechaDatoVariable = :fechaDato '
                . 'AND datosVariables.idVariable = :idVariable');
        $stmt->bindValue(':valorDato', $valorDato);
        $stmt->bindValue(':estadoObservacionDato', $estadoObservacionDato);
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':idVariable', $idVariable);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el dato";
        }
    }

    public function eliminarDatoVariable($idDato, $fechaDato, $idVariable) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM datosVariables '
                . 'WHERE datosVariables.idDatoVariable = :idDato '
                . 'AND datosVariables.fechaDatoVariable = :fechaDato '
                . 'AND datosVariables.idVariable = :idVariable');
        $stmt->bindValue(':idDato', $idDato);
        $stmt->bindValue(':fechaDato', $fechaDato);
        $stmt->bindValue(':idVariable', $idVariable);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return "Error al eliminar el dato";
        }
    }

}
