<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/organismo.php';
require_once '../../../../model/crud_usuario.php';
require_once '../../../../model/organismo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';

class FuncionesOrganismos {

    public $nombreOrganismo;
    public $idOrganismoEd, $nombreOrganismoEd;
    public $idOrganismoEl;

    public function crearOrganismo() {
        $resp = new OrganismoController();
        $ret = $resp->crearOrganismo($this->nombreOrganismo);
        echo $ret;
    }

    public function editarOrganismo() {
        $resp = new OrganismoController();
        $ret = $resp->editarOrganismo($this->idOrganismoEd, $this->nombreOrganismoEd);
        echo $ret;
    }

    public function eliminarOrganismo() {
        $resp = new OrganismoController();
        $ret = $resp->eliminarOrganismo($this->idOrganismoEl);
        echo $ret;
    }

}

if (isset($_POST['nombreOrganismo'])) {
    $organismo = new FuncionesOrganismos();
    $organismo->nombreOrganismo= $_POST['nombreOrganismo'];
    $organismo->crearOrganismo();
}
if (isset($_POST['idOrganismoEd']) && isset($_POST['nombreOrganismoEd'])) {
    $organismo = new FuncionesOrganismos();
    $organismo->idOrganismoEd = $_POST['idOrganismoEd'];
    $organismo->nombreOrganismoEd = $_POST['nombreOrganismoEd'];
    $organismo->editarOrganismo();
}
if (isset($_POST['idOrganismoEl'])) {
    $organismo = new FuncionesOrganismos();
    $organismo->idOrganismoEl = $_POST['idOrganismoEl'];
    $organismo->eliminarOrganismo();
}