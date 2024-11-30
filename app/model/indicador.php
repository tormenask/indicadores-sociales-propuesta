<?php

require_once 'connection.php';

class Indicador extends Connection {

    public function crearIndicador($idIndicador, $nombreIndicador, $descripcionIndicador, $idTematica, $posicion, $mapa, $activado) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO indicadores '
                . 'VALUES(:idIndicador, :nombreIndicador, :descripcionIndicador, :idTematica, :posicion, :mapa, :activado, :numeroConsultas)');
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':nombreIndicador', $nombreIndicador);
        $stmt->bindValue(':descripcionIndicador', $descripcionIndicador);
        $stmt->bindValue(':idTematica', $idTematica);
        $stmt->bindValue(':posicion', $posicion);
        $stmt->bindValue(':mapa', $mapa);
        $stmt->bindValue(':activado', $activado);
        $stmt->bindValue(':numeroConsultas', 0);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el indicador";
        }
    }

    public function listarIndicadores() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores");
        $stmt->execute();
        return $stmt->fetchAll();
    }
   
    public function consultarIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIndicadorPosicion($posicion) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE posicion = :posicion");
        $stmt->bindParam(":posicion", $posicion, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarNombreIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreIndicador "
                . "FROM indicadores "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["nombreIndicador"];
    }

    public function idIndicadorExiste($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function indicadorTieneSerieDatos($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM serieDatos "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    

    public function nombreIndicadorExiste($nombreIndicador, $idTematicaCrear) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE nombreIndicador = :nombreIndicador "
                . "AND idTematica = :idTematica");
        $stmt->bindParam(":nombreIndicador", $nombreIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":idTematica", $idTematicaCrear, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["idIndicador"];
    }

    public function nombreIndicadorIgcExiste($nombreIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE idIndicador regexp '^IGC' "
                . "AND nombreIndicador = :nombreIndicador ");
        $stmt->bindParam(":nombreIndicador", $nombreIndicador, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["idTematica"];
    }

    public function nombreIndicadorExisteTematica($nombreIndicador, $idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE nombreIndicador = :nombreIndicador "
                . "AND idTematica = :idTematica");
        $stmt->bindParam(":nombreIndicador", $nombreIndicador, PDO::PARAM_STR);
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarIndicador($idIndicador, $nombreIndicador, $descripcionIndicador, $posicion, $mapa) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET nombreIndicador = :nombreIndicador, '
                . 'descripcionIndicador = :descripcionIndicador, '
                . 'posicion = :posicion, '
                . 'mapa = :mapa '
                . 'WHERE idIndicador= :idIndicador');
        $stmt->bindValue(':nombreIndicador', $nombreIndicador);
        $stmt->bindValue(':descripcionIndicador', $descripcionIndicador);
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':posicion', $posicion);
        $stmt->bindValue(':mapa', $mapa);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el indicador";
        }
    }

    public function editarPosicion($idIndicador, $posicion) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET posicion = :posicion '
                . 'WHERE idIndicador= :idIndicador');
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':posicion', $posicion);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el indicador";
        }
    }

    public function eliminarIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM indicadores '
                . 'WHERE idIndicador = :idIndicador');
        $stmt->bindValue(':idIndicador', $idIndicador);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function consultarIdIndicadores() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idIndicador "
                . "FROM indicadores "
                . "ORDER BY idIndicador ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarIndicadores() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idIndicador) "
                . "FROM indicadores");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function contarIndicadoresPorTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idIndicador) "
                . "FROM indicadores "
                . "WHERE idTematica = :idTematica");
        $stmt->bindValue(':idTematica', $idTematica);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function consultarUltimoId($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idIndicador "
                . "FROM indicadores "
                . "WHERE idTematica = :idTematica "
                . "ORDER by LENGTH (idIndicador) DESC, idIndicador DESC LIMIT 1");
        $stmt->bindParam(":idTematica", $idTematica, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarIndicadoresPorConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT indicadores.idIndicador, indicadores.nombreIndicador, indicadores.descripcionIndicador, indicadores.idTematica, indicadores.posicion, indicadores.mapa, indicadores.activado, "
                . "tematicas.idTematica, tematicas.idDimension "
                . "FROM dimensiones, tematicas, indicadores "
                . "WHERE indicadores.idTematica = tematicas.idTematica "
                . "AND tematicas.idDimension = dimensiones.idDimension "
                . "AND dimensiones.idConjuntoIndicadores = :idConjuntoIndicadores "
                . "ORDER BY indicadores.nombreIndicador ASC");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarTematicaPorIndicador($idIndicador) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idTematica "
                . "FROM indicadores "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarIndicadoresPorTematica($idTematica) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM indicadores "
                . "WHERE idTematica = :idTematica "
                . "ORDER BY nombreIndicador ASC");
        $stmt->bindValue(':idTematica', $idTematica);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarActivo($idIndicadorAc) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT activado "
                . "FROM indicadores "
                . "WHERE idIndicador = :idIndicador");
        $stmt->bindParam(":idIndicador", $idIndicadorAc, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["activado"];
    }

    public function editarActivo($idIndicador, $activo) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE indicadores '
                . 'SET activado = :activado '
                . 'WHERE idIndicador= :idIndicador');
        $stmt->bindValue(':idIndicador', $idIndicador);
        $stmt->bindValue(':activado', $activo);
        $stmt->execute();
    }

}