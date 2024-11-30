<?php

require_once 'connection.php';

class Rol extends Connection {

    public function listarRoles() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM roles");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function listarIdsRoles() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idRol "
                . "FROM roles");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function consultarRol($idRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM roles "
                . "WHERE idRol = :idRol");
        $stmt->bindParam(":idRol", $idRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarNombreRol($idRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT nombreRol "
                . "FROM roles "
                . "WHERE idRol = :idRol");
        $stmt->bindParam(":idRol", $idRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch()["nombreRol"];
    }

    public function nombreRolExiste($nombreRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM roles "
                . "WHERE nombreRol = :nombreRol");
        $stmt->bindParam(":nombreRol", $nombreRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarIdRol($nombreRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT idRol "
                . "FROM roles "
                . "WHERE nombreRol = :nombreRol");
        $stmt->bindParam(":nombreRol", $nombreRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function idRolExiste($idRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM roles "
                . "WHERE idRol = :idRol");
        $stmt->bindParam(":idRol", $idRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function crearRol($nombreRol, $descripcionRol) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO roles '
                . 'VALUES(NULL, :nombreRol, :descripcionRol)');
        $stmt->bindValue(':nombreRol', $nombreRol);
        $stmt->bindValue(':descripcionRol', $descripcionRol);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el rol";
        }
    }

    public function editarRol($idRol, $nombreRol, $descripcionRol) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE roles '
                . 'SET nombreRol = :nombreRol, '
                . 'descripcionRol = :descripcionRol '
                . 'WHERE idRol = :idRol');
        $stmt->bindValue(':nombreRol', $nombreRol);
        $stmt->bindValue(':descripcionRol', $descripcionRol);
        $stmt->bindValue(':idRol', $idRol);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el rol";
        }
    }

    public function eliminarRol($idRol) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM roles '
                . 'WHERE idRol = :idRol');
        $stmt->bindValue(':idRol', $idRol);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }
    
         public function rolTieneUsuario($idRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM usuarios "
                . "WHERE idRol = :idRol");
        $stmt->bindParam(":idRol", $idRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function eliminarPermisos($idRol) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM permisos '
                . 'WHERE idRol = :idRol');
        $stmt->bindValue(':idRol', $idRol);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function eliminarPermisosConjunto($idConjunto) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM permisos '
                . 'WHERE modulo LIKE CONCAT("%", :idConjunto, "%")');
        $stmt->bindValue(':idConjunto', $idConjunto);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function eliminarPermisosModulo($idModulo) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM permisos '
                . 'WHERE idModulo = :idModulo');
        $stmt->bindValue(':idModulo', $idModulo);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return $stmt->errorInfo()[1];
        }
    }

    public function consultarPermisoRol($modulo, $idRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM permisos "
                . "WHERE modulo = :modulo "
                . "AND idRol = :idRol");
        $stmt->bindParam(":modulo", $modulo, PDO::PARAM_STR);
        $stmt->bindParam(":idRol", $idRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarPermisoModuloConjuntos($modulo, $idRol) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM permisos "
                . "WHERE modulo LIKE CONCAT(:modulo, '%') "
                . "AND idRol = :idRol "
                . "AND (crear = 1 || modificar = 1 || eliminar = 1)");
        $stmt->bindParam(":modulo", $modulo, PDO::PARAM_STR);
        $stmt->bindParam(":idRol", $idRol, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crearPermisos($modulo, $idRol, $idModulo) {
        $crear = 0;
        $modificar = 0;
        $eliminar = 0;
        $idPermiso = $idRol . "_" . $modulo;
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO permisos '
                . 'VALUES(:idPermiso, :modulo, :crear, :modificar, :eliminar, :idRol, :idModulo)');
        $stmt->bindValue(':idPermiso', $idPermiso);
        $stmt->bindValue(':modulo', $modulo);
        $stmt->bindValue(':crear', $crear);
        $stmt->bindValue(':modificar', $modificar);
        $stmt->bindValue(':eliminar', $eliminar);
        $stmt->bindValue(':idRol', $idRol);
        $stmt->bindValue(':idModulo', $idModulo);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el permiso";
        }
    }

    public function cambiarPermisosRol($idPermiso, $crear, $modificar, $eliminar) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE permisos '
                . 'SET crear = :crear, '
                . 'modificar = :modificar, '
                . 'eliminar = :eliminar '
                . 'WHERE idPermiso = :idPermiso');
        $stmt->bindValue(':crear', $crear);
        $stmt->bindValue(':modificar', $modificar);
        $stmt->bindValue(':eliminar', $eliminar);
        $stmt->bindValue(':idPermiso', $idPermiso);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar los permisos";
        }
    }

}
