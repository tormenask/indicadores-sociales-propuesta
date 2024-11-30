<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/visualizador.php';
require_once '../../../../model/visualizador.php';
require_once '../../../../controller/notificacion.php';
require_once '../../../../model/notificacion.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/cargarArchivos.php';
require_once '../../../../model/archivoOpc.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';
require_once '../../../../model/connection.php';
require_once '../../../../model/dimension.php';
require_once '../../../../model/tematica.php';
require_once '../../../../model/indicador.php';
require_once '../../../../model/serieDatos.php';
require_once '../../../../model/dato.php';
require_once '../../../../model/fichaTecnica.php';
require_once 'funcionesArchivo.php';
set_include_path(get_include_path() . PATH_SEPARATOR . '../../../resources/PHPExcel-1.8/Classes/');
include 'PHPExcel/IOFactory.php';

class FuncionesArchivo {

    public $archivoInformacionC;
    public $archivoFichaC;
    public $archivoInformacionExp;
    public $archivoFichaExp;
    public $archivoInformacionIGC;
    public $archivoFichaIGC;
    public $archivoInformacionPiia;
    public $archivoFichaPiia;
    public $archivoInformacionOpc;
    public $eliminarData;
    public $archivoInformacionOdraf;
    public $archivoFichaOdraf;
    public $archivoCuatrienioODS, $archivoSeguimientoODS, $archivoFichaOds;
    public $archivoInformacionDadii;

    public function CargarArchivoSis() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivosSis($this->archivoInformacionC);
        echo $ret;
    }

    public function CargarFichaSis() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarFichaSis($this->archivoInformacionC);
        echo $ret;
    }

    public function CargarArchivoExp() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivosExp($this->archivoInformacionExp);
        echo $ret;
    }

    public function CargarFichaExp() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarFichaExp($this->archivoFichaExp);
        echo $ret;
    }

    public function CargarArchivoIgc() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivosIgc($this->archivoInformacionIGC);
        echo $ret;
    }

    public function CargarFichaIgc() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarFichaIgc($this->archivoFichaIGC);
        echo $ret;
    }

    public function CargarArchivoPiia() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivosPiia($this->archivoInformacionPiia);
        echo $ret;
    }

    public function CargarFichaPiia() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarFichaPiia($this->archivoFichaPiia);
        echo $ret;
    }

    public function CargarArchivoOpc() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivoOpc($this->archivoInformacionOpc);
        echo $ret;
    }

    public function eliminarData() {
        $resp = new cargarArchivos();
        $ret = $resp->eliminarData($this->eliminarData);
        echo $ret;
    }

    public function CargarArchivoOdraf() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivosOdraf($this->archivoInformacionOdraf);
        echo $ret;
    }

    public function CargarFichaOdraf() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarFichaOdraf($this->archivoFichaOdraf);
        echo $ret;
    }

    public function CargarCuatrenioODS() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarCuatrienioODS($this->archivoCuatrenioODS);
        echo $ret;
    }

    public function CargarSeguimientoODS() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivoSeguimientoODS($this->archivoSeguimientoODS);
        echo $ret;
    }

    public function CargarFichaOds() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarFichaOds($this->archivoFichaOds);
        echo $ret;
    }

    public function CargarArchivoDadii() {
        $resp = new CargarArchivos();
        $ret = $resp->CargarArchivosDadii($this->archivoInformacionDadii);
        echo $ret;
    }

}

if (isset($_FILES['archivoInformacionC'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoInformacionC = $_FILES['archivoInformacionC'];
    $archivo->CargarArchivoSis();
}
if (isset($_FILES['archivoFichaC'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoFichaC = $_FILES['archivoFichaC'];
    $archivo->CargarFichaSis();
}
if (isset($_FILES['archivoInformacionExp'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoInformacionExp = $_FILES['archivoInformacionExp'];
    $archivo->CargarArchivoExp();
}
if (isset($_FILES['archivoFichaExp'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoFichaExp = $_FILES['archivoFichaExp'];
    $archivo->CargarFichaExp();
}
if (isset($_FILES['archivoInformacionIGC'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoInformacionIGC = $_FILES['archivoInformacionIGC'];
    $archivo->CargarArchivoIgc();
}
if (isset($_FILES['archivoFichaIGC'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoFichaIGC = $_FILES['archivoFichaIGC'];
    $archivo->CargarFichaIgc();
}
if (isset($_FILES['archivoInformacionPiia'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoInformacionPiia = $_FILES['archivoInformacionPiia'];
    $archivo->CargarArchivoPiia();
}
if (isset($_FILES['archivoFichaPiia'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoFichaPiia = $_FILES['archivoFichaPiia'];
    $archivo->CargarFichaPiia();
}
if (isset($_FILES['archivoInformacionOpc'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoInformacionOpc = $_FILES['archivoInformacionOpc'];
    $archivo->CargarArchivoOpc();
}
if (isset($_POST['eliminarData'])) {
    $archivo = new FuncionesArchivo();
    $archivo->eliminarData = $_POST['eliminarData'];
    $archivo->eliminarData();
}
if (isset($_FILES['archivoInformacionOdraf'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoInformacionOdraf = $_FILES['archivoInformacionOdraf'];
    $archivo->CargarArchivoOdraf();
}
if (isset($_FILES['archivoFichaOdraf'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoFichaOdraf = $_FILES['archivoFichaOdraf'];
    $archivo->CargarFichaOdraf();
}
if (isset($_FILES['archivoCuatrenioODS'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoCuatrenioODS = $_FILES['archivoCuatrenioODS'];
    $archivo->CargarCuatrenioODS();
}
if (isset($_FILES['archivoSeguimientoODS'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoSeguimientoODS = $_FILES['archivoSeguimientoODS'];
    $archivo->CargarSeguimientoODS();
}
if (isset($_FILES['archivoFichaODS'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoFichaOds = $_FILES['archivoFichaODS'];
    $archivo->CargarFichaOds();
}
if (isset($_FILES['archivoInformacionDadii'])) {
    $archivo = new FuncionesArchivo();
    $archivo->archivoInformacionDadii = $_FILES['archivoInformacionDadii'];
    $archivo->CargarArchivoDadii();
}