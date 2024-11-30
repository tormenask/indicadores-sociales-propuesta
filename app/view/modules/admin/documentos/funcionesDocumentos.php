<?php

require_once '../../../../controller/documento.php';
require_once '../../../../model/documento.php';
require_once '../../../../controller/conjuntoIndicadores.php';
require_once '../../../../model/conjuntoIndicadores.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';

class FuncionesDocumentos {

    public $tituloDocumento, $descripcionDocumento, $archivoDocumento, $idConjuntoDocumento;
    public $idDocumentoEd, $tituloDocumentoEd, $descripcionDocumentoEd, $archivoDocumentoNuevoEd, $idConjuntoDocumentoEd;
    public $idDocumentoEl;

    public function crearDocumento() {
        $resp = new DocumentoController();
        $ret = $resp->crearDocumento($this->tituloDocumento, $this->descripcionDocumento, $this->archivoDocumento, $this->idConjuntoDocumento);
        echo $ret;
    }

    public function editarDocumento() {
        $resp = new DocumentoController();
        $ret = $resp->editarDocumento($this->idDocumentoEd, $this->tituloDocumentoEd, $this->descripcionDocumentoEd, $this->archivoDocumentoNuevoEd, $this->idConjuntoDocumentoEd);
        echo $ret;
    }

    public function eliminarDocumento() {
        $resp = new DocumentoController();
        $ret = $resp->eliminarDocumento($this->idDocumentoEl);
        echo $ret;
    }

}

if (isset($_POST['tituloDocumento']) && isset($_POST['descripcionDocumento']) && isset($_FILES['archivoDocumento']) && isset($_POST['conjuntoDocumento'])) {
    $documento = new FuncionesDocumentos();
    $documento->tituloDocumento = $_POST['tituloDocumento'];
    $documento->descripcionDocumento = $_POST['descripcionDocumento'];
    $documento->archivoDocumento = $_FILES['archivoDocumento'];
    $documento->idConjuntoDocumento = $_POST['conjuntoDocumento'];
    $documento->crearDocumento();
}

if (isset($_POST['idDocumentoEd']) && isset($_POST['tituloDocumentoEd']) && isset($_POST['descripcionDocumentoEd'])  && isset($_POST['file']) && isset($_POST['conjuntoDocumentoEd'])) {
    $documento = new FuncionesDocumentos();
    $documento->idDocumentoEd = $_POST['idDocumentoEd'];
    $documento->tituloDocumentoEd = $_POST['tituloDocumentoEd'];
    $documento->descripcionDocumentoEd = $_POST['descripcionDocumentoEd'];
//    $documento->archivoDocumentoEd = $_POST['archivoDocumentoEd'];
    if ($_POST['file'] == TRUE && isset($_FILES['archivoDocumentoNuevoEd'])) {
        $documento->archivoDocumentoNuevoEd = $_FILES['archivoDocumentoNuevoEd'];
    } else {
        $documento->archivoDocumentoNuevoEd = "noDocumento";
    }
    $documento->idConjuntoDocumentoEd = $_POST['conjuntoDocumentoEd'];
    $documento->editarDocumento();
}

if (isset($_POST['idDocumentoEl'])) {
    $documento = new FuncionesDocumentos();
    $documento->idDocumentoEl= $_POST['idDocumentoEl'];
    $documento->eliminarDocumento();
}
