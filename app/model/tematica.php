<?php

require_once 'connection.php';

class Tematica extends Connection {

    public function crearTematica($idTematica, $nombreTematica, $descripcionTematica, $idDimension, $posicion) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO tematicas '
                . 'VALUES(:idTematica, :nombreTematica, :descripcionTematica, :idDimension,:posicion)');
        $stmt->bindValue(':idTematica', $idTematica);
        $stmt->bindValue(':nombreTematica', $nombreTematica);
        $stmt->bindValue(':descripcionTematica', $descripcionTematica);
        $stmt->bindValue(':idDimension', $idDimension);
        $stmt->bindValue(':posicion', $posicion);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            return "Error al crear la tematica";
        }
    }

    public function listarTematicas() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE idTematica = :idTematica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarNombreTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreTematica "
                . "FROM tematicas "
                . "WHERE idTematica = :idTematica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["nombreTematica"];
    }

    public function idTematicaExiste($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE idTematica = :idTematica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreTematicaExiste($nombreTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE nombreTematica = :nombreTematica");
        $stmt->bindParam(":nombreTematica", $nombreTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreTematicaExisteDimension($nombreTematica, $idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE nombreTematica = :nombreTematica "
                . "AND idDimension = :idDimension");
        $stmt->bindParam(":nombreTematica", $nombreTematica, PDO::PARAM_STR);
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarTematica($idTematica, $nombreTematica, $descripcionTematica, $posicion) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE tematicas '
                . 'SET nombreTematica = :nombreTematica, '
                . 'descripcionTematica = :descripcionTematica, '
                . 'posicion = :posicion '
                . 'WHERE idTematica = :idTematica');
        $stmt->bindValue(':nombreTematica', $nombreTematica);
        $stmt->bindValue(':descripcionTematica', $descripcionTematica);
        $stmt->bindValue(':idTematica', $idTematica);
        $stmt->bindValue(':posicion', $posicion);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la tematica";
        }
    }

    public function editarPosicion($nombreTematica, $posicion) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE tematicas '
                . 'SET posicion = :posicion '
                . 'WHERE nombreTematica = :nombreTematica');
        $stmt->bindValue(':nombreTematica', $nombreTematica);
        $stmt->bindValue(':posicion', $posicion);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la tematica";
        }
    }

    public function TematicaTieneIndicador($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE idTematica=:idTematica");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function eliminarTematica($idTematica) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM tematicas '
                . 'WHERE idTematica = :idTematica');
        $stmt->bindValue(':idTematica', $idTematica);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function consultarIdTematicas() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idTematica "
                . "FROM tematicas "
                . "ORDER BY idTematica ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarTematicas() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idTematica) "
                . "FROM tematicas");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function contarTematicasPorDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idTematica) "
                . "FROM tematicas "
                . "WHERE idDimension = :idDimension");
        $stmt->bindValue(':idDimension', $idDimension);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function consultarUltimoId($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idTematica "
                . "FROM tematicas "
                . "WHERE idDimension = :idDimension "
                . "ORDER by LENGTH (idTematica) DESC, idTematica DESC LIMIT 1 "
        );
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarTematicasPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT tematicas.idTematica, tematicas.nombreTematica, tematicas.idDimension,  tematicas.posicion, tematicas.descripcionTematica "
                . "FROM dimensiones, tematicas "
                . "WHERE tematicas.idDimension = dimensiones.idDimension "
                . "AND dimensiones.idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDimensionPorTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idDimension "
                . "FROM tematicas "
                . "WHERE idTematica = :idTematica");
        $stmt->bindValue(':idTematica', $idTematica);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarTematicasDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE idDimension = :idDimension "
                . "ORDER BY nombreTematica ASC");
        $stmt->bindValue(':idDimension', $idDimension);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
