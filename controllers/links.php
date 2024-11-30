<?php

/**
 * <b>UrlController</b>
 * Se encuentran las consultas necesarias para visualizar las publicaciones y
 * consultar los enlaces a cada una de estas
 */
class UrlController {

    /**
     * <b>urlsController</b>
     * <br>
     * Permite consultar el parámetro "action", para la visualización del
     * contenido de una publicación
     */
    public function urlsController() {
        $url = "";
        if (isset($_GET["action"])) {
            $url = $_GET["action"];
        } else {
            $url = "index";
        }

        $info_url = $this->consultarUrl($url);
        $categoria = $info_url['categoria'];
        $titulo = $info_url['titulo'];
        $contenido = $info_url['contenido'];
        $ruta_categoria = $this->ajustarRuta($categoria);
        $ruta_titulo = $this->ajustarRuta($titulo);

        if ($titulo !== "") {
            echo ' <script>document.title = "Sistema de Indicadores Sociales - ' . $categoria . ' - ' . $titulo . '"; </script>';
        } else {
            echo ' <script>document.title = "Sistema de Indicadores Sociales - ' . $categoria . '"; </script>';
        }

        $link = new UrlsModels();
        $resp = $link->urlsModel($url);
        include $resp;
    }

    /**
     * <b>consultarUrl</b>
     * <br>
     * Permite consultar la URL de una publicación
     */
    public function consultarUrl($url) {
        $link = new UrlsModels();
        return $link->consultarUrl($url);
    }

    /**
     * <b>ajustarRuta</b>
     * <br>
     * Realiza el saneamiento de un texto, reemplazando caracteres especiales
     * y dejando todo el texto en minúscula
     * @param $cadena Texto a sanear
     * @return $texto Texto sin caracteres especiales ni mayúsculas
     */
    public function ajustarRuta($cadena) {
        $texto = $cadena;
        $texto = str_replace(array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $texto);
        $texto = str_replace(array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $texto);
        $texto = str_replace(array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $texto);
        $texto = str_replace(array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $texto);
        $texto = str_replace(array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $texto);
        $texto = str_replace(array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $texto);
        $texto = str_replace(' de ', ' ', $texto);
        $texto = str_replace(' ', '-', $texto);
        $texto = trim(strtolower($texto));
        return $texto;
    }

}
