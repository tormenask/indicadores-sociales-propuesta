<?php

require_once 'connection.php';

class Publicaciones extends Connection {

    public function listarPublicaciones($idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM urls "
                . "WHERE idConjuntoIndicadores = :idConjuntoIndicadores "
                . "ORDER BY idUrl ASC");
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crearPublicaciones($idUrl,$urlPublicaciones, $categoriaPublicaciones, $tituloPublicaciones, $descripcionPublicaciones, $palabrasClavePublicaciones, $contenidoPublicaciones,$idConjuntoIndicadores) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO urls '
                . 'VALUES(:idUrl, :url, :categoria, :titulo, :descripcion,:palabras_claves, :contenido, :idConjuntoIndicadores ) ');
        $stmt->bindValue(':idUrl', $idUrl);
        $stmt->bindValue(':url', $urlPublicaciones);
        $stmt->bindValue(':categoria', $categoriaPublicaciones);
        $stmt->bindValue(':titulo', $tituloPublicaciones);
        $stmt->bindValue(':descripcion', $descripcionPublicaciones);
        $stmt->bindValue(':palabras_claves', $palabrasClavePublicaciones);
        $stmt->bindValue(':contenido', $contenidoPublicaciones);
        $stmt->bindValue(':idConjuntoIndicadores', $idConjuntoIndicadores);
        if ($stmt->execute()){
            return "Creada";
        } else {
            return "Error al crear";
        }
    }
    
     public function consultarPublicaciones($idUrl) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM urls "
                . "WHERE idUrl = :idUrl");
        $stmt->bindParam(":idUrl", $idUrl, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarPublicaciones($idUrl,$urlPublicacionesEd, $categoriaPublicacionesEd, $tituloPublicacionesEd, $descripcionPublicacionesEd, $palabrasClavePublicacionesEd,$contenidoPublicacionesEd, $conjuntoPublicacionesEd){
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE urls '
                . 'SET url = :url, '
                . 'categoria = :categoria, '
                . 'titulo = :titulo, '
                . 'descripcion = :descripcion, '
                . 'palabras_claves = :palabras_claves, '
                . 'contenido = :contenido, '
                . 'idConjuntoIndicadores = :idConjuntoIndicadores '
                . 'WHERE idUrl = :idUrl');
        $stmt->bindValue(':idUrl', $idUrl);
        $stmt->bindValue(':url', $urlPublicacionesEd);
        $stmt->bindValue(':categoria', $categoriaPublicacionesEd);
        $stmt->bindValue(':titulo', $tituloPublicacionesEd);
        $stmt->bindValue(':descripcion', $descripcionPublicacionesEd);
        $stmt->bindValue(':palabras_claves', $palabrasClavePublicacionesEd);
        $stmt->bindValue(':contenido', $contenidoPublicacionesEd);
        $stmt->bindValue(':idConjuntoIndicadores', $conjuntoPublicacionesEd);
        if ($stmt->execute()) {
            return "Editada";
        } else {
            return "Error al editar";
        }
        
    }

    public function eliminarPublicaciones($idUrlEl) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM urls '
                . 'WHERE idUrl = :idUrl');
        $stmt->bindValue(':idUrl', $idUrlEl);
        if ($stmt->execute()) {
            return "Eliminada";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

}
