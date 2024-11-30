<?php

require_once 'connection.php';

class Log extends Connection {

    public function crearLog($numeroIdentificacionUsuario, $fechaLog, $horaLog, $idModuloLog, $accionLog, $direccionIpLog) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT ignore INTO logs '
                . 'VALUES(:idLog, :numeroIdentificacionUsuario, :fechaLog, :horaLog, :idModuloLog, :accionLog, :direccionIpLog)');
        $stmt->bindValue(':idLog', NULL);
        $stmt->bindValue(':numeroIdentificacionUsuario', $numeroIdentificacionUsuario);
        $stmt->bindValue(':fechaLog', $fechaLog);
        $stmt->bindValue(':horaLog', $horaLog);
        $stmt->bindValue(':idModuloLog', $idModuloLog);
        $stmt->bindValue(':accionLog', $accionLog);
        $stmt->bindValue(':direccionIpLog', $direccionIpLog);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el log";
        }
    }

    public function listarLogs() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM logs "
                . "ORDER BY idLog DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
