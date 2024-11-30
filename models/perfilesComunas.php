<?php

require_once 'connection.php';

class PerfilesModel extends Connection {

    public function consultarIndicadoresPorNombreComuna($nombreComuna) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM perfiles "
                . "WHERE zonaActual = :nombreComuna");
        $stmt->bindParam(":nombreComuna", $nombreComuna, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresPorDimensionYZonaActual($nombreDimension, $nombreComuna) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM perfilescomunas "
                . "WHERE nombreDimension = :nombreDimension "
                . "AND zonaActual= :nombreComuna "
                . "ORDER BY cast(posicion as unsigned) ASC");
        $stmt->bindParam(":nombreDimension", $nombreDimension, PDO::PARAM_STR);
        $stmt->bindParam(":nombreComuna", $nombreComuna, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarIndicadoresPorDimensionComunaCategoriaEncuesta($nombreDimension, $nombreComuna, $posicion) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM perfilescomunas "
                . "WHERE nombreDimension = :nombreDimension "
                . "AND zonaActual= :nombreComuna "
                . "AND posicion LIKE '%$posicion%' ORDER BY posicion ASC");
        $stmt->bindParam(":nombreDimension", $nombreDimension, PDO::PARAM_STR);
        $stmt->bindParam(":nombreComuna", $nombreComuna, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
