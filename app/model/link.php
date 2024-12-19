<?php

class LinkModelBack {

    public function linksModelBack($link) {
        if ($link == "login" || $link == "admin/home" || $link=="admin/profile"
                || $link == "admin/iniciosesion/gestionIniciosesion"
                || $link == "admin/cambiarContrasena"
                || $link == "admin/cargarArchivo/gestionCargarArchivo"
                || $link == "admin/usuarios/registroUsuarios"
                || $link == "admin/usuarios/gestionUsuarios"
                || $link == "admin/usuarios/editarUsuario"
                || $link == "admin/usuarios/cambiarContrasenaRoot"
                || $link == "admin/usuarios/eliminarUsuario"
                || $link == "admin/roles/gestionRoles"
                || $link == "admin/roles/crearRol"
                || $link == "admin/roles/editarRol"
                || $link == "admin/roles/eliminarRol"
                || $link == "admin/roles/cambiarPermisos"
                || $link == "admin/conjuntosIndicadores/gestionConjuntosIndicadores"
                || $link == "admin/conjuntosIndicadores/crearConjunto"
                || $link == "admin/conjuntosIndicadores/editarConjunto"
                || $link == "admin/conjuntosIndicadores/eliminarConjunto"
                || $link == "admin/dimensiones/gestionDimensiones"
                || $link == "admin/dimensiones/crearDimension"
                || $link == "admin/dimensiones/editarDimension"
                || $link == "admin/dimensiones/eliminarDimension"
                || $link == "admin/tematicas/gestionTematicas"
                || $link == "admin/tematicas/crearTematica"
                || $link == "admin/tematicas/editarTematica"
                || $link == "admin/tematicas/eliminarTematica"
                || $link == "admin/indicadores/gestionIndicadores"
                || $link == "admin/indicadores/crearIndicador"
                || $link == "admin/indicadores/editarIndicador"
                || $link == "admin/indicadores/eliminarIndicador"
                || $link == "admin/seriesDatos/gestionSeriesDatos"
                || $link == "admin/seriesDatos/crearSerieDatos"
                || $link == "admin/seriesDatos/editarSerieDatos"
                || $link == "admin/seriesDatos/eliminarSerieDatos"
                || $link == "admin/fichasTecnicas/gestionFichasTecnicas"
                || $link == "admin/fichasTecnicas/crearFichaTecnica"
                || $link == "admin/fichasTecnicas/editarFichaTecnica"
                || $link == "admin/fichasTecnicas/eliminarFichaTecnica"
                || $link == "admin/datos/gestionDatos"
                || $link == "admin/perfiles/gestionPerfiles"
                || $link == "admin/documentos/gestionDocumentos"
                || $link == "admin/documentos/crearDocumento"
                || $link == "admin/documentos/editarDocumento"
                || $link == "admin/documentos/eliminarDocumento"
                || $link == "admin/estados/gestionEstados"
                || $link == "admin/estados/crearEstado"
                || $link == "admin/estados/editarEstado"
                || $link == "admin/estados/eliminarEstado"
                || $link == "admin/organismos/gestionOrganismos"
                || $link == "admin/organismos/crearOrganismo"
                || $link == "admin/organismos/editarOrganismo"
                || $link == "admin/organismos/eliminarOrganismo"
                || $link == "admin/modulos/gestionModulos"
                || $link == "admin/modulos/crearModulo"
                || $link == "admin/modulos/editarModulo"
                || $link == "admin/modulos/eliminarModulo"
                || $link == "admin/variables/gestionVariables"
                || $link == "admin/variables/crearVariable"
                || $link == "admin/variables/editarVariable"
                || $link == "admin/variables/eliminarVariable"
                || $link == "admin/variables/gestionDatosVariable"
                || $link == "admin/indicadoresvariables/gestionIndicadoresvariables"
                || $link == "admin/indicadoresvariables/crearIndicadorVariable"
                || $link == "admin/indicadoresvariables/editarIndicadorVariable"
                || $link == "admin/indicadoresvariables/eliminarIndicadorVariable"
                || $link == "admin/noticias/gestionNoticias"
                || $link == "admin/noticias/crearNoticias"
                || $link == "admin/noticias/editarNoticias"
                || $link == "admin/noticias/eliminarNoticias"
                || $link == "admin/publicaciones/gestionPublicaciones"
                || $link == "admin/publicaciones/crearPublicaciones"
                || $link == "admin/publicaciones/editarPublicaciones"
                || $link == "admin/publicaciones/eliminarPublicaciones"
                || $link == "admin/logs/gestionLogs"
                || $link == "admin/notificaciones/gestionNotificaciones"
                ) {
            $module = "view/modules/" . $link . ".php";
        } elseif ($link == "siscali/index") {
            $module = "view/modules/login.php";
        } elseif ($link == "siscali/recuperar-contrasena") {
            $module = "view/modules/recuperar.php";
        } elseif ($link == "siscali/app") {
            $module = "view/modules/login.php";
        } elseif ($link == "siscali/admin/salir") {
            $module = "view/modules/salir.php";
        } elseif ($link == "siscali/admin/gestionIndicadores") {
            $module = "view/modules/administracion/indicadores/gestionIndicadores.php";
        } elseif ($link == "siscali/login/error") {
            $module = "view/modules/error.php";
        } else {
            $module = "view/modules/login.php";
        }
        return $module;
    }

}
