<?php

require_once '../../../../controller/perfil.php';
require_once '../../../../model/perfil.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';

class FuncionesPerfiles {

    public $tipoZonaGeografica, $idRol;
    public $zonaGeografica, $fechaDato, $valorDato, $posicion, $dimension, $indicador, $unidadMedicion, $fuenteDatos;
    public $idDatoEdit, $zonaGeograficaEdit, $fechaDatoEdit, $valorDatoEdit, $posicionEdit, $dimensionEdit, $indicadorEdit, $unidadMedicionEdit, $fuenteDatosEdit;
    public $idDatoDelete, $zonaGeograficaDelete, $fechaDatoDelete, $dimensionDelete, $indicadorDelete;
    public $idIndicadorGuardar,$tipoZonaGeograficaGuardar;
    public $idIndicadorDesguardar,$tipoZonaGeograficaDesguardar;

    
    public function crearDato() {
        $resp = new PerfilController();
        $ret = $resp->crearDatoPerfil($this->zonaGeografica, $this->fechaDato, $this->valorDato, $this->posicion, $this->dimension, $this->indicador, $this->unidadMedicion, $this->fuenteDatos);
        echo $ret;
    }

    public function editarDato() {
        $resp = new PerfilController();
        $ret = $resp->editarDatoPerfil($this->idDatoEdit, $this->zonaGeograficaEdit, $this->fechaDatoEdit, $this->valorDatoEdit, $this->posicionEdit, $this->dimensionEdit, $this->indicadorEdit, $this->unidadMedicionEdit, $this->fuenteDatosEdit);
        echo $ret;
    }

    public function eliminarDato() {
        $resp = new PerfilController();
        $ret = $resp->eliminarDatoPerfil($this->idDatoDelete, $this->zonaGeograficaDelete, $this->fechaDatoDelete, $this->dimensionDelete, $this->indicadorDelete);
        echo $ret;
    }

    public function consultarDatos() {
        $resp = new PerfilController();
        $ret = $resp->listarDatosTipoZona($this->tipoZonaGeografica, $this->idRol);
        echo $ret;
    }

    public function guardarEstado() {
        $resp = new PerfilController();
        $ret = $resp->cambiarEstadoNotificacion($this->idIndicadorGuardar,$this->tipoZonaGeograficaGuardar);
        
        echo $ret;
    }
    
     public function volverEstado() {
        $resp = new PerfilController();
        $ret = $resp->volverEstadoNotificacion($this->idIndicadorDesguardar,$this->tipoZonaGeograficaDesguardar);
        echo $ret;
    }

}




if (isset($_POST['tipoZonaGeografica']) && isset($_POST['idRol'])) {
    $perfil = new FuncionesPerfiles();
    $perfil->tipoZonaGeografica = $_POST['tipoZonaGeografica'];
    $perfil->idRol = $_POST['idRol'];
    $perfil->consultarDatos();
}

if (isset($_POST['zonaGeografica']) && isset($_POST['fechaDato']) && isset($_POST['valorDato']) && isset($_POST['posicion']) && isset($_POST['dimension']) && isset($_POST['indicador']) && isset($_POST['unidadMedicion']) && isset($_POST['fuenteDatos'])) {
    $perfil = new FuncionesPerfiles();
    $perfil->zonaGeografica = $_POST['zonaGeografica'];
    $perfil->fechaDato = $_POST['fechaDato'];
    $perfil->valorDato = $_POST['valorDato'];
    $perfil->posicion = $_POST['posicion'];
    $perfil->dimension = $_POST['dimension'];
    $perfil->indicador = $_POST['indicador'];
    $perfil->unidadMedicion = $_POST['unidadMedicion'];
    $perfil->fuenteDatos = $_POST['fuenteDatos'];
    $perfil->crearDato();
}

if (isset($_POST['idDatoEdit']) && isset($_POST['zonaGeograficaEdit']) && isset($_POST['fechaDatoEdit']) && isset($_POST['valorDatoEdit']) && isset($_POST['posicionEdit']) && isset($_POST['dimensionEdit']) && isset($_POST['indicadorEdit']) && isset($_POST['unidadMedicionEdit']) && isset($_POST['fuenteDatosEdit'])) {
    $perfil = new FuncionesPerfiles();
    $perfil->idDatoEdit = $_POST['idDatoEdit'];
    $perfil->zonaGeograficaEdit = $_POST['zonaGeograficaEdit'];
    $perfil->fechaDatoEdit = $_POST['fechaDatoEdit'];
    $perfil->valorDatoEdit = $_POST['valorDatoEdit'];
    $perfil->posicionEdit = $_POST['posicionEdit'];
    $perfil->dimensionEdit = $_POST['dimensionEdit'];
    $perfil->indicadorEdit = $_POST['indicadorEdit'];
    $perfil->unidadMedicionEdit = $_POST['unidadMedicionEdit'];
    $perfil->fuenteDatosEdit = $_POST['fuenteDatosEdit'];
    $perfil->editarDato();
}

if (isset($_POST['idDatoDelete']) && isset($_POST['zonaGeograficaDelete']) && isset($_POST['fechaDatoDelete']) && isset($_POST['dimensionDelete']) && isset($_POST['indicadorDelete'])) {
    $perfil = new FuncionesPerfiles();
    $perfil->idDatoDelete = $_POST['idDatoDelete'];
    $perfil->zonaGeograficaDelete = $_POST['zonaGeograficaDelete'];
    $perfil->fechaDatoDelete = $_POST['fechaDatoDelete'];
    $perfil->dimensionDelete = $_POST['dimensionDelete'];
    $perfil->indicadorDelete = $_POST['indicadorDelete'];
    $perfil->eliminarDato();
}

if (isset($_POST['idIndicadorGuardar'])&& isset($_POST['tipoZonaGeograficaGuardar'])) {
    $perfil = new FuncionesPerfiles();
    $perfil->idIndicadorGuardar = $_POST['idIndicadorGuardar'];
    $perfil->tipoZonaGeograficaGuardar = $_POST['tipoZonaGeograficaGuardar'];
    $perfil->guardarEstado();
}

if (isset($_POST['idIndicadorDesguardar']) && isset($_POST['tipoZonaGeograficaDesguardar'])) {
    $perfil = new FuncionesPerfiles();
    $perfil->idIndicadorDesguardar = $_POST['idIndicadorDesguardar'];
    $perfil->tipoZonaGeograficaDesguardar = $_POST['tipoZonaGeograficaDesguardar'];
    $perfil->volverEstado();

}