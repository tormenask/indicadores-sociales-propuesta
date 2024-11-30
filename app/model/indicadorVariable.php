<?php

require_once 'connection.php';

class IndicadorVariable extends Connection {

    public function listarIndicadoresVariablesPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT * "
                . "FROM indicadoresvariables "
                . "WHERE idIndicador LIKE CONCAT ('%',:idConjuntoIndicadores,'%')"
                . "ORDER BY id ASC");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarRelacionesPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadoresvariables "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarRelacion($idIndV) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadoresvariables "
                . "WHERE id = :idIndV");
        $stmt->bindParam(":idIndV", $idIndV, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function crearRelacion($id, $idIndicador, $idVariable) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO indicadoresvariables '
                . 'VALUES(:id, :idIndicador, :idVariable)');
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':idVariable', $idVariable);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            var_dump($stmt->errorInfo());
            return "Error al crear la relación";
        }
    }

    public function idRelacionExiste($idIndV) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadoresvariables "
                . "WHERE id = :idIndV");
        $stmt->bindParam(":idIndV", $idIndV, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function eliminarRelacion($idIndV) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM '
                . 'indicadoresvariables '
                . 'WHERE id = :idIndV');
        $stmt->bindValue(':idIndV', $idIndV);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function editarRelacion($idIndV, $idIndicador, $idVariable) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadoresvariables '
                . 'SET idVariable = :idVariable '
                . 'WHERE id = :idIndV '
                . 'AND idIndicador = :idIndicador');
        $stmt->bindValue(':idVariable', $idVariable);
        $stmt->bindValue(':idIndV', $idIndV);
        $stmt->bindValue(':idIndicador', $idIndicador);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la relacion";
        }
    }

}
