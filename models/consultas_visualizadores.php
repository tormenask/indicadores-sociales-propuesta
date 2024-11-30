<?php

require_once 'connection.php';

class ConsultasVisualizadoresModel extends Connection {

    public function consultarAtributosPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM atributos_visualizadores "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarElementosPorIdElementoPadre($idElementoPadre) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM visualizadores "
                . "WHERE idElementoPadre = :idElementoPadre");
        $stmt->bindParam(":idElementoPadre", $idElementoPadre, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarElementoPorIdElementoPadreYIAdAtributo($idElementoPadre, $idAtributo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM visualizadores "
                . "WHERE idElementoPadre = :idElementoPadre "
                . "AND idAtributo = :idAtributo");
        $stmt->bindParam(":idElementoPadre", $idElementoPadre, PDO::PARAM_STR);
        $stmt->bindParam(":idAtributo", $idAtributo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIdAtributoPorNombreYConjunto($nombreAtributo, $idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM atributos_visualizadores "
                . "WHERE nombreAtributo = :nombreAtributo "
                . "AND idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindParam(":nombreAtributo", $nombreAtributo, PDO::PARAM_STR);
        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarEstablecimientosEducativos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM visualizadores "
                . "WHERE idElementoPadre = 'CED'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIdEstablecimientosEducativosPorComunaYAtributo($nombreComuna, $idAtributo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idElementoPadre "
                . "FROM visualizadores "
                . "WHERE idAtributo = :idAtributo "
                . "AND valorElemento = :nombreComuna "
                . "AND idElemento LIKE 'CED%'");
        $stmt->bindParam(":idAtributo", $idAtributo, PDO::PARAM_STR);
        $stmt->bindParam(":nombreComuna", $nombreComuna, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarAtributosPorIdElemento($idElemento) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM visualizadores "
                . "WHERE idElemento = :idElemento");
        $stmt->bindParam(":idElemento", $idElemento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

}
