<?php

require_once 'connection.php';

class Modulo extends Connection {

    public function listarModulos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM modulos "
                . "ORDER BY idModulo ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarModulosDisponiblesConjuntos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM modulos "
                . "WHERE disponibleConjuntos = 1 "
                . "ORDER BY idModulo ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crearModulo($idModulo, $nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO modulos '
                . 'VALUES(:idModulo, :nombreModulo, :disponibleConjuntos, :iconoModulo, :abreviatura)');
        $stmt->bindValue(':idModulo', $idModulo);
        $stmt->bindValue(':nombreModulo', $nombreModulo);
        $stmt->bindValue(':disponibleConjuntos', $disponibleConjuntos);
        $stmt->bindValue(':iconoModulo', $iconoModulo);
        $stmt->bindValue(':abreviatura', $abreviatura);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el modulo";
        }
    }

    public function consultarModulo($idModulo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM modulos "
                . "WHERE idModulo = :idModulo");
        $stmt->bindParam(":idModulo", $idModulo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIdModuloPorNombre($nombreModulo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idModulo "
                . "FROM modulos "
                . "WHERE nombreModulo = :nombreModulo");
        $stmt->bindParam(":nombreModulo", $nombreModulo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()['idModulo'];
    }

    public function nombreModuloExiste($nombreModulo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM modulos "
                . "WHERE nombreModulo = :nombreModulo");
        $stmt->bindParam(":nombreModulo", $nombreModulo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function idModuloExiste($idModulo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM modulos "
                . "WHERE idModulo = :idModulo");
        $stmt->bindParam(":idModulo", $idModulo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarModulo($idModulo, $nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE modulos '
                . 'SET nombreModulo = :nombreModulo, '
                . 'disponibleConjuntos = :disponibleConjuntos, '
                . 'iconoModulo = :iconoModulo, '
                . 'abreviatura = :abreviatura '
                . 'WHERE idModulo = :idModulo');
        $stmt->bindValue(':nombreModulo', $nombreModulo);
        $stmt->bindValue(':disponibleConjuntos', $disponibleConjuntos);
        $stmt->bindValue(':iconoModulo', $iconoModulo);
        $stmt->bindValue(':abreviatura', $abreviatura);
        $stmt->bindValue(':idModulo', $idModulo);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el modulo";
        }
    }

    public function eliminarModulo($idModulo) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM modulos '
                . 'WHERE idModulo = :idModulo');
        $stmt->bindValue(':idModulo', $idModulo);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function contarModulos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idModulo) "
                . "FROM modulos");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function siguienteIdModulo() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT AUTO_INCREMENT "
                . "FROM information_schema.TABLES "
                . "WHERE TABLE_SCHEMA = 'siscali' "
                . "AND TABLE_NAME = 'modulos'");
        $stmt->execute();
        return $stmt->fetch();
    }

}
