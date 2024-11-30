<?php

require_once 'connection.php';

class NoticiaModel extends Connection {

    public function listarNoticias() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM noticias "
                . "ORDER BY fechaNoticia DESC, idNoticia DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarNoticiasPorAnho($anhoNoticia) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM noticias "
                . "WHERE anhoNoticia = :anhoNoticia "
                . "ORDER BY fechaNoticia DESC, idNoticia DESC");
        $stmt->bindParam(":anhoNoticia", $anhoNoticia, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
