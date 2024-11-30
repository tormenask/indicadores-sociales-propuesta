<?php

require_once 'connection.php';

class Visualizador extends Connection {

    public function crearRegistro($idElemento, $valorElemento, $idElementoPadre, $idAtributo) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO visualizadores '
                . 'VALUES(:idElemento, :valorElemento, :idElementoPadre, :idAtributo)');
        $stmt->bindValue(':idElemento', $idElemento);
        $stmt->bindValue(':valorElemento', $valorElemento);
        $stmt->bindValue(':idElementoPadre', $idElementoPadre);
        $stmt->bindValue(':idAtributo', $idAtributo);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el registro";
        }
    }

    public function idElementoExiste($idElemento) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM visualizadores "
                . "WHERE idElemento = :idElemento");
        $stmt->bindParam(":idElemento", $idElemento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

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

    public function consultarAtributosPorIdElemento($idElemento) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM visualizadores "
                . "WHERE idElemento = :idElemento");
        $stmt->bindParam(":idElemento", $idElemento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
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

//
//    public function listarConjuntosIndicadores() {
//        $stmt = Connection::connect()->prepare(""
//                . "SELECT * "
//                . "FROM conjuntosindicadores "
//                . "ORDER BY nombreConjuntoIndicadores ASC");
//        $stmt->execute();
//        return $stmt->fetchAll();
//    }
//
//    public function consultarConjuntoIndicadores($idConjuntoIndicadores) {
//        $stmt = Connection::connect()->prepare(""
//                . "SELECT * "
//                . "FROM conjuntosindicadores "
//                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
//        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
//        $stmt->execute();
//        return $stmt->fetch();
//    }
//
//    public function consultarNombreConjuntoIndicadores($idConjuntoIndicadores) {
//        $stmt = Connection::connect()->prepare(""
//                . "SELECT nombreConjuntoIndicadores "
//                . "FROM conjuntosindicadores "
//                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
//        $stmt->bindParam(":idConjuntoIndicadores", $idConjuntoIndicadores, PDO::PARAM_STR);
//        $stmt->execute();
//        return $stmt->fetch()["nombreConjuntoIndicadores"];
//    }
//
//
//    public function editarConjunto($idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto) {
//        $stmt = Connection::connect()->prepare(''
//                . 'UPDATE conjuntosindicadores '
//                . 'SET nombreConjuntoIndicadores = :nombreConjuntoIndicadores, '
//                . 'descripcionConjuntoIndicadores = :descripcionConjuntoIndicadores, '
//                . 'idOrganismoConjuntoIndicadores = :idOrganismoConjuntoIndicadores '
//                . 'WHERE idConjuntoIndicadores = :idConjuntoIndicadores');
//        $stmt->bindValue(':nombreConjuntoIndicadores', $nombreConjunto);
//        $stmt->bindValue(':descripcionConjuntoIndicadores', $descripcionConjunto);
//        $stmt->bindValue(':idOrganismoConjuntoIndicadores', $idOrganismoConjunto);
//        $stmt->bindValue(':idConjuntoIndicadores', $idConjunto);
//        if ($stmt->execute()) {
//            return "Editado";
//        } else {
//            return "Error al editar el conjunto";
//        }
//    }
//
//    public function eliminarConjunto($idConjunto) {
//        $stmt = Connection::connect()->prepare(''
//                . 'DELETE FROM conjuntosindicadores '
//                . 'WHERE idConjuntoIndicadores = :idConjuntoIndicadores');
//        $stmt->bindValue(':idConjuntoIndicadores', $idConjunto);
//        if ($stmt->execute()) {
//            return "Eliminado";
//        } else {
//            return $stmt->errorInfo()[1];
//        }
//    }
//    
//    public function conjuntoTieneDimension($idConjunto) {
//        $stmt = Connection::connect()->prepare(""
//                . "SELECT * "
//                . "FROM dimensiones "
//                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
//        $stmt->bindParam(":idConjuntoIndicadores", $idConjunto, PDO::PARAM_STR);
//        $stmt->execute();
//        return $stmt->fetchAll();
//    }
//
//    public function consultarIdConjuntosIndicadores() {
//        $stmt = Connection::connect()->prepare(""
//                . "SELECT idConjuntoIndicadores "
//                . "FROM conjuntosindicadores "
//                . "ORDER BY idConjuntoIndicadores ASC");
//        $stmt->execute();
//        return $stmt->fetchAll();
//    }
//
//    public function contarConjuntosIndicadores() {
//        $stmt = Connection::connect()->prepare(""
//                . "SELECT COUNT(idConjuntoIndicadores) "
//                . "FROM conjuntosindicadores");
//        $stmt->execute();
//        return $stmt->fetchColumn();
//    }
//
}
