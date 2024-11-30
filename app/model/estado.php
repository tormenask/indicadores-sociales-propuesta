<?php

require_once 'connection.php';

class Estado extends Connection {

    public function listarEstados() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM estados");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarNombreEstado($idEstado) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreEstado "
                . "FROM estados "
                . "WHERE idEstado = :idEstado");
        $stmt->bindParam(":idEstado", $idEstado, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()['nombreEstado'];
    }

    public function crearEstado($idEstado, $nombreEstado, $descripcionEstado) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO estados '
                . 'VALUES(:idEstado, :nombreEstado, :descripcionEstado)');
        $stmt->bindValue(':idEstado', $idEstado);
        $stmt->bindValue(':nombreEstado', $nombreEstado);
        $stmt->bindValue(':descripcionEstado', $descripcionEstado);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el estado";
        }
    }

    public function consultarEstado($idEstado) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM estados "
                . "WHERE idEstado = :idEstado");
        $stmt->bindParam(":idEstado", $idEstado, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreEstadoExiste($nombreEstado) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM estados "
                . "WHERE nombreEstado = :nombreEstado");
        $stmt->bindParam(":nombreEstado", $nombreEstado, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function idEstadoExiste($idEstado) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM estados "
                . "WHERE idEstado = :idEstado");
        $stmt->bindParam(":idEstado", $idEstado, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarEstado($idEstado, $nombreEstado, $descripcionEstado) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE estados '
                . 'SET nombreEstado = :nombreEstado, '
                . 'descripcionEstado = :descripcionEstado '
                . 'WHERE idEstado = :idEstado');
        $stmt->bindValue(':nombreEstado', $nombreEstado);
        $stmt->bindValue(':descripcionEstado', $descripcionEstado);
        $stmt->bindValue(':idEstado', $idEstado);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el estado";
        }
    }

    public function eliminarEstado($idEstado) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM estados '
                . 'WHERE idEstado = :idEstado');
        $stmt->bindValue(':idEstado', $idEstado);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function contarEstados() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idEstado) "
                . "FROM estados");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

}
