<?php

require_once 'connection.php';

class UrlsModels {

    public function urlsModel($link) {
        if (
            // $link == "quienes-somos/desarrollo-social" ||
                $link == "quienes-somos/estructura" ||
                $link == "quienes-somos/objetivos" ||
                $link == "quienes-somos/presentacion" ||
                $link == "quienes-somos/que-es" ||
                $link == "quienes-somos/ventajas" ||
                $link == "quienes-somos/analisis" ||
                $link == "informacion-interes/enlaces" ||
                $link == "informacion-interes/glosario" ||
                $link == "consulta-indicadores/opc/presentacion") {
            $module = "views/modules/publicaciones.php";
        } elseif ($link == "noticias") {
            $module = "views/modules/" . $link . ".php";
        } elseif ($link == "consulta-indicadores/dimensiones-sis") {
            $module = "views/modules/" . $link . "/index-dimensiones.php";
        } elseif ($link == "consulta-indicadores/dimensiones-sis/analisis") {
            $module = "views/modules/consulta-indicadores/dimensiones-sis/analisis-sis.php";
        } elseif ($link == "consulta-indicadores/dimensiones-sis/presentacion") {
            $module = "views/modules/consulta-indicadores/dimensiones-sis/presentacion-sis.php";
        } elseif ($link == "consulta-indicadores/dimensiones-sis/sobre-desarrollo") {
            $module = "views/modules/consulta-indicadores/dimensiones-sis/sobre-desarrollo-sis.php";

        } elseif ($link == "consulta-indicadores/dimensiones-sis-comunas/perfiles") {
            $module = "views/modules/consulta-indicadores/dimensiones-sis/perfiles-comunas.php";
        } elseif ($link == "consulta-indicadores/dimensiones-sis-comunas") {
            $module = "views/modules/consulta-indicadores/dimensiones-sis/index-comunas.php";
        } elseif ($link == "consulta-indicadores/igc") {
            $module = "views/modules/consulta-indicadores/igc/index-igc.php";
        } elseif ($link == "consulta-indicadores/igc/presentacion") {
            $module = "views/modules/consulta-indicadores/igc/presentacion.php";
        } elseif ($link == "consulta-indicadores/igc/estructura") {
            $module = "views/modules/consulta-indicadores/igc/estructura.php";
        } elseif ($link == "consulta-indicadores/exp") {
            $module = "views/modules/consulta-indicadores/exp/index-exp.php";
        } elseif ($link == "consulta-indicadores/exp/presentacion") {
            $module = "views/modules/consulta-indicadores/exp/presentacion.php";
        } elseif ($link == "consulta-indicadores/exp/indicadores") {
            $module = "views/modules/consulta-indicadores/exp/indicadores.php";
        // } elseif ($link == "consulta-indicadores/odraf") {
        //     $module = "views/modules/consulta-indicadores/odraf/index-odraf.php";
        // } elseif ($link == "consulta-indicadores/odraf/presentacion") {
        //     $module = "views/modules/consulta-indicadores/odraf/presentacion.php";
        // } elseif ($link == "consulta-indicadores/piia") {
        //     $module = "views/modules/consulta-indicadores/piia/index-piia.php";
        // } elseif ($link == "consulta-indicadores/piia/presentacion") {
        //     $module = "views/modules/consulta-indicadores/piia/presentacion.php";
        // } elseif ($link == "consulta-indicadores/piia/documentos-interes") {
        //     $module = "views/modules/consulta-indicadores/piia/documentos-interes.php";
        } elseif ($link == "consulta-indicadores/opc") {
            $module = "views/modules/consulta-indicadores/opc/index-opc.php";
        } elseif ($link == "consulta-indicadores/dadii") {
            $module = "views/modules/consulta-indicadores/dadii/index-dadii.php";
        } elseif ($link == "consulta-indicadores/dadii/presentacion") {
            $module = "views/modules/consulta-indicadores/dadii/presentacion.php";
        } elseif ($link == "consulta-indicadores/calidad-educativa") {
            $module = "views/modules/consulta-indicadores/calidad-educativa/index-calidad-educativa.php";
        } elseif ($link == "generar/exmu") {
            $module = "views/generar/exmu.php";
        } elseif ($link == "consulta-indicadores/ods") {
            $module = "views/modules/consulta-indicadores/ods/index-ods.php";
        } elseif ($link == "consulta-indicadores/ods/presentacion") {
            $module = "views/modules/consulta-indicadores/ods/presentacion.php";
        } elseif ($link == "consulta-indicadores/ods/seguimiento") {
            $module = "views/modules/consulta-indicadores/ods/seguimiento.php";
        } elseif ($link == "consulta-indicadores/ods/indicadores") {
            $module = "views/modules/consulta-indicadores/ods/indicadores.php";
        } elseif ($link == "consulta-indicadores/ods/metodologia") {
            $module = "views/modules/consulta-indicadores/ods/metodologia.php";
        } elseif ($link == "consulta-indicadores/ods/objetivos") {
            $module = "views/modules/consulta-indicadores/ods/objetivos.php";
        } elseif ($link == "consulta-indicadores/ods/ejecucion-presupuestal") {
            $module = "views/modules/consulta-indicadores/ods/ejecucion-presupuestal.php";
        } elseif ($link == "piramidePoblacional") {
            $module = "views/modules/home/piramidePoblacional.php";
        } elseif ($link == "perfilesComunas") {
            $module = "views/modules/consultaIndicadores/perfiles/comunas.php";
        } elseif ($link == "login") {
            $module = "app/index.php";
        } elseif ($link == "buscar") {
            $module = "views/modules/home/buscar.php";
        } elseif ($link == "cargarInformacion") {
            $module = "prev/modulo_gestion_informacion/carga_informacion.php";
        } elseif ($link == "index" || $link == "inicio") {
            $module = "views/modules/home.php";
        } else {
            $module = "";
            echo '<script>window.location.replace("/siscali");</script>';
        }
        return $module;
    }

    public function consultarUrl($url) {
        $stmt = Connection::connect()->prepare(""
                . "SELECT * "
                . "FROM urls "
                . "WHERE url=:url");
        $stmt->bindParam(":url", $url, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

}
