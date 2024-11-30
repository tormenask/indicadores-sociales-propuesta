<?php

require_once 'connection.php';

class Noticias extends Connection {

    public function listarNoticias() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM noticias");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarNoticiasEditar($idNoticia) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM noticias "
                . "WHERE idNoticia = :idNoticia");
        $stmt->bindParam(":idNoticia", $idNoticia, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function ultimoIdNoticias() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT AUTO_INCREMENT "
                . "FROM information_schema.TABLES "
                . "WHERE TABLE_SCHEMA = 'siscali' "
                . "AND TABLE_NAME = 'noticias' ");
        $stmt->execute();
        return $stmt->fetch()["AUTO_INCREMENT"];
    }

    public function crearNoticia($idNoticia, $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $carpetaImagenesNoticia, $imagenesNoticia) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO noticias '
                . 'VALUES(:idNoticia, :tituloNoticia, :anhoNoticia, :fechaNoticia,:textoNoticia, :carpetaImagenesNoticia, :imagenesNoticia) ');
        $stmt->bindValue(':idNoticia', $idNoticia);
        $stmt->bindValue(':tituloNoticia', $tituloNoticia);
        $stmt->bindValue(':anhoNoticia', $anhoNoticia);
        $stmt->bindValue(':fechaNoticia', $fechaNoticia);
        $stmt->bindValue(':textoNoticia', $textoNoticia);
        $stmt->bindValue(':carpetaImagenesNoticia', $carpetaImagenesNoticia);
        $stmt->bindValue(':imagenesNoticia', $imagenesNoticia);
        if ($stmt->execute()) {
            return "Creada";
        } else {
//            return "Error al crear";
            return $stmt->errorInfo()[1];
        }
    }

    public function editarNoticia($idNoticia, $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $path, $imagenesNoticia) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE noticias '
                . 'SET tituloNoticia = :tituloNoticia, '
                . 'anhoNoticia = :anhoNoticia, '
                . 'fechaNoticia = :fechaNoticia, '
                . 'textoNoticia = :textoNoticia, '
                . 'carpetaImagenesNoticia = :carpetaImagenesNoticia, '
                . 'imagenesNoticia = :imagenesNoticia '
                . 'WHERE idNoticia = :idNoticia');
        $stmt->bindValue(':idNoticia', $idNoticia);
        $stmt->bindValue(':tituloNoticia', $tituloNoticia);
        $stmt->bindValue(':anhoNoticia', $anhoNoticia);
        $stmt->bindValue(':fechaNoticia', $fechaNoticia);
        $stmt->bindValue(':textoNoticia', $textoNoticia);
        $stmt->bindValue(':carpetaImagenesNoticia', $path);
        $stmt->bindValue(':imagenesNoticia', $imagenesNoticia);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar la noticia";
        }
    }

    public function consultarNoticias($idNoticia) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM noticias "
                . "WHERE idNoticia = :idNoticia");
        $stmt->bindParam(":idNoticia", $idNoticia, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarCarpeta($idNoticia) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM noticias "
                . "WHERE idNoticia = :idNoticia");
        $stmt->bindParam(":idNoticia", $idNoticia, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function eliminarNoticia($idNoticia) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM noticias '
                . 'WHERE idNoticia = :idNoticia');
        $stmt->bindValue(':idNoticia', $idNoticia);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

}
