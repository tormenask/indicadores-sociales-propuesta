<?php

require_once 'connection.php';

class ConjuntoIndicadores extends Connection {

    public function crearConjuntoIndicadores($idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO conjuntosindicadores '
                . 'VALUES(:idConjuntoIndicadores, :nombreConjuntoIndicadores, :descripcionConjuntoIndicadores, :idOrganismoConjuntoIndicadores)');
        $stmt->bindValue(':idConjuntoIndicadores', $idConjunto);
        $stmt->bindValue(':nombreConjuntoIndicadores', $nombreConjunto);
        $stmt->bindValue(':descripcionConjuntoIndicadores', $descripcionConjunto);
        $stmt->bindValue(':idOrganismoConjuntoIndicadores', $idOrganismoConjunto);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el conjunto de indicadores";
        }
    }

    public function listarConjuntosIndicadores() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM conjuntosindicadores "
                . "ORDER BY nombreConjuntoIndicadores ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarConjuntoIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM conjuntosindicadores "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarNombreConjuntoIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreConjuntoIndicadores "
                . "FROM conjuntosindicadores "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["nombreConjuntoIndicadores"];
    }

    public function idConjuntoExiste($idConjunto) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM conjuntosindicadores "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarConjunto($idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE conjuntosindicadores '
                . 'SET nombreConjuntoIndicadores = :nombreConjuntoIndicadores, '
                . 'descripcionConjuntoIndicadores = :descripcionConjuntoIndicadores, '
                . 'idOrganismoConjuntoIndicadores = :idOrganismoConjuntoIndicadores '
                . 'WHERE idConjuntoIndicadores = :idConjuntoIndicadores');
        $stmt->bindValue(':nombreConjuntoIndicadores', $nombreConjunto);
        $stmt->bindValue(':descripcionConjuntoIndicadores', $descripcionConjunto);
        $stmt->bindValue(':idOrganismoConjuntoIndicadores', $idOrganismoConjunto);
        $stmt->bindValue(':idConjuntoIndicadores', $idConjunto);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el conjunto";
        }
    }

    public function eliminarConjunto($idConjunto) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM conjuntosindicadores '
                . 'WHERE idConjuntoIndicadores = :idConjuntoIndicadores');
        $stmt->bindValue(':idConjuntoIndicadores', $idConjunto);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }
    
    public function conjuntoTieneDimension($idConjunto) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdConjuntosIndicadores() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idConjuntoIndicadores "
                . "FROM conjuntosindicadores "
                . "ORDER BY idConjuntoIndicadores ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarConjuntosIndicadores() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idConjuntoIndicadores) "
                . "FROM conjuntosindicadores");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}
