<?php

require_once 'connection.php';

class Datos extends Connection {

    public function consultarFechasPorIdSerie($idSerie) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT DISTINCT fechaDato "
                . "FROM datos "
                . "WHERE idSerieDatos = :idSerieDatos "
                . "ORDER BY fechaDato ASC");
        $stmt->bindParam(":idSerieDatos", $idSerie, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
   
    public function consultarDatosPorIdSerie($idSerie) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datos "
                . "WHERE idSerieDatos = :idSerieDatos "
                . "ORDER BY fechaDato ASC");
        $stmt->bindParam(":idSerieDatos", $idSerie, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDatoPorIdSerieFecha($idSerie, $fecha) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT valorDato "
                . "FROM datos "
                . "WHERE idSerieDatos = :idSerieDatos "
                . "AND fechaDato = :fechaDato");
        $stmt->bindParam(":idSerieDatos", $idSerie, PDO::PARAM_STR);
        $stmt->bindParam(":fechaDato", $fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarInfoDatoPorIdSerieFecha($idSerie, $fecha) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM datos "
                . "WHERE idSerieDatos = :idSerieDatos "
                . "AND fechaDato=:fechaDato");
        $stmt->bindParam(":idSerieDatos", $idSerie, PDO::PARAM_STR);
        $stmt->bindParam(":fechaDato", $fecha, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

}
