<?php

require_once 'connection.php';

class ConjuntosIndicadores extends Connection {

    public function consultarConjuntoIndicadoresPorId($idSistemaIndicadores) {
        $stmt = Connection::connect()->prepare("SELECT * "
                . "FROM conjuntosindicadores "
                . "WHERE idConjuntoIndicadores=:idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idSistemaIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
