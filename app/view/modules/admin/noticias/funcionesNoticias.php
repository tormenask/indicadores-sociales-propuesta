<?php

require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/noticias.php';
require_once '../../../../model/noticias.php';
require_once '../../../../controller/log.php';
require_once '../../../../model/log.php';
require_once '../../../../controller/modulo.php';
require_once '../../../../model/modulo.php';
require_once '../../../../controller/rol.php';
require_once '../../../../model/rol.php';

class FuncionesNoticias {

    public $tituloNoticia, $anhoNoticia, $fechaNoticia, $textoNoticia, $imagen;
    public $idNoticiaEd, $tituloNoticiaEd, $anhoNoticiaEd, $fechaNoticiaEd, $textoNoticiaEd, $imagenEd;
    public $idNoticiaEl;

    public function crearNoticias() {
        $resp = new NoticiasController();
        $ret = $resp->crearNoticias($this->tituloNoticia, $this->anhoNoticia, $this->fechaNoticia, $this->textoNoticia, $this->imagen);
        echo $ret;
    }

    public function editarNoticias() {
        $resp = new NoticiasController();
        $ret = $resp->editarNoticias($this->idNoticiaEd, $this->tituloNoticiaEd, $this->anhoNoticiaEd, $this->fechaNoticiaEd, $this->textoNoticiaEd, $this->imagenEd);
        echo $ret;
    }

    public function eliminarNoticias() {
        $resp = new NoticiasController();
        $ret = $resp->eliminarNoticias($this->idNoticiaEl);
        echo $ret;
    }

}

if (isset($_POST['tituloNoticia']) && isset($_POST['anhoNoticia']) && isset($_POST['fechaNoticia']) && isset($_POST['textoNoticia'])) {
    $noticia = new FuncionesNoticias();
    $noticia->tituloNoticia = $_POST['tituloNoticia'];
    $noticia->anhoNoticia = $_POST['anhoNoticia'];
    $noticia->fechaNoticia = $_POST['fechaNoticia'];
    $noticia->textoNoticia = $_POST['textoNoticia'];
    if (isset($_FILES['imagen']) && $_FILES['imagen']["size"][0] !== 0) {
        $noticia->imagen = $_FILES['imagen'];
    } else {
        $noticia->imagen = "noImagen";
    }
    $noticia->crearNoticias();
} 
if (isset($_POST['idNoticiaEd']) && isset($_POST['tituloNoticiaEd']) && isset($_POST['anhoNoticiaEd']) && isset($_POST['fechaNoticiaEd']) && isset($_POST['textoNoticiaEd'])) {
    $noticia = new FuncionesNoticias();
    $noticia->idNoticiaEd = $_POST['idNoticiaEd'];
    $noticia->tituloNoticiaEd = $_POST['tituloNoticiaEd'];
    $noticia->anhoNoticiaEd = $_POST['anhoNoticiaEd'];
    $noticia->fechaNoticiaEd = $_POST['fechaNoticiaEd'];
    $noticia->textoNoticiaEd = $_POST['textoNoticiaEd'];
    if (isset($_FILES['imagenEd']) && $_FILES['imagenEd']["size"][0] !== 0) {
        $noticia->imagenEd = $_FILES['imagenEd'];
    } else {
        $noticia->imagenEd = "noImagen";
    }
    $noticia->editarNoticias();
}

if (isset($_POST['idNoticiaEl'])) {
    $noticia = new FuncionesNoticias();
    $noticia->idNoticiaEl = $_POST['idNoticiaEl'];
    $noticia->eliminarNoticias();
}