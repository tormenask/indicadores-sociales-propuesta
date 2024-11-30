<?php

class ConjuntoIndicadoresController {

    public function listarConjuntosIndicadores() {
        $conjunto = new ConjuntoIndicadores();
        $resp = $conjunto->listarConjuntosIndicadores();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $nombreModulo = "conjuntosIndicadores";
        $permiso = $rol->consultarPermisoRol($nombreModulo, $idRol);
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
                        "bSortable": false, "aTargets": [ 4, 5 ] , 
                        "bSearchable": false, "aTargets": [ 4, 5 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 4 ] , 
                        "bSearchable": false, "aTargets": [ 4 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 4 ] , 
                        "bSearchable": false, "aTargets": [ 4 ]
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
                <h3>Gestión de conjuntos de indicadores</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/conjuntosIndicadores/crearConjunto" 
                            class="btn btn-primary" role="button">Crear conjunto de indicadores</a>
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
                            <th style="text-align:center;">Id</th>
                            <th style="text-align:center;">Nombre</th>
                            <th style="text-align:center;">Descripción</th>
                            <th style="text-align:center;">Organismo</th>';
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
            $org = new Organismo();
            $organismoConjunto = $org->consultarNombreOrganismo($item["idOrganismoConjuntoIndicadores"]);
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idConjuntoIndicadores"] . '</td>
                            <td id="prewrap">' . $item["nombreConjuntoIndicadores"] . '</td>
                            <td id="prewrap">' . $item["descripcionConjuntoIndicadores"] . '</td>
                            <td id="prewrap">' . $organismoConjunto . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/conjuntosIndicadores/editarConjunto&conj=' . $item["idConjuntoIndicadores"] . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/conjuntosIndicadores/eliminarConjunto&conj=' . $item["idConjuntoIndicadores"] . '">
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

    public function crearPermisosConjunto($idConjunto) {
        $modulo = new Modulo();
        $nombreModuloLog = "conjuntosIndicadores";
        $idModuloLog = $modulo->consultarIdModuloPorNombre($nombreModuloLog);
        $log = new LogController();
        $rol = new Rol();
        $roles = $rol->listarIdsRoles();
        $modulos = $modulo->listarModulosDisponiblesConjuntos();
        $resp = "";
        for ($i = 0; $i < count($roles); $i++) {
            $idRol = $roles[$i]["idRol"];
            for ($j = 0; $j < count($modulos); $j++) {
                $nombreModulo = $modulos[$j]["nombreModulo"] . $idConjunto;
                $idModulo = $modulos[$j]["idModulo"] . $idConjunto;
                $resp = $rol->crearPermisos($nombreModulo, $idRol, $idModulo);
                if ($resp == "Creado") {
                    $log->crearLog($idModuloLog, "Permiso " . $nombreModulo . ' - ' . $idModulo . ' creado');
                    $resp = "Creado";
                } else {
                    $log->crearLog($idModuloLog, "Error al crear el permiso " . $nombreModulo . ' - ' . $idModulo);
                    $resp = "Error al crear";
                }
            }
        }
        return $resp;
    }

    public function crearConjunto($idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto) {
        session_start();
        $modulo = new Modulo();
        $notificacion = new NotificacionController();
        $log = new LogController();
        $conjunto = new ConjuntoIndicadores();
        $nombreModuloLog = "conjuntosIndicadores";
        $idModuloLog = $modulo->consultarIdModuloPorNombre($nombreModuloLog);

        $existeIdConjunto = $this->existeIdConjunto($idConjunto);
        if ($existeIdConjunto == FALSE) {
            $resp = $conjunto->crearConjuntoIndicadores($idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto);
            if ($resp == "Creado") {
                $notificacion->crearNotificacion('Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' creado.');
                $log->crearLog($idModuloLog, 'Conjunto de indicadores ' . $nombreConjunto . ' creado.');
                $resp2 = $this->crearPermisosConjunto($idConjunto);
                if ($resp2 == "Creado") {
                    $notificacion->crearNotificacion('Permisos para el Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' creados.');
                    $log->crearLog($idModuloLog, 'Permisos para el Conjunto de indicadores ' . $nombreConjunto . ' creados.');
                    $resp3 = $this->crearCarpeta($idConjunto);
                    if ($resp3 == "Creado") {
                        $notificacion->crearNotificacion('Carpeta para el Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' creada.');
                        $log->crearLog($idModuloLog, 'Carpeta para el Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' creada.');
                        return "Creado";
                    }
                } else {
                    $notificacion->crearNotificacion('Error al crear permisos del Conjunto  ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                    $log->crearLog($idModuloLog, 'Error al crear permisos del Conjunto  ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                    return "Error al crear";
                }
            } else {
                $notificacion->crearNotificacion('Error al crear el Conjunto  ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                $log->crearLog($idModuloLog, 'Error al crear el Conjunto  ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                return "Error al crear";
            }
        } else {
            $notificacion->crearNotificacion('Error al crear el Conjunto  ' . $idConjunto . ' - ' . $nombreConjunto . '. ID existe.');
            $log->crearLog($idModuloLog, 'Error al crear el Conjunto  ' . $idConjunto . ' - ' . $nombreConjunto . '. ID existe.');
            return "Id conjunto existe";
        }
    }

    public function crearCarpeta($idConjunto) {
        $carpeta = $_SERVER['DOCUMENT_ROOT'] . "/app/controller/documentos/" . $idConjunto;
        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777);
            return "Creado";
        } else {
            return "Error al crear";
        }
    }

    public function existeIdConjunto($idConjunto) {
        $conjunto = new ConjuntoIndicadores();
        $existe = $conjunto->idConjuntoExiste($idConjunto);
        if ($existe["idConjuntoIndicadores"] !== NULL && $existe["idConjuntoIndicadores"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarConjuntoForm($idConjunto) {
        $conjunto = new ConjuntoIndicadores();
        $respEditarConjunto = $conjunto->consultarConjuntoIndicadores($idConjunto);
        include 'view/modules/admin/conjuntosIndicadores/formEditarConjunto.php';
    }

    public function editarConjunto($idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto) {
        session_start();
        $modulo = new Modulo();
        $notificacion = new NotificacionController();
        $log = new LogController();
        $conjunto = new ConjuntoIndicadores();
        $nombreModuloLog = "conjuntosIndicadores";
        $idModuloLog = $modulo->consultarIdModuloPorNombre($nombreModuloLog);
        $existeId = $this->existeIdConjunto($idConjunto);
        if ($existeId) {
            $resp = $conjunto->editarConjunto($idConjunto, $nombreConjunto, $descripcionConjunto, $idOrganismoConjunto);
            if ($resp == "Editado") {
                $notificacion->crearNotificacion('Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' editado.');
                $log->crearLog($idModuloLog, 'Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' editado. La nueva información es: ' . $idConjunto . ' - ' . $nombreConjunto . ' - ' . $descripcionConjunto . ' - ' . $idOrganismoConjunto);
                return "Editado";
            } else {
                $notificacion->crearNotificacion('Error al editar el conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                $log->crearLog($idModuloLog, 'Error al editar el conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                return "Error al editar";
            }
        } else {
            $notificacion->crearNotificacion('Error al editar el conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '. ID no existe.');
            $log->crearLog($idModuloLog, 'Error al editar el conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '. ID no existe.');
            return "Id no existe";
        }
    }

    public function eliminarConjuntoForm($idConjunto) {
        $conjunto = new ConjuntoIndicadores();
        $respEliminarConjunto = $conjunto->consultarConjuntoIndicadores($idConjunto);
        include 'view/modules/admin/conjuntosIndicadores/formEliminarConjunto.php';
    }

    public function eliminarConjunto($idConjunto) {
        session_start();
        $modulo = new Modulo();
        $notificacion = new NotificacionController();
        $log = new LogController();
        $conjunto = new ConjuntoIndicadores();
        $nombreModuloLog = "conjuntosIndicadores";
        $idModuloLog = $modulo->consultarIdModuloPorNombre($nombreModuloLog);
        $nombreConjunto = $conjunto->consultarNombreConjuntoIndicadores($idConjunto);
        $existeId = $this->existeIdConjunto($idConjunto);
        $existeDimension = $this->existeDimensionEnConjunto($idConjunto);
        if ($existeDimension == FALSE) {
            if ($existeId !== FALSE) {
                $resp1 = $this->eliminarPermisosConjunto($idConjunto);
                if ($resp1 == "Eliminado") {
                    $resp = $conjunto->eliminarConjunto($idConjunto);
                    $notificacion->crearNotificacion('Permisos del Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' eliminada.');
                    $log->crearLog($idModuloLog, 'Permisos del Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' eliminado.');
                    if ($resp == "Eliminado") {
                        $notificacion->crearNotificacion('Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' eliminado.');
                        $log->crearLog($idModuloLog, 'Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' eliminado.');
                        $resp3 = $this->eliminarCarpeta($idConjunto);
                        if ($resp3 == "Eliminado") {
                            $notificacion->crearNotificacion('Carpeta del Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' eliminada.');
                            $log->crearLog($idModuloLog, 'Carpeta del Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . ' eliminado.');
                            return "Eliminado";
                        } else {
                            $notificacion->crearNotificacion('Error al eliminar carpeta del Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                            $log->crearLog($idModuloLog, 'Error al eliminar carpeta del Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                            return "Error al eliminar";
                        }
                        return "Eliminado";
                    } elseif ($resp == "1451") {
                        $notificacion->crearNotificacion('Error 1451 al eliminar carpeta del Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                        $log->crearLog($idModuloLog, 'Error 1451 al eliminar carpeta del Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                        return "1451";
                    } else {
                        $notificacion->crearNotificacion('Error al eliminar el Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                        $log->crearLog($idModuloLog, 'Error al eliminar el Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                        return "Error al eliminar";
                    }
                } else {
                    $notificacion->crearNotificacion('Error al eliminar permisos del Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                    $log->crearLog($idModuloLog, 'Error al eliminar permisos del Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
                    return "Error al eliminar";
                }
            } else {
                $notificacion->crearNotificacion('Error al eliminar carpeta del Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '. ID no existe.');
                $log->crearLog($idModuloLog, 'Error al eliminar carpeta del Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '. ID no existe.');
                return "Id no existe";
            }
        } else {
            $notificacion->crearNotificacion('Error 1451 al eliminar carpeta del Conjunto  de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
            $log->crearLog($idModuloLog, 'Error 1451 al eliminar carpeta del Conjunto de indicadores ' . $idConjunto . ' - ' . $nombreConjunto . '.');
            return "1451";
        }
    }

    public function existeDimensionEnConjunto($idConjunto) {
        $conjunto = new ConjuntoIndicadores();
        $existe = $conjunto->conjuntoTieneDimension($idConjunto);
        $totalExiste = sizeof($existe);
        if ($totalExiste > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function eliminarCarpeta($idConjunto) {
        $carpeta = $_SERVER['DOCUMENT_ROOT'] . "/app/controller/documentos/" . $idConjunto;

        function rmdir_recursive($carpeta) {
            $files = scandir($carpeta);
            array_shift($files);
            array_shift($files);
            foreach ($files as $file) {
                $file = $carpeta . '/' . $file;
                if (is_dir($file)) {
                    rmdir_recursive($file);
                    rmdir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($carpeta);
        }

        rmdir_recursive($carpeta);
        return "Eliminado";
    }

    public function eliminarPermisosConjunto($idConjunto) {
        $modulo = new Modulo();
        $nombreModuloLog = "conjuntosIndicadores";
        $idModuloLog = $modulo->consultarIdModuloPorNombre($nombreModuloLog);
        $log = new LogController();
        $rol = new Rol();
        $resp = $rol->eliminarPermisosConjunto($idConjunto);
        if ($resp == "Eliminado") {
            $log->crearLog($idModuloLog, "Permisos para el conjunto de indicadores " . $idConjunto . ' eliminados');
            return "Eliminado";
        } else {
            $log->crearLog($idModuloLog, "Error al eliminar los permisos para el conjunto de indicadores " . $idConjunto);
            return "Error al eliminar";
        }
    }

    public function listarConjuntosCrear() {
        $conjunto = new ConjuntoIndicadores();
        $resp = $conjunto->listarConjuntosIndicadores();
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idConjuntoIndicadores"] . '">' . $item["nombreConjuntoIndicadores"] . '</option>';
        }
    }

    public function listarConjuntosEditar($idConjunto) {
        $conjunto = new ConjuntoIndicadores();
        $resp = $conjunto->listarConjuntosIndicadores();
        foreach ($resp as $row => $item) {
            if ($idConjunto == $item["idConjuntoIndicadores"]) {
                echo '<option value="' . $item["idConjuntoIndicadores"] . '" selected>' . $item["nombreConjuntoIndicadores"] . '</option>';
            } else {
                echo '<option value="' . $item["idConjuntoIndicadores"] . '">' . $item["nombreConjuntoIndicadores"] . '</option>';
            }
        }
    }

    public function consultarConjuntosIndicadores() {
        $conjunto = new ConjuntoIndicadores();
        $resp = $conjunto->listarConjuntosIndicadores();
        return $resp;
    }

}
