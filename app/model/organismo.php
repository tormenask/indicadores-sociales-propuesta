<?php

require_once 'connection.php';

class Organismo extends Connection {

    public function listarOrganismos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM organismos");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarNombreOrganismo($idOrganismo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreOrganismo "
                . "FROM organismos "
                . "WHERE idOrganismo = :idOrganismo");
        $stmt->bindParam(":idOrganismo", $idOrganismo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["nombreOrganismo"];
    }

    public function crearOrganismo($idOrganismo, $nombreOrganismo) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO organismos '
                . 'VALUES(:idOrganismo, :nombreOrganismo)');
        $stmt->bindValue(':idOrganismo', $idOrganismo);
        $stmt->bindValue(':nombreOrganismo', $nombreOrganismo);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el organismo";
        }
    }

    public function consultarOrganismo($idOrganismo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM organismos "
                . "WHERE idOrganismo = :idOrganismo");
        $stmt->bindParam(":idOrganismo", $idOrganismo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function nombreOrganismoExiste($nombreOrganismo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM organismos "
                . "WHERE nombreOrganismo = :nombreOrganismo");
        $stmt->bindParam(":nombreOrganismo", $nombreOrganismo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function idOrganismoExiste($idOrganismo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM organismos "
                . "WHERE idOrganismo = :idOrganismo");
        $stmt->bindParam(":idOrganismo", $idOrganismo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function editarOrganismo($idOrganismo, $nombreOrganismo) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE organismos '
                . 'SET nombreOrganismo = :nombreOrganismo '
                . 'WHERE idOrganismo = :idOrganismo');
        $stmt->bindValue(':nombreOrganismo', $nombreOrganismo);
        $stmt->bindValue(':idOrganismo', $idOrganismo);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el organismo";
        }
    }

    public function eliminarOrganismo($idOrganismo) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM organismos '
                . 'WHERE idOrganismo = :idOrganismo');
        $stmt->bindValue(':idOrganismo', $idOrganismo);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function contarOrganismos() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT COUNT(idOrganismo) "
                . "FROM organismos");
        $stmt->execute();
        return $stmt->fetchColumn();
    }


}
