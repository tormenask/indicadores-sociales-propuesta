<?php

require_once '../../../../controller/usuario.php';
require_once '../../../../model/crud_usuario.php';
// require_once '../../../resources/PhpMail/class.smtp.php';
// require_once '../../../resources/PhpMail/class.phpmailer.php';


require_once '../../../resources/PHPMailer/src/OAuth.php';
require_once '../../../resources/PHPMailer/src/POP3.php';
require_once '../../../resources/PHPMailer/src/Exception.php';
require_once '../../../resources/PHPMailer/src/PHPMailer.php';
require_once '../../../resources/PHPMailer/src/SMTP.php';
class FuncionesUsuarios {

    public $nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $contrasenaUsuario, $idRolUsuario, $estadoUsuario;
    public $nombreUsuarioEd, $generoUsuarioEd, $correoUsuarioEd, $organismoUsuarioEd, $vinculacionUsuarioEd, $identificacionUsuarioEd, $contrasenaUsuarioEd, $idRolUsuarioEd, $estadoUsuarioEd;
    public $identificacionUsuarioEl;
    public $contrasenaNueva,$contrasenaAnterior;
    public $correoElectronico,$contrasenaNuev;
    public $recuperarContrasena;   
    
    public function crearUsuario() {
        $data1 = $this->nombreUsuario;
        $data2 = $this->generoUsuario;
        $data3 = $this->correoUsuario;
        $data4 = $this->organismoUsuario;
        $data5 = $this->vinculacionUsuario;
        $data6 = $this->identificacionUsuario;
        $data7 = $this->contrasenaUsuario;
        $data8 = $this->idRolUsuario;
        $data9 = $this->estadoUsuario;
        $resp = new UsuarioController();
        $ret = $resp->crearUsuario($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8, $data9);
        echo $ret;
    }
    
    public function cambiarContrasena() {
        $data1 = $this->contrasenaAnterior;
        $data2 = $this->contrasenaNueva;
//        $data3 = $this->contrasenaNuevaR;
        $resp = new UsuarioController();
        $ret = $resp->cambiarContrasena($data1, $data2);
        echo $ret;
    }
    
    public function cambiarContrasenaRoot() {
        $data1 = $this->correoElectronico;
        $data2 = $this->contrasenaNuev;
//        $data3 = $this->contrasenaNuevR;
        $resp = new UsuarioController();
        $ret = $resp->cambiarContrasenaRoot($data1, $data2);
        echo $ret;
    }

    public function editarUsuario() {
        $data1 = $this->nombreUsuarioEd;
        $data2 = $this->generoUsuarioEd;
        $data3 = $this->correoUsuarioEd;
        $data4 = $this->organismoUsuarioEd;
        $data5 = $this->vinculacionUsuarioEd;
        $data6 = $this->identificacionUsuarioEd;
        $data7 = $this->idRolUsuarioEd;
        $data8 = $this->estadoUsuarioEd;
        $resp = new UsuarioController();
        $ret = $resp->editarUsuario($data1, $data2, $data3, $data4, $data5, $data6, $data7, $data8);
        echo $ret;
    }
    public function eliminarUsuario() {
        $data1 = $this->identificacionUsuarioEl;
        $resp = new UsuarioController();
        $ret = $resp->eliminarUsuario($data1);
        echo $ret;
    }
    public function recuperarContrasena() {
        $data1 = $this->recuperarContrasena;
        $resp = new UsuarioController();
        $ret = $resp->recuperarContrasena($data1);
        echo $ret;
    }

}

if (isset($_POST['nombreUsuario']) && isset($_POST['generoUsuario']) && isset($_POST['correoUsuario']) && isset($_POST['organismoUsuario']) && isset($_POST['vinculacionUsuario']) && isset($_POST['identificacionUsuario']) && isset($_POST['contrasenaUsuario']) && isset($_POST['idRolUsuario']) && isset($_POST['estadoUsuario'])) {
    $usuarios = new FuncionesUsuarios();
    $usuarios->nombreUsuario = $_POST['nombreUsuario'];
    $usuarios->generoUsuario = $_POST['generoUsuario'];
    $usuarios->correoUsuario = $_POST['correoUsuario'];
    $usuarios->organismoUsuario = $_POST['organismoUsuario'];
    $usuarios->vinculacionUsuario = $_POST['vinculacionUsuario'];
    $usuarios->identificacionUsuario = $_POST['identificacionUsuario'];
    $usuarios->contrasenaUsuario = $_POST['contrasenaUsuario'];
    $usuarios->idRolUsuario = $_POST['idRolUsuario'];
    $usuarios->estadoUsuario = $_POST['estadoUsuario'];
    $usuarios->crearUsuario();
}
if (isset($_POST['nombreUsuarioEd']) && isset($_POST['generoUsuarioEd']) && isset($_POST['correoUsuarioEd']) && isset($_POST['organismoUsuarioEd']) && isset($_POST['vinculacionUsuarioEd']) && isset($_POST['identificacionUsuarioEd']) && isset($_POST['idRolUsuarioEd']) && isset($_POST['estadoUsuarioEd'])) {
    $usuarios = new FuncionesUsuarios();
    $usuarios->nombreUsuarioEd = $_POST['nombreUsuarioEd'];
    $usuarios->generoUsuarioEd = $_POST['generoUsuarioEd'];
    $usuarios->correoUsuarioEd = $_POST['correoUsuarioEd'];
    $usuarios->organismoUsuarioEd = $_POST['organismoUsuarioEd'];
    $usuarios->vinculacionUsuarioEd = $_POST['vinculacionUsuarioEd'];
    $usuarios->identificacionUsuarioEd = $_POST['identificacionUsuarioEd'];
    $usuarios->idRolUsuarioEd = $_POST['idRolUsuarioEd'];
    $usuarios->estadoUsuarioEd = $_POST['estadoUsuarioEd'];
    $usuarios->editarUsuario();
}
if (isset($_POST['identificacionUsuarioEl'])) {
    $usuarios = new FuncionesUsuarios();
    $usuarios->identificacionUsuarioEl = $_POST['identificacionUsuarioEl'];
    $usuarios->eliminarUsuario();
}
if (isset($_POST['contrasenaAnterior']) && isset($_POST['contrasenaNueva']) ) {
    $usuarios = new FuncionesUsuarios();
    $usuarios->contrasenaAnterior = $_POST['contrasenaAnterior'];
    $usuarios->contrasenaNueva = $_POST['contrasenaNueva'];
//    $usuarios->contrasenaNuevaR = $_POST['contrasenaNuevaR'];
//    var_dump($_POST['contrasenaAnterior']);
    $usuarios->cambiarContrasena();
}

if (isset($_POST['correoElectronico']) && isset($_POST['contrasenaNuev'])  ) {
    $usuarios = new FuncionesUsuarios();
    $usuarios->correoElectronico = $_POST['correoElectronico'];
    $usuarios->contrasenaNuev = $_POST['contrasenaNuev'];
//    $usuarios->contrasenaNuevR = $_POST['contrasenaNuevR'];
//    var_dump($_POST['contrasenaAnterior']);
    $usuarios->cambiarContrasenaRoot();
}
if (isset($_POST['recuperarContrasena'])) {
    $usuarios = new FuncionesUsuarios();
    $usuarios->recuperarContrasena = $_POST['recuperarContrasena'];
    $usuarios->recuperarContrasena();
}
