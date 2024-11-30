<?php
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/conjuntoIndicadores.php';
require_once '../../../../model/conjuntoIndicadores.php';

class FuncionesRoles {

    public $nombreRol, $descripcionRol;
    public $idRolEd, $nombreRolEd, $descripcionRolEd;
    public $idRolEl;
    public $idRolPerm, $nombreModuloPerm, $crearPerm, $modificarPerm, $eliminarPerm;

    public function crearRol() {
        $data1 = $this->nombreRol;
        $data2 = $this->descripcionRol;
        $resp = new RolController();
        $ret = $resp->crearRol($data1, $data2);
        echo $ret;
    }

    public function editarRol() {
        $data1 = $this->idRolEd;
        $data2 = $this->nombreRolEd;
        $data3 = $this->descripcionRolEd;
        $resp = new RolController();
        $ret = $resp->editarRol($data1, $data2, $data3);
        echo $ret;
    }

    public function eliminarRol() {
        $data1 = $this->idRolEl;
        $resp = new RolController();
        $ret = $resp->eliminarRol($data1);
        echo $ret;
    }

    public function cambiarPermisosRol() {
        $data1 = $this->idRolPerm;
        $data2 = $this->nombreModuloPerm;
        $data3 = $this->crearPerm;
        $data4 = $this->modificarPerm;
        $data5 = $this->eliminarPerm;
        $resp = new RolController();
        $ret = $resp->cambiarPermisosRol($data1, $data2, $data3, $data4, $data5);
        echo $ret;
    }

}

if (isset($_POST['nombreRol']) && isset($_POST['descripcionRol'])) {
    $roles = new FuncionesRoles();
    $roles->nombreRol = $_POST['nombreRol'];
    $roles->descripcionRol = $_POST['descripcionRol'];
    $roles->crearRol();
}

if (isset($_POST['idRolEd']) && isset($_POST['nombreRolEd']) && isset($_POST['descripcionRolEd'])) {
    $roles = new FuncionesRoles();
    $roles->idRolEd = $_POST['idRolEd'];
    $roles->nombreRolEd = $_POST['nombreRolEd'];
    $roles->descripcionRolEd = $_POST['descripcionRolEd'];
    $roles->editarRol();
}

if (isset($_POST['idRolEl'])) {
    $roles = new FuncionesRoles();
    $roles->idRolEl = $_POST['idRolEl'];
    $roles->eliminarRol();
}

if (isset($_POST['idRolPerm']) && isset($_POST['nombreModuloPerm']) && isset($_POST['crearPerm']) && isset($_POST['modificarPerm']) && isset($_POST['eliminarPerm'])) {
    $roles = new FuncionesRoles();
    $roles->idRolPerm = $_POST['idRolPerm'];
    $roles->nombreModuloPerm = $_POST['nombreModuloPerm'];
    $roles->crearPerm = $_POST['crearPerm'];
    $roles->modificarPerm = $_POST['modificarPerm'];
    $roles->eliminarPerm = $_POST['eliminarPerm'];
    $roles->cambiarPermisosRol();
}