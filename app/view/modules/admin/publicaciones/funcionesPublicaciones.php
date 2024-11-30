<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/publicaciones.php';
require_once '../../../../model/publicaciones.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';

class FuncionesPublicaciones {

    public $urlPublicaciones, $categoriaPublicaciones, $tituloPublicaciones, $descripcionPublicaciones, $palabrasClavePublicaciones, $contenidoPublicaciones, $conjuntoPublicaciones;
    public $idUrl, $urlPublicacionesEd, $categoriaPublicacionesEd, $tituloPublicacionesEd, $descripcionPublicacionesEd, $palabrasClavePublicacionesEd, $contenidoPublicacionesEd, $conjuntoPublicacionesEd;
    public $idUrlEl;

    public function crearPublicaciones() {
        $resp = new PublicacionesController();
        $ret = $resp->crearPublicaciones($this->urlPublicaciones, $this->categoriaPublicaciones, $this->tituloPublicaciones, $this->descripcionPublicaciones, $this->palabrasClavePublicaciones, $this->contenidoPublicaciones, $this->conjuntoPublicaciones);
        echo $ret;
    }

    public function editarPublicaciones() {
        $resp = new PublicacionesController();
        $ret = $resp->editarPublicaciones($this->idUrl, $this->urlPublicacionesEd, $this->categoriaPublicacionesEd, $this->tituloPublicacionesEd, $this->descripcionPublicacionesEd, $this->palabrasClavePublicacionesEd, $this->contenidoPublicacionesEd, $this->conjuntoPublicacionesEd);
        echo $ret;
    }

    public function eliminarPublicaciones() {
        $resp = new PublicacionesController();
        $ret = $resp->eliminarPublicaciones($this->idUrlEl);
        echo $ret;
    }

}

if (isset($_POST['urlPublicaciones']) && isset($_POST['categoriaPublicaciones']) && isset($_POST['tituloPublicaciones']) && isset($_POST['descripcionPublicaciones']) && isset($_POST['palabrasClavePublicaciones']) && isset($_POST['contenidoPublicaciones']) && isset($_POST['conjuntoPublicaciones'])) {
    $publicaciones = new FuncionesPublicaciones();
    $publicaciones->urlPublicaciones = $_POST['urlPublicaciones'];
    $publicaciones->categoriaPublicaciones = $_POST['categoriaPublicaciones'];
    $publicaciones->tituloPublicaciones = $_POST['tituloPublicaciones'];
    $publicaciones->descripcionPublicaciones = $_POST['descripcionPublicaciones'];
    $publicaciones->palabrasClavePublicaciones = $_POST['palabrasClavePublicaciones'];
    $publicaciones->contenidoPublicaciones = $_POST['contenidoPublicaciones'];
    $publicaciones->conjuntoPublicaciones = $_POST['conjuntoPublicaciones'];
    $publicaciones->crearPublicaciones();
}
if (isset($_POST['idUrl']) && isset($_POST['urlPublicacionesEd']) && isset($_POST['categoriaPublicacionesEd']) && isset($_POST['tituloPublicacionesEd']) && isset($_POST['descripcionPublicacionesEd']) && isset($_POST['palabrasClavePublicacionesEd']) && isset($_POST['contenidoPublicacionesEd']) && isset($_POST['conjuntoPublicacionesEd'])) {
    $publicaciones = new FuncionesPublicaciones();
    $publicaciones->idUrl = $_POST['idUrl'];
    $publicaciones->urlPublicacionesEd = $_POST['urlPublicacionesEd'];
    $publicaciones->categoriaPublicacionesEd = $_POST['categoriaPublicacionesEd'];
    $publicaciones->tituloPublicacionesEd = $_POST['tituloPublicacionesEd'];
    $publicaciones->descripcionPublicacionesEd = $_POST['descripcionPublicacionesEd'];
    $publicaciones->palabrasClavePublicacionesEd = $_POST['palabrasClavePublicacionesEd'];
    $publicaciones->contenidoPublicacionesEd = $_POST['contenidoPublicacionesEd'];
    $publicaciones->conjuntoPublicacionesEd = $_POST['conjuntoPublicacionesEd'];
    $publicaciones->editarPublicaciones();
}
if (isset($_POST['idUrlEl'])) {
    $publicaciones = new FuncionesPublicaciones();
    $publicaciones->idUrlEl = $_POST['idUrlEl'];
    $publicaciones->eliminarPublicaciones();
}