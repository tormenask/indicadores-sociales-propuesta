<?php

/**
 * <b>DimensionesController</b>
 * Se encuentran las consultas necesarias para visualizar toda la información
 * asociada a las dimensiones de cada uno de los conjuntos de indicadores
 */
class NoticiaController {

    /**
     * <b>listarNoticiasHome</b>
     * <br>
     * Genera el bloque de noticias para la página principal
     */
    public function listarNoticiasHome() {
        $noticia = new NoticiaModel();
        $resp = $noticia->listarNoticias();
        $i = 0;
        foreach ($resp as $row => $item) {
            $ruta = $item['carpetaImagenesNoticia'];
            $imagenes = $item['imagenesNoticia'];
            if ($imagenes !== "" && $imagenes !== NULL) {
                $img_arr = explode(";", $imagenes);
                $titulo_noticia = $item['tituloNoticia'];
                natsort($img_arr);
                $location = $img_arr[0];
                $path = '/siscali/'.$ruta . '/' . $location;

                if ($i == 0) {
                    echo '<div class="item active">';
                } else {
                    echo '<div class="item">';
                }
                $i++;
                echo '
                <div style="padding: 8px 8px;">
                    <div class="panel-title" style="display: inline-block; padding: 0 10px; border-radius: 4px; text-align: left importat!; color: #fff;background-color: #215a9a;">NOTICIAS</div>
                    <a href="noticias#' . $item['anhoNoticia'] . '-' . $item['idNoticia'] . '" style="margin-left: 50%;"><b>Año </b>'. $item['anhoNoticia'] .'</a>
                </div>
                    <div class="container-news" style="height: 400px;">
                        <img class="ajustar-margen" src="' . $path . '" style=" width: 100%;height: 45%; " alt="' . $titulo_noticia . '">
                        <div style="padding: 10px 10px;">                           
                            <div class="">
                                <a href="noticias#' . $item['anhoNoticia'] . '-' . $item['idNoticia'] . '" style="color: #000000; text-decoration: none;">
                                    <b>' . $titulo_noticia . '</b><br><br>
                                    ' . substr($item['textoNoticia'], 0, 240) . '
                                </a>
                            </div>
                        </div>
                    </div>
                </div>';
            } else {
                $ruta = "/app/view/resources/noticias/0";
                $img_arr = ["logo.png"];
                $titulo_noticia = $item['tituloNoticia'];
                natsort($img_arr);
                foreach ($img_arr as $img => $location) {
                    $path = $ruta . '/' . $location;
                    if ($i == 0) {
                        echo '<div class="item active">';
                    } else {
                        echo '<div class="item">';
                    }
                    $i++;
                    echo '
                    <div class="container-news" style="height: 100%;">
                        <img class="ajustar-margen" src="' . $path . '" style=" width: 100%;" alt="' . $titulo_noticia . '">
                        <div class="overlay-news">
                            <div class="text-news">
                                <a href="noticias#' . $item['anhoNoticia'] . '-' . $item['idNoticia'] . '" style="color: #fff; text-decoration: none;">
                                    ' . $titulo_noticia . '<br><br>
                                    ' . substr($item['textoNoticia'], 0, 240) . '
                                </a>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            }
        }
    }

    /**
     * <b>listarNoticiasPorAnho</b>
     * <br>
     * Genera la visualización de las noticias para un año determinado
     * @param int $anhoNoticia Año para el cual se consultaran las noticias disponibles
     */
    public function listarNoticiasPorAnho($anhoNoticia) {
        $noticia = new NoticiaModel();
        $resp = $noticia->listarNoticiasPorAnho($anhoNoticia);
        foreach ($resp as $row => $item) {
            $ruta = $item['carpetaImagenesNoticia'];
            $imagenes = $item['imagenesNoticia'];
            if ($imagenes !== "" && $imagenes !== NULL) {
                $img_arr = explode(";", $imagenes);
                echo'
                <div class="row" id="' . $item['anhoNoticia'] . '-' . $item['idNoticia'] . '">
                    <div class="col-sm-12">
                        <div id="noticia_' . $item['idNoticia'] . '" class="carousel slide" data-ride="carousel" style="float: right; width: 40%; margin-left: 20px; margin-bottom: 15px;">
                            <ol class="carousel-indicators">';
                for ($i = 0; $i < count($img_arr); $i++) {
                    if ($i == 0) {
                        echo '  <li data-target="#noticia_' . $item['idNoticia'] . '" data-slide-to="0" class="active"></li>';
                    } else {
                        echo '  <li data-target="#noticia_' . $item['idNoticia'] . '" data-slide-to="' . $i . '" ></li>';
                    }
                }
                echo '      </ol>
                            <div class="carousel-inner noticias" role="listbox">';
                $j = 1;
                natsort($img_arr);
                foreach ($img_arr as $img => $location) {
                    $path = $ruta . '/' . $location;
                    if ($j == 1) {
                        echo '  <div class="item active">
                                    <img src="/siscali' . $path . ' "alt=" Imagen ' . $i . 'de la noticia' . $item['tituloNoticia'] . '"/>
                                </div>';
                    } else {
                        echo '  <div class="item">
                                    <img src="/siscali' . $path . ' "alt=" Imagen ' . $i . 'de la noticia' . $item['tituloNoticia'] . '"/>
                                </div>';
                    }
                    $j++;
                }
                echo '          </div>
                        </div>
                        <h4 style="color: #215a9a;">' . $item['tituloNoticia'] . '</h4>
                        <p style="margin: 10px 0 0 0; font-size:11px;"><i>' . $item['fechaNoticia'] . '</i></p>
                        <br>
                        
                        ' . $item['textoNoticia'] . '
                            <br>
                            <br>
                        <hr>
                    </div>
                </div>';
            } else {
                echo'
                <div class="row" id="' . $item['anhoNoticia'] . '-' . $item['idNoticia'] . '">
                    <div class="col-sm-12">
                        <h4 style="color: #215a9a;">' . $item['tituloNoticia'] . '</h4>
                        <p style="margin: 10px 0 0 0; font-size:11px;"><i>' . $item['fechaNoticia'] . '</i></p>
                        <br>
                        
                        ' . $item['textoNoticia'] . '
                            <br>
                            <br>
                        <hr>
                    </div>
                </div>';
            }
        }
    }

}
