<?php

class PublicacionesController {

    public function listarPublicaciones($idConjunto) {
        $Publicaciones = new Publicaciones();
        $resp = $Publicaciones->listarPublicaciones($idConjunto);
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("publicaciones" . $idConjunto, $idRol);
        $crear = $permiso["crear"];
        $modificar = $permiso["modificar"];
        $eliminar = $permiso["eliminar"];
        if (!$crear && !$modificar && !$eliminar) {
            header("Location: index.php?action=admin/home");
        }
        echo ' 
        <script>
            $(document).ready(function() {
                $("#tablaConsulta").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                    }';
        if ($modificar && $eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 8, 9 ] , 
                        "bSearchable": false, "aTargets": [ 8, 9 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 8 ] , 
                        "bSearchable": false, "aTargets": [ 8 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 9 ] , 
                        "bSearchable": false, "aTargets": [ 9 ]
                    }]';
        }
        echo '   
                });
            });
        </script>
        <style>
            td#prewrap {white-space: pre-wrap;}
        </style>
       <div class="row">
            <div class="col-sm-12">
                <h3>Gestión de publicaciones</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/publicaciones/crearPublicaciones&conj=' . $idConjunto . '" 
                            class="btn btn-primary" role="button">Crear Publicación</a>
                        </div>
                    </div>
                </div>';
        }
        echo'
        <div class="row">
            <div class="col-sm-12">
                <table id="tablaConsulta" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Id url</th>
                            <th style="text-align:center;">Url</th>
                            <th style="text-align:center;">Categoría</th>
                            <th style="text-align:center;">Título</th>
                            <th style="text-align:center;">Descripción</th>
                            <th style="text-align:center;">Palabras claves</th>
                            <th style="text-align:center;">Contenido</th>
                            <th style="text-align:center;">Conjunto de indicadores</th>';
        if ($modificar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Editar</th>';
        }
        if ($eliminar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Eliminar</th>';
        }
        echo'           </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            $cont = $item["contenido"];
            $itemCont = htmlentities($cont);
            echo '
                        <tr>
                            <td id="prewrap" style="text-align:center;">' . $item["idUrl"] . '</td>
                            <td id="prewrap" style="text-align:center;">' . $item["url"] . '</td>
                                <td id="prewrap" style="text-align:center;">' . $item["categoria"] . '</td>
                                    <td id="prewrap" style="text-align:center;">' . $item["titulo"] . '</td>
                                        <td id="prewrap" style="text-align:center;">' . $item["descripcion"] . '</td>
                                            <td id="prewrap">' . $item["palabras_claves"] . '</td>
                                                <td id="prewrap">' . $itemCont . '</td>
                                                   <td id="prewrap">' . $item["idConjuntoIndicadores"] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/publicaciones/editarPublicaciones&publi=' . $item["idUrl"] . '&conj=' . $idConjunto . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/publicaciones/eliminarPublicaciones&publi=' . $item["idUrl"] . '&conj=' . $idConjunto . '">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>';
            }
            echo'       </tr>';
        }
        echo'
                    </tbody>
                </table>
            </div>
        </div>';
    }

    public function crearPublicaciones($urlPublicaciones, $categoriaPublicaciones, $tituloPublicaciones, $descripcionPublicaciones, $palabrasClavePublicaciones, $contenidoPublicaciones, $idConjuntoIndicadores) {
        session_start();
//       REALIZAR AJUSTE EN LA BASE DE DATO  PARA EL CAMPO CONTENIDO
        $modulo = new Modulo();
        $nombreModulo = "publicaciones";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $publicaciones = new Publicaciones();
        $idUrl = "";
        $resp = $publicaciones->crearPublicaciones($idUrl, $urlPublicaciones, $categoriaPublicaciones, $tituloPublicaciones, $descripcionPublicaciones, $palabrasClavePublicaciones, $contenidoPublicaciones, $idConjuntoIndicadores);
        if ($resp == "Creada") {
            $log->crearLog($idModulo, "Publicación " . $urlPublicaciones . ' creada correctamente.');
            return "Creada";
        } else {
            $log->crearLog($idModulo, "Error al crear la publicación " . $urlPublicaciones);
            return "Error al crear";
        }
    }

    public function editarPublicacionesForm($idUrl) {
        $publicaciones = new Publicaciones();
        $respEditarPublicaciones = $publicaciones->consultarPublicaciones($idUrl);
        $idConjuntoPublicaciones = $respEditarPublicaciones["idConjuntoIndicadores"];
        include 'view/modules/admin/publicaciones/formEditarPublicaciones.php';
    }

    public function editarPublicaciones($idUrl, $urlPublicacionesEd, $categoriaPublicacionesEd, $tituloPublicacionesEd, $descripcionPublicacionesEd, $palabrasClavePublicacionesEd, $contenidoPublicacionesEd, $conjuntoPublicacionesEd) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "publicaciones";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $publicaciones = new Publicaciones();
        $resp = $publicaciones->editarPublicaciones($idUrl, $urlPublicacionesEd, $categoriaPublicacionesEd, $tituloPublicacionesEd, $descripcionPublicacionesEd, $palabrasClavePublicacionesEd, $contenidoPublicacionesEd, $conjuntoPublicacionesEd);
        if ($resp == "Editada") {
            $log->crearLog($idModulo, "Publicación " . $idUrl . ' editada correctamente.');
            return "Editada";
        } else {
            $log->crearLog($idModulo, "Error al editar la publicación " . $idUrl);
            return "Error al editar";
        }
    }

    public function eliminarPublicacionesForm($idUrl) {
        $publicaciones = new Publicaciones();
        $respEliminarPublicaciones = $publicaciones->consultarPublicaciones($idUrl);
        $idConjuntoPublicaciones = $respEliminarPublicaciones["idConjuntoIndicadores"];
        include 'view/modules/admin/publicaciones/formEliminarPublicaciones.php';
    }

    public function eliminarPublicaciones($idUrlEl) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "publicaciones";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $publicaciones = new Publicaciones();
        $resp = $publicaciones->eliminarPublicaciones($idUrlEl);
        if ($resp == "Eliminada") {
            $log->crearLog($idModulo, "Publicación " . $idUrlEl . ' eliminada correctamente.');
            return "Eliminada";
        } else {
            $log->crearLog($idModulo, "Error al eliminar la publicación " . $idUrlEl);
            return "Error al eliminar";
        }
    }

}
