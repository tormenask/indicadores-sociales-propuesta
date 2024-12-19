<?php

session_start();
require_once '../model/usuario.php';
require_once '../model/crud_usuario.php';
require_once '../model/connection.php';
require_once '../model/estado.php';
include_once '../model/log.php';
include_once '../controller/log.php';

$usuario = new Usuario();
$crud = new CrudUsuario();
$estado = new Estado();
$log = new LogController();
if (isset($_POST['ingresar'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];
    echo $password;
    if ($user !== "" && $password !== "") {
        $usuario = $crud->obtenerUsuario($_POST['user'], $_POST['password']);
        $nombreEstado = $estado->consultarNombreEstado($usuario->getEstado());
        if ($usuario->getCorreoElectronico() != NULL) {
            if ($nombreEstado == "Bloqueado") {
                $_SESSION['userData']['identificacion'] = $usuario->getIdentificacion();
                $log->crearLog(0, "Intento de inicio de sesión - Usuario Bloqueado");
                unset($_SESSION);
                header('Location: ../index.php?error=1');
            } else if ($nombreEstado == "Activo") {
                session_start();
                session_regenerate_id(true);
                $_SESSION['sessionExists'] = TRUE;
                $_SESSION['userData'] = array();
                $_SESSION['userData']['nombre'] = $usuario->getNombre();
                $_SESSION['userData']['genero'] = $usuario->getGenero();
                $_SESSION['userData']['identificacion'] = $usuario->getIdentificacion();
                $_SESSION['userData']['correoElectronico'] = $usuario->getCorreoElectronico();
                $_SESSION['userData']['idRol'] = $usuario->getIdRol();
                $log->crearLog(0, "Inicio de sesión - Usuario Activo");
                header('Location: ../index.php?action=admin/home');
            } else if ($nombreEstado == "Inactivo") {
                $_SESSION['userData']['identificacion'] = $usuario->getIdentificacion();
                $log->crearLog(0, "Intento de inicio de sesión - Usuario Inactivo");
                unset($_SESSION);
                header('Location: ../index.php?error=2');
            } else {
                $_SESSION['userData']['identificacion'] = $usuario->getIdentificacion();
                $log->crearLog(0, "Intento de inicio de sesión - Usuario " . $nombreEstado . ' - Usuario no válido');
                unset($_SESSION);
                header('Location: ../index.php?error=3');
            }
        } else {
            $_SESSION['userData']['identificacion'] = "0000000000";
            $log->crearLog(0, "Intento de inicio de sesión - Datos incorrectos. Usuario: " . $_POST['user']);
            unset($_SESSION);
            header('Location: ../index.php?action=login/error&mensaje=Tu nombre de usuario o clave son incorrectos'); // cuando los datos son incorrectos envia a la página de error
        }
    } else {
        header('Location: ../index.php?error=0');
    }
} elseif (isset($_POST['salir'])) {
    unset($_SESSION);
    header('Location: ../index.php');
}
?>