<?php

require_once 'connection.php';

class ConjuntosIndicadores extends Connection {

    public function consultarConjuntoIndicadoresPorId($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM conjuntosindicadores "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

}
