<?php

require_once 'connection.php';

class FichaTecnica extends Connection {

    public function consultarFichaTecnicaPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM fichatecnica "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
    public function consultarFichaTecnicaPorIndicadorYFuenteDatos($idIndicador, $fuenteDatos) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM fichatecnica "
                . "WHERE idIndicador = :idIndicador "
                . "AND fuenteDatos = :fuenteDatos");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":fuenteDatos", $fuenteDatos, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
    
     public function consultarFichaTecnicaPorIndicadorGlobalesCiudad($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM fichatecnicaigc "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

}
