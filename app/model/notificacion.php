<?php

require_once 'connection.php';

class Notificacion extends Connection {

    public function crearNotificacion($numeroIdentificacionUsuario, $accionNotificacion, $fechaNotificacion) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO notificaciones '
                . 'VALUES(:idNotificacion, :numeroIdentificacionUsuario, :accionNotificacion, :fechaNotificacion, :estadoNotificacion )');
        $stmt->bindValue(':idNotificacion', NULL);
        $stmt->bindValue(':numeroIdentificacionUsuario', $numeroIdentificacionUsuario);
        $stmt->bindValue(':accionNotificacion', $accionNotificacion);
        $stmt->bindValue(':fechaNotificacion', $fechaNotificacion);
        $stmt->bindValue(':estadoNotificacion', 0);
        if ($stmt->execute()) {
            return "Creada";
        } else {
            return "Error al crear la notificacion";
        }
    }

    public function cambiarEstadoNotificacion($idNotificacion) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE notificaciones '
                . 'SET estadoNotificacion = :estadoNotificacion '
                . 'WHERE idNotificacion = :idNotificacion');
        $stmt->bindValue(':estadoNotificacion', '1');
        $stmt->bindValue(':idNotificacion', $idNotificacion);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            var_dump($stmt->errorInfo());
            return "Error al actualizar el estado";
        }
    }

    public function listarNotificaciones() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM notificaciones "
                . "ORDER BY idNotificacion DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarNotificacionesSinLeer() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM notificaciones "
                . "WHERE estadoNotificacion = 0 "
                . "ORDER BY idNotificacion DESC LIMIT 5");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function contarNotificacionesSinLeer() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT count(idNotificacion) "
                . "AS Count "
                . "FROM notificaciones "
                . "WHERE estadoNotificacion = 0");
        $stmt->execute();
        return $stmt->fetch();
    }

}
