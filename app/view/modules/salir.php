<?php
session_start();
include_once 'model/log.php';
include_once 'controller/log.php';
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
    );
}
$log = new LogController();
$log->crearLog(0, "Finalización de sesión");
$_SESSION = array();
$_SESSION = "";
unset($_SESSION);
session_destroy();
header("Location: ../app/index.php");
