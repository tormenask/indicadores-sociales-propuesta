<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';
include_once '../../../../model/conjuntoIndicadores.php';
include_once '../../../../controller/conjuntoIndicadores.php';

class FuncionesModulos {

    public $nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura;
    public $idModuloEd, $nombreModuloEd, $disponibleConjuntosEd, $iconoModuloEd, $abreviaturaEd;
    public $idModuloEl;

    public function crearModulo() {
        $resp = new ModuloController();
        $ret = $resp->crearModulo($this->nombreModulo, $this->disponibleConjuntos, $this->iconoModulo, $this->abreviatura);
        echo $ret;
    }

    public function editarModulo() {
        $resp = new ModuloController();
        $ret = $resp->editarModulo($this->idModuloEd, $this->nombreModuloEd, $this->disponibleConjuntosEd, $this->iconoModuloEd, $this->abreviaturaEd);
        echo $ret;
    }

    public function eliminarModulo() {
        $resp = new ModuloController();
        $ret = $resp->eliminarModulo($this->idModuloEl);
        echo $ret;
    }

}

if (isset($_POST['nombreModulo']) && isset($_POST['disponibleConjuntos']) && isset($_POST['iconoModulo']) && isset($_POST['abreviatura'])) {
    $modulo = new FuncionesModulos();
    $modulo->nombreModulo = $_POST['nombreModulo'];
    $modulo->disponibleConjuntos = $_POST['disponibleConjuntos'];
    $modulo->iconoModulo = $_POST['iconoModulo'];
    $modulo->abreviatura = $_POST['abreviatura'];
    $modulo->crearModulo();
}
if (isset($_POST['idModuloEd']) && isset($_POST['nombreModuloEd']) && isset($_POST['disponibleConjuntosEd']) && isset($_POST['iconoModuloEd']) && isset($_POST['abreviaturaEd'])) {
    $modulo = new FuncionesModulos();
    $modulo->idModuloEd= $_POST['idModuloEd'];
    $modulo->nombreModuloEd = $_POST['nombreModuloEd'];
    $modulo->disponibleConjuntosEd= $_POST['disponibleConjuntosEd'];
    $modulo->iconoModuloEd = $_POST['iconoModuloEd'];
    $modulo->abreviaturaEd = $_POST['abreviaturaEd'];
    $modulo->editarModulo();
}
if (isset($_POST['idModuloEl'])) {
    $modulo = new FuncionesModulos();
    $modulo->idModuloEl = $_POST['idModuloEl'];
    $modulo->eliminarModulo();
}