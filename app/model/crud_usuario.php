<?php

require_once 'usuario.php';
require_once 'connection.php';

class CrudUsuario extends Connection {

    public function crearUsuario($nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $contrasenaUsuario, $idRolUsuario, $estadoUsuario) {
        $stmt = Connection::connect()->prepare(''
                . 'INSERT INTO usuarios '
                . 'VALUES(:correoElectronico, :contrasena, :nombre, :tipoVinculacion, :organismo, :numeroIdentificacion, :estado, :idRol, :genero)');
        $pass = password_hash($contrasenaUsuario, PASSWORD_DEFAULT);
        $stmt->bindValue(':correoElectronico', $correoUsuario);
        $stmt->bindValue(':contrasena', $pass);
        $stmt->bindValue(':nombre', $nombreUsuario);
        $stmt->bindValue(':tipoVinculacion', $vinculacionUsuario);
        $stmt->bindValue(':organismo', $organismoUsuario);
        $stmt->bindValue(':numeroIdentificacion', $identificacionUsuario);
        $stmt->bindValue(':idRol', $idRolUsuario);
        $stmt->bindValue(':genero', $generoUsuario);
        $stmt->bindValue(':estado', $estadoUsuario);
        if ($stmt->execute()) {
            return "Creado";
        } else {
            return "Error al crear el usuario";
        }
    }

   public function editarUsuario($nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $idRolUsuario, $estadoUsuario) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE usuarios '
                . 'SET correoElectronico = :correoElectronico, '
                . 'nombre = :nombre, '
                . 'genero = :genero, '
                . 'tipoVinculacion = :tipoVinculacion, '
                . 'idOrganismo = :idOrganismo, '
                . 'idEstado = :idEstado, '
                . 'idRol = :idRol '
                . 'WHERE numeroIdentificacion = :numeroIdentificacion');
        $stmt->bindValue(':correoElectronico', $correoUsuario);
        $stmt->bindValue(':nombre', $nombreUsuario);
        $stmt->bindValue(':genero', $generoUsuario);
        $stmt->bindValue(':tipoVinculacion', $vinculacionUsuario);
        $stmt->bindValue(':idOrganismo', $organismoUsuario);
        $stmt->bindValue(':idEstado', $estadoUsuario);
        $stmt->bindValue(':idRol', $idRolUsuario);
        $stmt->bindValue(':numeroIdentificacion', $identificacionUsuario);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar el usuario";
        }
    }

    public function eliminarUsuario($identificacionUsuario) {
        $stmt = Connection::connect()->prepare(''
                . 'DELETE FROM usuarios '
                . 'WHERE numeroIdentificacion = :numeroIdentificacion');
        $stmt->bindValue(':numeroIdentificacion', $identificacionUsuario);
        if ($stmt->execute()) {
            return "Eliminado";
        } else {
            return "Error al eliminar el usuario";
        }
    }

    public function obtenerUsuario($correoElectronico, $clave) {
        $db = Connection::connect();
        $select = $db->prepare(''
                . 'SELECT * '
                . 'FROM usuarios '
                . 'WHERE correoElectronico = :correoElectronico');
        $select->bindValue('correoElectronico', $correoElectronico);
        $select->execute();
        $registro = $select->fetch();
        $usuario = new Usuario();
        if (password_verify($clave, $registro['contrasena'])) {
            $usuario->setCorreoElectronico($registro['correoElectronico']);
            $usuario->setNombre($registro['nombre']);
            $usuario->setGenero($registro['genero']);
            $usuario->setIdentificacion($registro['numeroIdentificacion']);
            $usuario->setContrasena($registro['contrasena']);
            $usuario->setEstado($registro['idEstado']);
            $usuario->setIdRol($registro['idRol']);
        }
        return $usuario;
    }

    public function cambiarContrasena($contrasenaNueva, $correoElectronico) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE usuarios '
                . 'SET contrasena = :contrasena '
                . 'WHERE correoElectronico = :correoElectronico');
        $pass = password_hash($contrasenaNueva, PASSWORD_DEFAULT);
        $stmt->bindValue(':contrasena', $pass);
        $stmt->bindValue(':correoElectronico', $correoElectronico);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar";
        }
    }   

    public function traeContrasena($correoElectronico) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT contrasena "
                . "FROM usuarios "
                . "WHERE correoElectronico = :correoElectronico");
        $stmt->bindValue(":correoElectronico", $correoElectronico);
        $stmt->execute();
        return $stmt->fetch();
    }
    
     public function cambiarContrasenaRoot($contrasenaNuev, $correoElectronico) {
        $stmt = Connection::connect()->prepare(''
                . 'UPDATE usuarios '
                . 'SET contrasena = :contrasena '
                . 'WHERE correoElectronico = :correoElectronico');
        $pass = password_hash($contrasenaNuev, PASSWORD_DEFAULT);
        $stmt->bindValue(':contrasena', $pass);
        $stmt->bindValue(':correoElectronico', $correoElectronico);
        if ($stmt->execute()) {
            return "Editado";
        } else {
            return "Error al editar";
        }
    }   

    
    public function traeCorreo($correoElectronico) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT correoElectronico "
                . "FROM usuarios "
                . "WHERE correoElectronico = :correoElectronico");
        $stmt->bindValue(":correoElectronico", $correoElectronico);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function buscarUsuario($correoElectronico) {
        $db = Connection::connect();
        $select = $db->prepare(''
                . 'SELECT * '
                . 'FROM usuarios '
                . 'WHERE correoElectronico = :correoElectronico');
        $select->bindValue('correoElectronico', $correoElectronico);
        $select->execute();
        $registro = $select->fetch();
        if ($registro['correoElectronico'] != NULL) {
            $usado = False;
        } else {
            $usado = True;
        }
        return $usado;
    }

    public function consultarInformacionUsuario($correoElectronico) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM usuarios "
                . "WHERE correoElectronico = :correoElectronico");
        $stmt->bindParam(":correoElectronico", $correoElectronico, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function consultarInformacionUsuarioIdentificacion($numeroIdentificacion) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM usuarios "
                . "WHERE numeroIdentificacion = :numeroIdentificacion");
        $stmt->bindParam(":numeroIdentificacion", $numeroIdentificacion, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function correoUsuarioExiste($correoElectronico) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM usuarios "
                . "WHERE correoElectronico = :correoElectronico");
        $stmt->bindParam(":correoElectronico", $correoElectronico, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function identificacionUsuarioExiste($numeroIdentificacion) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM usuarios "
                . "WHERE numeroIdentificacion = :numeroIdentificacion");
        $stmt->bindParam(":numeroIdentificacion", $numeroIdentificacion, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function listarUsuarios() {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
     public function idOrganismoExisteEnUsuario($idOrganismo) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM usuarios "
                . "WHERE idOrganismo = :idOrganismo");
        $stmt->bindParam(":idOrganismo", $idOrganismo, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

}
