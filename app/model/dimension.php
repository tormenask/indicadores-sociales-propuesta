<?php

require_once 'connection.php';

class Dimension extends Connection {

    public function crearDimension($idDimension, $nombreDimension, $descripcionDimension, $idConjuntoIndicadores, $posicion, $icono, $color) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO dimensiones '
                . 'VALUES(:idDimension, :nombreDimension, :descripcionDimension, :idConjuntoIndicadores, :posicion, :icono, :color ) ');
        $stmt->bindValue(':idDimension', $idDimension);
        $stmt->bindValue(':nombreDimension', $nombreDimension);
        $stmt->bindValue(':descripcionDimension', $descripcionDimension);
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->bindValue(':posicion', $posicion);
        $stmt->bindValue(':icono', $icono);
        $stmt->bindValue(':color', $color);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            return "Error al crear la dimensión";
        }
    }

    public function listarDimensiones() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE idDimension = :idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarNombreDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreDimension "
                . "FROM dimensiones "
                . "WHERE idDimension = :idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["nombreDimension"];
    }

    public function idDimensionExiste($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE idDimension = :idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function dimensionTieneTematica($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM tematicas "
                . "WHERE idDimension = :idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function nombreDimensionExiste($nombreDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE nombreDimension = :nombreDimension");
        $stmt->bindParam(":nombreDimension", $nombreDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreDimensionExisteConjunto($nombreDimension, $idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE nombreDimension = :nombreDimension "
                . "AND idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":nombreDimension", $nombreDimension, PDO::PARAM_STR);
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarDimIcono($icono) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT icono "
                . "FROM dimensiones "
                . "WHERE icono = :icono");
        $stmt->bindParam(":icono", $icono, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarUltimoId($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idDimension "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "ORDER by LENGTH (idDimension) DESC , idDimension DESC LIMIT 1"
        );
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarDimension($idDimension, $nombreDimension, $descripcionDimension, $posicion, $icono, $color) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE dimensiones '
                . 'SET nombreDimension = :nombreDimension, '
                . 'descripcionDimension = :descripcionDimension, '
                . 'posicion = :posicion, '
                . 'icono = :icono, '
                . 'color = :color '
                . 'WHERE idDimension = :idDimension');
        $stmt->bindValue(':nombreDimension', $nombreDimension);
        $stmt->bindValue(':descripcionDimension', $descripcionDimension);
        $stmt->bindValue(':idDimension', $idDimension);
        $stmt->bindValue(':posicion', $posicion);
        $stmt->bindValue(':icono', $icono);
        $stmt->bindValue(':color', $color);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la dimensión";
        }
    }

    public function editarDimensionSinIcono($idDimension, $nombreDimension, $descripcionDimension, $posicion, $color) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE dimensiones '
                . 'SET nombreDimension = :nombreDimension, '
                . 'descripcionDimension = :descripcionDimension, '
                . 'posicion = :posicion, '
                . 'color = :color '
                . 'WHERE idDimension = :idDimension');
        $stmt->bindValue(':nombreDimension', $nombreDimension);
        $stmt->bindValue(':descripcionDimension', $descripcionDimension);
        $stmt->bindValue(':idDimension', $idDimension);
        $stmt->bindValue(':posicion', $posicion);
        $stmt->bindValue(':color', $color);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la dimensión";
        }
    }

    public function eliminarDimension($idDimension) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM dimensiones '
                . 'WHERE idDimension = :idDimension');
        $stmt->bindValue(':idDimension', $idDimension);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function consultarIdDimensiones() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idDimension "
                . "FROM dimensiones "
                . "ORDER BY idDimension ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarDimensiones() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idDimension) "
                . "FROM dimensiones");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function consultarIcono($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE idDimension = :idDimension");
        $stmt->bindParam(":idDimension", $idDimension, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function contarDimensionesPorConjuntoIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idDimension) "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function listarDimensionesConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM dimensiones "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "ORDER BY nombreDimension ASC");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarConjuntoIndicadoresPorDimension($idDimension) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idConjuntoIndicadores "
                . "FROM dimensiones "
                . "WHERE idDimension= :idDimension");
        $stmt->bindValue(':idDimension', $idDimension);
        $stmt->execute();
        return $stmt->fetch();
    }

}
