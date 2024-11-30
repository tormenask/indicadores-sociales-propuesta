<?php

class TematicaController {

    public function listarTematicas($idConjuntoIndicadores) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $tem = new Tematica();
        $resp = $tem->listarTematicasPorConjunto($idConjuntoIndicadores);
        $permiso = $rol->consultarPermisoRol("tematicas" . $idConjuntoIndicadores, $idRol);
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
                <h3>Gestión de temáticas</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/tematicas/crearTematica&conj=' . $idConjuntoIndicadores . '" 
                            class="btn btn-primary" role="button">Crear temática</a>
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
                            <th style="text-align:center;">Dimensión</th>
                            <th style="text-align:center;">Posición</th>';
        if ($modificar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Editar</th>';
        }
        if ($eliminar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Eliminar</th>';
        }
        echo '          </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            $dimension = new Dimension();
            $nombreDimension = $dimension->consultarNombreDimension($item["idDimension"]);
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idTematica"] . '</td>
                            <td id="prewrap">' . $item["nombreTematica"] . '</td>
                            <td id="prewrap">' . $item["descripcionTematica"] . '</td>
                            <td id="prewrap">' . $nombreDimension . '</td>
                            <td id="prewrap">' . $item["posicion"] . '</td> ';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/tematicas/editarTematica&tem=' . $item["idTematica"] . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/tematicas/eliminarTematica&tem=' . $item["idTematica"] . '&conj=' . $idConjuntoIndicadores . '">
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

    public function crearTematica($nombreTematica, $descripcionTematica, $idDimension, $posicion) {
        session_start();
        $notificacion = new NotificacionController();
        $modulo = new Modulo();
        $nombreModulo = "tematicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $tematica = new Tematica();
        $existeDimension = $this->existeDimension($idDimension);
        $existeTematicaDimension = $this->existeTematicaDimension($nombreTematica, $idDimension);
        if ($existeDimension == TRUE) {
            if ($existeTematicaDimension == FALSE) {
                $cantidadTem = $tematica->consultarUltimoId($idDimension);
                if (!empty($cantidadTem)) {
                    $consulta = explode('_T', $cantidadTem[0]);
                    $idTematica = $idDimension . "_T" . ($consulta[1] + 1);
                } else {
                    $idTematica = $idDimension . "_T" . "1";
                }
                $resp = $tematica->crearTematica($idTematica, $nombreTematica, $descripcionTematica, $idDimension, $posicion);
                if ($resp == "Creada") {
                    $log->crearLog($idModulo, "Temática " . $idTematica . ' - ' . $nombreTematica . ' de la dimensión ' . $idDimension . ' creada correctamente.');
                    $notificacion->crearNotificacion("Temática " . $idTematica . ' - ' . $nombreTematica . ' de la dimensión ' . $idDimension . ' creada correctamente.');
                    return "Creada";
                } else {
                    $log->crearLog($idModulo, "Error al crear la temática " . $idTematica . ' - ' . $nombreTematica . ' de la dimensión ' . $idDimension . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear la temática " . $idTematica . ' - ' . $nombreTematica . ' de la dimensión ' . $idDimension . '. Nombre temática ya existe en dimensión.');
                return "Nombre tematica en uso";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear la temática " . $idTematica . ' - ' . $nombreTematica . ' de la dimensión ' . $idDimension . '. Id dimensión no existe.');
            return "Id dimension no existe";
        }
    }

    public function editarTematica($idTematica, $nombreTematica, $descripcionTematica, $idDimension, $posicion) {
        session_start();
        $notificacion = new NotificacionController();
        $modulo = new Modulo();
        $nombreModulo = "tematicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $tematica = new Tematica();
        $existeDimension = $this->existeDimension($idDimension);
        $existeIdTematica = $this->existeIdTematica($idTematica);
        $nombrePerteneceTematica = FALSE;
        $informacionTematica = $tematica->consultarTematica($idTematica);
        if (strcmp($informacionTematica["nombreTematica"], $nombreTematica) == 0) {
            $nombrePerteneceTematica = TRUE;
        }
        if ($existeDimension == TRUE) {
            if ($existeIdTematica == TRUE) {
                if ($nombrePerteneceTematica == TRUE) {
                    $resp = $tematica->editarTematica($idTematica, $nombreTematica, $descripcionTematica, $posicion);
                    if ($resp == "Editada") {
                        $log->crearLog($idModulo, "Temática " . $idTematica . ' editada correctamente.');
                        $notificacion->crearNotificacion("Dimensión " . $idDimension . ' de la dimensión ' . $idDimension . ' ha sido editada.');
                        return "Editada";
                    } else {
                        return "Error al editar";
                    }
                } else {
                    if ($this->existeTematicaDimension($nombreTematica, $idDimension) == FALSE) {
                        $resp = $tematica->editarTematica($idTematica, $nombreTematica, $descripcionTematica, $posicion);
                        if ($resp == "Editada") {
                            $log->crearLog($idModulo, "Temática " . $idTematica . ' editada correctamente.');
                            $notificacion->crearNotificacion("Dimensión " . $idDimension . ' de la dimensión ' . $idDimension . ' ha sido editada.');
                            return "Editada";
                        } else {
                            $log->crearLog($idModulo, "Error al editar temática " . $idTematica);
                            return "Error al editar";
                        }
                    } else {
                        $log->crearLog($idModulo, "Error al editar temática " . $idTematica . '. Nombre de la temática ya existe en dimensión.');
                        return "Nombre tematica en uso";
                    }
                }
            } else {
                $log->crearLog($idModulo, "Error al editar temática " . $idTematica . '. Id de la temática no existe.');
                return "Id tematica no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al editar temática " . $idTematica . '. Id de la dimensión no existe.');
            return "Id dimension no existe";
        }
    }

    public function eliminarTematica($idTematica) {
        session_start();
        $notificacion = new NotificacionController();
        $modulo = new Modulo();
        $nombreModulo = "tematicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $tematica = new Tematica();
        $existeId = $this->existeIdTematica($idTematica);
        $existeIndicador = $this->existeIndicadorEnTematica($idTematica);
        if ($existeIndicador == FALSE) {
            if ($existeId !== FALSE) {
                $resp = $tematica->eliminarTematica($idTematica);
                if ($resp == "Eliminada") {
                    $log->crearLog($idModulo, "Temática " . $idTematica . ' eliminada correctamente.');
                    $notificacion->crearNotificacion("Temática " . $idTematica . ' eliminada');
                    return "Eliminada";
                } elseif ($resp == "1451") {
                    $log->crearLog($idModulo, "Error 1451 al eliminar temática " . $idTematica);
                    return "1451";
                } else {
                    $log->crearLog($idModulo, "Error al eliminar temática " . $idTematica);
                    return "Error al eliminar";
                }
            } else {
                $log->crearLog($idModulo, "Error al eliminar temática " . $idTematica . '. Id temática no existe.');
                return "Id tematica no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error 1451 al eliminar temática " . $idTematica);
            return "1451";
        }
    }

    public function existeDimension($idDimension) {
        $dimension = new Dimension();
        $existe = $dimension->idDimensionExiste($idDimension);
        if ($existe["idDimension"] !== NULL && $existe["idDimension"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIndicadorEnTematica($idTematica) {
        $tematica = new Tematica();
        $existe = $tematica->TematicaTieneIndicador($idTematica);
        $totalExiste = sizeof($existe);
        if ($totalExiste > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeTematicaDimension($nombreTematica, $idDimension) {
        $tematica = new Tematica();
        $existe = $tematica->nombreTematicaExisteDimension($nombreTematica, $idDimension);
        if ($existe["idTematica"] !== NULL && $existe["idTematica"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIdTematica($idTematica) {
        $tematica = new Tematica();
        $existe = $tematica->idTematicaExiste($idTematica);
        if ($existe["idTematica"] !== NULL && $existe["idTematica"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarTematicaForm($idTematica) {
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEditarTematica = $tematica->consultarTematica($idTematica);
        $respIdDimensionTematica = $respEditarTematica["idDimension"];
        $respIdConjuntoTematica = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionTematica)["idConjuntoIndicadores"];
        include 'view/modules/admin/tematicas/formEditarTematica.php';
    }

    public function eliminarTematicaForm($idTematica) {
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEliminarTematica = $tematica->consultarTematica($idTematica);
        $respIdDimensionTematica = $respEliminarTematica["idDimension"];
        $respIdConjuntoTematica = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionTematica)["idConjuntoIndicadores"];
        include 'view/modules/admin/tematicas/formEliminarTematica.php';
    }

    public function listarTematicasDimension($idDimension) {
        $tematica = new Tematica();
        $resp = $tematica->listarTematicasDimension($idDimension);
        echo '<option value="Seleccione">Seleccione una temática</option>';
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idTematica"] . '">' . $item["nombreTematica"] . '</option>';
        }
    }

    public function listarTematicasDimensionDatos($idDimension) {
        $tematica = new Tematica();
        $resp = $tematica->listarTematicasDimension($idDimension);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['nombreTematica'],
                "title" => $item['nombreTematica'],
                "value" => $item['idTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function listarTematicasEditar($idDimension, $idTematica) {
        $tematica = new Tematica();
        $resp = $tematica->listarTematicasDimension($idDimension);
        foreach ($resp as $row => $item) {
            if ($idTematica == $item["idTematica"]) {
                echo '<option value="' . $item["idTematica"] . '"selected>' . $item["nombreTematica"] . '</option>';
            } else {
                echo '<option value="' . $item["idTematica"] . '">' . $item["nombreTematica"] . '</option>';
            }
        }
    }

}
