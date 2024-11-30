<?php

require_once 'connection.php';

class Documento extends Connection {

    public function crearDocumento($idDocumento, $tituloDocumento, $tipoDocumento, $descripcionDocumento, $archivoDocumento, $idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO documentos '
                . 'VALUES(:idDocumento, :tituloDocumento, :tipoDocumento, :descripcionDocumento, :archivoDocumento, :idConjuntoIndicadores)');
        $stmt->bindValue(':idDocumento', $idDocumento);
        $stmt->bindValue(':tituloDocumento', $tituloDocumento);
        $stmt->bindValue(':tipoDocumento', $tipoDocumento);
        $stmt->bindValue(':descripcionDocumento', $descripcionDocumento);
        $stmt->bindValue(':archivoDocumento', $archivoDocumento);
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el documento";
        }
    }

    public function listarDocumentos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM documentos");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarDocumento($idDocumento) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM documentos "
                . "WHERE idDocumento = :idDocumento");
        $stmt->bindParam(":idDocumento", $idDocumento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function contarDocumentosPorConjuntoIndicadores($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idDocumento) "
                . "FROM documentos "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function idDocumentoExiste($idDocumento) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * FROM documentos "
                . "WHERE idDocumento = :idDocumento");
        $stmt->bindParam(":idDocumento", $idDocumento, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarDocumento($idDocumento, $tituloDocumento, $tipoDocumento, $descripcionDocumento, $archivoDocumento) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE documentos '
                . 'SET tituloDocumento = :tituloDocumento, '
                . 'tipoDocumento = :tipoDocumento, '
                . 'descripcionDocumento = :descripcionDocumento , '
                . 'archivoDocumento = :archivoDocumento '
                . 'WHERE idDocumento= :idDocumento');
        $stmt->bindValue(':idDocumento', $idDocumento);
        $stmt->bindValue(':tituloDocumento', $tituloDocumento);
        $stmt->bindValue(':tipoDocumento', $tipoDocumento);
        $stmt->bindValue(':descripcionDocumento', $descripcionDocumento);
        $stmt->bindValue(':archivoDocumento', $archivoDocumento);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el documento";
        }
    }

    public function editarDocumentoSinArchivo($idDocumento, $tituloDocumento, $descripcionDocumento) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE documentos '
                . 'SET tituloDocumento = :tituloDocumento, '
                . 'descripcionDocumento = :descripcionDocumento '
                . 'WHERE idDocumento= :idDocumento');
        $stmt->bindValue(':idDocumento', $idDocumento);
        $stmt->bindValue(':tituloDocumento', $tituloDocumento);
        $stmt->bindValue(':descripcionDocumento', $descripcionDocumento);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el documento";
        }
    }

    public function siguienteIdDocumento() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT AUTO_INCREMENT "
                . "FROM information_schema.TABLES "
                . "WHERE TABLE_SCHEMA = 'siscali' "
                . "AND TABLE_NAME = 'documentos'");
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarDocumentosConjunto($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM documentos "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "ORDER BY tituloDocumento ASC");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function eliminarDocumento($idDocumento) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM documentos '
                . 'WHERE idDocumento = :idDocumento');
        $stmt->bindValue(':idDocumento', $idDocumento);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

}
