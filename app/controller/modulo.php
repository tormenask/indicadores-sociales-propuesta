<?php

class ModuloController {

    public function consultarModulos() {
        $modulo = new Modulo();
        $resp = $modulo->listarModulos();
        return $resp;
    }

    public function crearPanelModulo($idRol) {
        $rol = new Rol();
        $conjunto = new ConjuntoIndicadores();
        $modulo = new Modulo();
        $countConjuntos = $conjunto->contarConjuntosIndicadores();
        $idsConjuntos = $conjunto->consultarIdConjuntosIndicadores();
        $resp = $modulo->listarModulos();
        $count = 0;

        foreach ($resp as $row => $item) {
            if ($count % 3 == 0) {
                echo '
            <div class="row">
                <div class="col-md-12">';
            }
            $nombreModulo = $item["nombreModulo"];
            $disponibleConjuntos = $item["disponibleConjuntos"];
            $iconoModulo = $item["iconoModulo"];
            $abreviatura = $item["abreviatura"];
            if (!$disponibleConjuntos) {
                $permisos = $rol->consultarPermisoRol($nombreModulo, $idRol);
                $nombreModuloTitulo = $nombreModulo;
                if ($nombreModulo == "conjuntosIndicadores") {
                    $nombreModuloTitulo = "Conjuntos de indicadores";
                } elseif ($nombreModulo == "perfilesComunas") {
                    $nombreModuloTitulo = "Perfiles por comunas";
                } elseif ($nombreModulo == "fichasTecnicas") {
                    $nombreModuloTitulo = "Ficha técnica";
                } elseif ($nombreModulo == "seriesDatos") {
                    $nombreModuloTitulo = "Series de datos";
                }
                $crearVal = $permisos["crear"];
                $modificarVal = $permisos["modificar"];
                $eliminarVal = $permisos["eliminar"];
                $crear = ($crearVal == 1) ? "checked" : "";
                $modificar = ($modificarVal == 1) ? "checked" : "";
                $eliminar = ($eliminarVal == 1) ? "checked" : "";
                echo '  
                    <div class="col-md-4">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class = "active">
                                        <a href = "#tab' . $abreviatura . '" data-toggle = "tab">
                                            General
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="tab' . $abreviatura . '">
                                        <h4 class="text-center" style="background-color: #fff; color: #000 !important;">
                                            <i class="' . $iconoModulo . ' img-right"></i>
                                            ' . ucfirst($nombreModuloTitulo) . '
                                        </h4>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <div class="checkbox checbox-switch switch-info">
                                                        <label>
                                                            <input id="crear_' . $nombreModulo . '" 
                                                                name="crear_' . $nombreModulo . '"
                                                                type="checkbox"
                                                                ' . $crear . '/>
                                                            <span></span>
                                                            Crear
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checbox-switch switch-info">
                                                        <label>
                                                             <input id="modificar_' . $nombreModulo . '" 
                                                                name="modificar_' . $nombreModulo . '"
                                                                type="checkbox"
                                                                ' . $modificar . '/>
                                                            <span></span>
                                                            Modificar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="checkbox checbox-switch switch-info">
                                                        <label>
                                                            <input id="eliminar_' . $nombreModulo . '" 
                                                                name="eliminar_' . $nombreModulo . '"
                                                                type="checkbox"
                                                                ' . $eliminar . '/>
                                                            <span></span>
                                                            Eliminar
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="btn_confirm_' . $nombreModulo . '">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $("#btn_confirm_' . $nombreModulo . '").on("click", function () {
                            var nombreModulo = "' . $item["nombreModulo"] . '";
                            var crear = $("#crear_' . $nombreModulo . '").is(":checked") ? "1":"0";
                            var modificar = $("#modificar_' . $nombreModulo . '").is(":checked") ? "1":"0";
                            var eliminar = $("#eliminar_' . $nombreModulo . '").is(":checked") ? "1":"0";
                            var crearTxt = $("#crear_' . $nombreModulo . '").is(":checked") ? "Seleccionado":"No seleccionado";
                            var modificarTxt = $("#modificar_' . $nombreModulo . '").is(":checked") ? "Seleccionado":"No seleccionado";
                            var eliminarTxt = $("#eliminar_' . $nombreModulo . '").is(":checked") ? "Seleccionado":"No seleccionado";
                            $("#nombreModulo").val(nombreModulo);
                            document.getElementById("modal-content-create").innerHTML ="¿Confirma la edición de los permisos del modulo <b>" +nombreModulo +"</b>?<br><b>Crear:</b> " + crearTxt + "<br><b>Modificar:</b> " + modificarTxt + "<br><b>Eliminar:</b> " + eliminarTxt;
                            $("#modal-confirm").modal("show");
                        });
                    </script>';
            } else {
                echo '
                    <div class="col-md-4">
                        <div class="panel with-nav-tabs panel-primary">
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">';
                for ($i = 0; $i < $countConjuntos; $i++) {
                    $idConj = $idsConjuntos[$i]["idConjuntoIndicadores"];
                    if ($i == 0) {
                        echo '      <li class="active">
                                        <a href="#tab' . $idConj . '_' . $abreviatura . '" data-toggle="tab">
                                            ' . $idConj . '
                                        </a>
                                    </li>';
                    } else {
                        echo '      <li>
                                        <a href="#tab' . $idConj . '_' . $abreviatura . '" data-toggle="tab">
                                            ' . $idConj . '
                                        </a>
                                    </li>';
                    }
                }
                echo '
                                </ul>
                            </div>
                            <div class = "panel-body">
                                <div class = "tab-content">';
                for ($i = 0; $i < $countConjuntos; $i++) {
                    $idConj = $idsConjuntos[$i]["idConjuntoIndicadores"];
                    $permisos = $rol->consultarPermisoRol($nombreModulo . $idConj, $idRol);
                    $nombreModuloTitulo = $nombreModulo;
                    if ($nombreModulo == "conjuntosIndicadores") {
                        $nombreModuloTitulo = "Conjuntos de indicadores";
                    } elseif ($nombreModulo == "perfilesComunas") {
                        $nombreModuloTitulo = "Perfiles por comunas";
                    } elseif ($nombreModulo == "fichaTecnica") {
                        $nombreModuloTitulo = "Ficha técnica";
                    } elseif ($nombreModulo == "seriesDatos") {
                        $nombreModuloTitulo = "Series de datos";
                    }
                    $crearVal = $permisos["crear"];
                    $modificarVal = $permisos["modificar"];
                    $eliminarVal = $permisos["eliminar"];
                    $crear = ($crearVal == 1) ? "checked" : "";
                    $modificar = ($modificarVal == 1) ? "checked" : "";
                    $eliminar = ($eliminarVal == 1) ? "checked" : "";

                    if ($i == 0) {
                        echo '      <div class = "tab-pane fade in active" id = "tab' . $idConj . '_' . $abreviatura . '">';
                    } else {
                        echo '      <div class = "tab-pane fade in" id = "tab' . $idConj . '_' . $abreviatura . '">';
                    }
                    echo '              <h4 class = "text-center" style="background-color: #fff; color: #000 !important;">'
                    . '                    <i class = "' . $iconoModulo . ' img-right"></i>
                                            ' . ucfirst($nombreModuloTitulo) . '</h4>
                                        <div class = "panel panel-default">
                                            <div class = "panel-body">
                                                <div class = "form-group">
                                                    <div class = "checkbox checbox-switch switch-info">
                                                        <label>
                                                            <input id="crear_' . $nombreModulo . $idConj . '" 
                                                                name="crear_' . $nombreModulo . $idConj . '"
                                                                type="checkbox"
                                                                ' . $crear . '/>
                                                            <span></span>
                                                            Crear
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "form-group">
                                                    <div class = "checkbox checbox-switch switch-info">
                                                        <label>
                                                            <input id="modificar_' . $nombreModulo . $idConj . '" 
                                                                name="modificar_' . $nombreModulo . $idConj . '"
                                                                type="checkbox"
                                                                ' . $modificar . '/>
                                                            <span></span>
                                                            Modificar
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class = "form-group">
                                                    <div class = "checkbox checbox-switch switch-info">
                                                        <label>
                                                            <input id="eliminar_' . $nombreModulo . $idConj . '" 
                                                                name="eliminar_' . $nombreModulo . $idConj . '"
                                                                type="checkbox"
                                                                ' . $eliminar . '/>
                                                            <span></span>
                                                            Eliminar
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="btn_confirm_' . $nombreModulo . $idConj . '">Guardar</button>
                                    </div>
                                    <script>
                                        $("#btn_confirm_' . $nombreModulo . $idConj . '").on("click", function () {
                                            var nombreModulo = "' . $item["nombreModulo"] . $idConj . '";
                                            var crear = $("#crear_' . $nombreModulo . $idConj . '").is(":checked") ? "1":"0";
                                            var modificar = $("#modificar_' . $nombreModulo . $idConj . '").is(":checked") ? "1":"0";
                                            var eliminar = $("#eliminar_' . $nombreModulo . $idConj . '").is(":checked") ? "1":"0";
                                            var crearTxt = $("#crear_' . $nombreModulo . $idConj . '").is(":checked") ? "Seleccionado":"No seleccionado";
                                            var modificarTxt = $("#modificar_' . $nombreModulo . $idConj . '").is(":checked") ? "Seleccionado":"No seleccionado";
                                            var eliminarTxt = $("#eliminar_' . $nombreModulo . $idConj . '").is(":checked") ? "Seleccionado":"No seleccionado";
                                            $("#nombreModulo").val(nombreModulo);
                                            document.getElementById("modal-content-create").innerHTML ="¿Confirma la edición de los permisos del modulo <b>" +nombreModulo +"</b>?<br><b>Crear:</b> " + crearTxt + "<br><b>Modificar:</b> " + modificarTxt + "<br><b>Eliminar:</b> " + eliminarTxt;
                                            $("#modal-confirm").modal("show");
                                        });
                                    </script>';
                }
                echo '          </div>
                            </div>
                        </div>
                    </div>';
            }
            $count++;
            if ($count % 3 == 0) {
                echo '
                </div>
            </div>';
            }
        }
    }

    public function listarModulos() {
        $modulo = new Modulo();
        $resp = $modulo->listarModulos();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("modulos", $idRol);
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
                        "bSortable": false, "aTargets": [ 5, 6 ] , 
                        "bSearchable": false, "aTargets": [ 5, 6 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 5 ] , 
                        "bSearchable": false, "aTargets": [ 5 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 5 ] , 
                        "bSearchable": false, "aTargets": [ 5 ]
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
                <h3>Gestión de módulos</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/modulos/crearModulo" 
                            class="btn btn-primary" role="button">Crear módulo</a>
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
                            <th style="text-align:center;">Disponible para conjuntos de indicadores</th>
                            <th style="text-align:center;">Icono</th>
                            <th style="text-align:center;">Abreviatura</th>
                            ';
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
            $disp = "";

            if ($item["disponibleConjuntos"] == 1) {
                $disp = "Sí";
            } else {
                $disp = "No";
            }

            echo '
                        <tr>
                            <td id="prewrap" style="text-align:center;">' . $item["idModulo"] . '</td>
                            <td id="prewrap" >' . $item["nombreModulo"] . '</td>
                            <td id="prewrap" style="text-align:center;">' . $disp . '</td>
                            <td id="prewrap" style="text-align:center;"><i class="' . $item["iconoModulo"] . ' img-right"></i></td>
                            <td id="prewrap">' . $item["abreviatura"] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/modulos/editarModulo&mod=' . $item["idModulo"] . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/modulos/eliminarModulo&mod=' . $item["idModulo"] . '">
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

    public function crearModulo($nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura) {
        session_start();
        $nombreMod = "modulos";
        $modulo = new Modulo();
        $idMod = $modulo->consultarIdModuloPorNombre($nombreMod);
        $log = new LogController();
        $existeNombreModulo = $this->nombreModuloExiste($nombreModulo);
        if ($existeNombreModulo == FALSE) {
            $idModulo = NULL;
            $siguienteIdMod = $modulo->siguienteIdModulo()[0];
            $resp = $modulo->crearModulo($idModulo, $nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura);
            if ($resp == "Creado") {
                $log->crearLog($idMod, "Módulo " . $nombreModulo . ' creado correctamente.');
                $rol = new Rol();
                $conjunto = new ConjuntoIndicadores();
                $roles = $rol->listarIdsRoles();
                $conjuntos = $conjunto->listarConjuntosIndicadores();
                if ($disponibleConjuntos == "1") {
                    for ($i = 0; $i < count($conjuntos); $i++) {
                        for ($j = 0; $j < count($roles); $j++) {
                            $idConjunto = $conjuntos[$i]["idConjuntoIndicadores"];
                            $idRol = $roles[$j]["idRol"];
                            $nombreModuloPermiso = $nombreModulo . $idConjunto;
                            $respPermisos = $rol->crearPermisos($nombreModuloPermiso, $idRol, $siguienteIdMod);
                            if ($respPermisos == "Creado") {
                                $respPermisos = "Creado";
                            } else {
                                $respPermisos = "Error al crear";
                            }
                        }
                    }
                } else {
                    for ($j = 0; $j < count($roles); $j++) {
                        $idRol = $roles[$j]["idRol"];
                        $respPermisos = $rol->crearPermisos($nombreModulo, $idRol, $siguienteIdMod);
                        if ($respPermisos == "Creado") {
                            $respPermisos = "Creado";
                        } else {
                            $respPermisos = "Error al crear";
                        }
                    }
                }
                if ($respPermisos !== "Creado") {
                    $log->crearLog($idMod, "Error al crear permisos para el Módulo " . $nombreModulo . '.');
                    return "Error al crear";
                } else {
                    $log->crearLog($idMod, "Permisos para el Módulo " . $nombreModulo . ' creados correctamente.');
                    return "Creado";
                }
            } else {
                $log->crearLog($idMod, "Error al crear el Módulo " . $nombreModulo . '.');
                return "Error al crear";
            }
        } else {
            $log->crearLog($idMod, "Error al crear el Módulo " . $nombreModulo . '. Ya existe un módulo con este nombre.');
            return "Nombre modulo existe";
        }
    }

    public function nombreModuloExiste($nombreModulo) {
        $modulo = new Modulo();
        $existe = $modulo->nombreModuloExiste($nombreModulo);
        if ($existe["idModulo"] !== NULL && $existe["idModulo"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function idModuloExiste($idModulo) {
        $modulo = new Modulo();
        $existe = $modulo->idModuloExiste($idModulo);
        if ($existe["idModulo"] !== NULL && $existe["idModulo"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarModuloForm($idModulo) {
        $modulo = new Modulo();
        $respEditarModulo = $modulo->consultarModulo($idModulo);
        include 'view/modules/admin/modulos/formEditarModulo.php';
    }

    public function editarModulo($idModulo, $nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura) {
        session_start();
        $nombreMod = "modulos";
        $modulo = new Modulo();
        $idMod = $modulo->consultarIdModuloPorNombre($nombreMod);
        $log = new LogController();
        $existeIdModulo = $this->idModuloExiste($idModulo);
        $existeNombreModulo = $this->nombreModuloExiste($nombreModulo);
        $nombrePerteneceModulo = FALSE;
        $informacionModulo = $modulo->consultarModulo($idModulo);
        if (strcmp($informacionModulo["nombreModulo"], $nombreModulo) == 0) {
            $nombrePerteneceModulo = TRUE;
        }
        if ($existeIdModulo == TRUE) {
            if ($existeNombreModulo == TRUE) {
                if ($nombrePerteneceModulo == TRUE) {
                    $resp = $modulo->editarModulo($idModulo, $nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura);
                    if ($resp == "Editado") {
                        $log->crearLog($idMod, "Módulo " . $idModulo . ' editado correctamente.');
                        return "Editado";
                    } else {
                        $log->crearLog($idMod, "Error al editar el módulo " . $idModulo . '.');
                        return "Error al editar";
                    }
                } else {
                    $log->crearLog($idMod, "Error al editar el módulo " . $idModulo . '. Ya existe un módulo con este nombre.');
                    return "Nombre en uso";
                }
            } else {
                $resp = $modulo->editarModulo($idModulo, $nombreModulo, $disponibleConjuntos, $iconoModulo, $abreviatura);
                if ($resp == "Editado") {
                    $log->crearLog($idMod, "Módulo " . $idModulo . ' editado correctamente.');
                    return "Editado";
                } else {
                    $log->crearLog($idMod, "Error al editar el módulo " . $idModulo . '.');
                    return "Error al editar";
                }
            }
        } else {
            $log->crearLog($idMod, "Error al editar el módulo " . $idModulo . '. El Id no existe.');
            return "Id no existe";
        }
    }

    public function eliminarPermisosModulo($idModulo) {
        $rol = new Rol();
        $resp = $rol->eliminarPermisosModulo($idModulo);
        if ($resp == "Eliminado") {
            return "Eliminado";
        } else {
            return "Error al eliminar";
        }
    }

    public function eliminarModuloForm($idModulo) {
        $modulo = new Modulo();
        $respEliminarModulo = $modulo->consultarModulo($idModulo);
        include 'view/modules/admin/modulos/formEliminarModulo.php';
    }

    public function eliminarModulo($idModulo) {
        session_start();
        $nombreMod = "modulos";
        $modulo = new Modulo();
        $idMod = $modulo->consultarIdModuloPorNombre($nombreMod);
        $log = new LogController();
        $existeId = $this->idModuloExiste($idModulo);
        if ($existeId !== FALSE) {
            $resp = $this->eliminarPermisosModulo($idModulo);
            if ($resp == "Eliminado") {
                $log->crearLog($idMod, "Permisos para el módulo " . $idModulo . ' eliminados correctamente.');
                $resp2 = $modulo->eliminarModulo($idModulo);
                if ($resp2 == "Eliminado") {
                    $log->crearLog($idMod, "Módulo " . $idModulo . ' eliminado correctamente.');
                    return "Eliminado";
                } elseif ($resp == "1451") {
                    $log->crearLog($idMod, "Error 1451 al eliminar el módulo " . $idModulo . '.');
                    return "1451";
                } else {
                    $log->crearLog($idMod, "Error al eliminar el módulo " . $idModulo . '.');
                    return "Error al eliminar";
                }
            } else {
                $log->crearLog($idMod, "Error al eliminar permisos para el módulo " . $idModulo . '.');
                return "Error al eliminar";
            }
        } else {
            $log->crearLog($idMod, "Error al eliminar permisos para el módulo " . $idModulo . '. El Id no existe.');
            return "Id no existe";
        }
    }

}
