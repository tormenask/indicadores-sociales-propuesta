<?php

class IndicadorController {

    public function listarIndicadoresCrear($idConjuntoIndicadores) {
        $indicador = new Indicador();
        $resp = $indicador->listarIndicadoresPorConjunto($idConjuntoIndicadores);
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idIndicador"] . '">' . $item["nombreIndicador"] . $item["posicion"] . '</option>';
        }
    }

    public function listarIndicadores($idConjuntoIndicadores) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $ind = new Indicador();
        $resp = $ind->listarIndicadoresPorConjunto($idConjuntoIndicadores);
        $permiso = $rol->consultarPermisoRol("indicadores" . $idConjuntoIndicadores, $idRol);
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
                        "bSortable": false, "aTargets": [ 8 ] , 
                        "bSearchable": false, "aTargets": [ 8 ]
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
                <h3>Gestión de indicadores</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/indicadores/crearIndicador&conj=' . $idConjuntoIndicadores . '" 
                            class="btn btn-primary" role="button">Crear indicador</a>
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
                            <th style="text-align:center;">Temática</th>
                            <th style="text-align:center;">Posición</th>
                            <th style="text-align:center;">Mapa</th>
                            <th style="text-align:center;">Activado</th>';
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
            $tematica = new Tematica();
            $nombreDimension = $dimension->consultarNombreDimension($item["idDimension"]);
            $nombreTematica = $tematica->consultarNombreTematica($item["idTematica"]);
            $map = $item["mapa"];
            $itemMapa = htmlentities($map);
            $activado = "";
            if ($modificar) {
                if ($item["activado"] == 1) {
                    $activado = ' <button  type="button" onClick="dataUser(' . "'" . $item['idIndicador'] . "'" . ');" '
                            . 'id="btn-confirm" name="btn-confirm" class="btn btn-danger">Ocultar indicador</button>';
                } else {
                    $activado = ' <button  type="button" onClick="dataUser(' . "'" . $item['idIndicador'] . "'" . ');" '
                            . 'id="btn-confirm" name="btn-confirm" class="btn btn-primary">Mostrar indicador</button>';
                }
            } elseif ($item["activado"] == 1) {
                $activado = 'Indicador publicado';
            } else {
                $activado = 'Indicador oculto';
            }
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idIndicador"] . '</td>
                            <td id="prewrap">' . $item["nombreIndicador"] . '</td>
                            <td id="prewrap">' . $item["descripcionIndicador"] . '</td>
                            <td id="prewrap">' . $nombreDimension . '</td>
                            <td id="prewrap">' . $nombreTematica . '</td>   
                            <td id="prewrap">' . $item["posicion"] . '</td>   
                            <td id="prewrap">' . $itemMapa . '</td>
                            <td id="prewrap">' . $activado . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/indicadores/editarIndicador&ind=' . $item["idIndicador"] . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/indicadores/eliminarIndicador&ind=' . $item["idIndicador"] . '&conj=' . $idConjuntoIndicadores . '">
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
        </div>
        <script>
            function dataUser(idIndicadorAc) {
                var url = "view/modules/admin/indicadores/funcionesIndicadores.php";
                var data = new FormData();
                data.append("idIndicadorAc", idIndicadorAc);
                $.ajax({
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: "POST",
                    success: function (resp) {
                    location.reload();
                        console.log(resp);
                    }
                });
            }
        </script>';
    }

    public function listarIndicadoresEditarVariable($idConjuntoIndicadores, $idIndicador) {
        $indicador = new Indicador();
        $resp = $indicador->listarIndicadoresPorConjunto($idConjuntoIndicadores);
        foreach ($resp as $row => $item) {
            if ($idIndicador == $item["idIndicador"]) {
                echo '<option value="' . $item["idIndicador"] . '"selected>' . $item["nombreIndicador"] . '</option>';
            } else {
                echo '<option value="' . $item["idIndicador"] . '">' . $item["nombreIndicador"] . '</option>';
            }
        }
    }

    public function listarIndicadoresEditar($idTematica, $idIndicador) {
        $indicador = new Indicador();
        $resp = $indicador->listarIndicadoresPorTematica($idTematica);
        foreach ($resp as $row => $item) {
            if ($idIndicador == $item["idIndicador"]) {
                echo '<option value="' . $item["idIndicador"] . '"selected>' . $item["nombreIndicador"] . '</option>';
            } else {
                echo '<option value="' . $item["idIndicador"] . '">' . $item["nombreIndicador"] . '</option>';
            }
        }
    }

    public function crearIndicador($nombreIndicador, $descripcionIndicador, $idTematica, $posicion, $mapa) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "indicadores";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $indicador = new Indicador();
        $existeTematica = $this->existeTematica($idTematica);
        $existeIndicadorTematica = $this->existeIndicadorTematica(trim($nombreIndicador), $idTematica);
        $activado = 0;
        if ($existeTematica == TRUE) {
            if ($existeIndicadorTematica == FALSE) {
                $cantidadInd = $indicador->consultarUltimoId($idTematica);
                if (!empty($cantidadInd)) {
                    $consulta = explode('_I', $cantidadInd[0]);
                    $idIndicador = $idTematica . "_I" . ($consulta[1] + 1);
                } else {
                    $idIndicador = $idTematica . "_I" . "1";
                }
                $resp = $indicador->crearIndicador($idIndicador, $nombreIndicador, $descripcionIndicador, $idTematica, $posicion, $mapa, $activado);
                if ($resp == "Creado") {
                    $log->crearLog($idModulo, "Indicador " . $idIndicador . ' - ' . $nombreIndicador . ' de la temática ' . $idTematica . ' creado correctamente.');
                    return "Creado";
                } else {
                    $log->crearLog($idModulo, "Error al crear indicador " . $idIndicador . ' - ' . $nombreIndicador . ' de la temática ' . $idTematica . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear indicador " . $idIndicador . ' - ' . $nombreIndicador . ' de la temática ' . $idTematica . '. Ya existe un indicador con este nombre.');
                return "Nombre indicador en uso";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear indicador " . $idIndicador . ' - ' . $nombreIndicador . ' de la temática ' . $idTematica . '. No existe Id temática.');
            return "Id tematica no existe";
        }
    }

    public function editarIndicador($idIndicador, $nombreIndicador, $descripcionIndicador, $idTematica, $posicion, $mapa) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "indicadores";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $indicador = new Indicador();
        $existeTematica = $this->existeTematica($idTematica);
        $existeIdIndicador = $this->existeIdIndicador($idIndicador);
        $nombrePerteneceIndicador = FALSE;
        $informacionIndicador = $indicador->consultarIndicador($idIndicador);
        if (strcmp($informacionIndicador["nombreIndicador"], $nombreIndicador) == 0) {
            $nombrePerteneceIndicador = TRUE;
        }
        if ($existeTematica == TRUE) {
            if ($existeIdIndicador == TRUE) {
                if ($nombrePerteneceIndicador == TRUE) {
                    $resp = $indicador->editarIndicador($idIndicador, $nombreIndicador, $descripcionIndicador, $posicion, $mapa);
                    if ($resp == "Editado") {
                        $log->crearLog($idModulo, "Indicador " . $idIndicador . ' editado correctamente.');
                        return "Editado";
                    } else {
                        $log->crearLog($idModulo, "Error al editar Indicador " . $idIndicador . '.');
                        return "Error al editar";
                    }
                } else {
                    if ($this->existeIndicadorTematica($nombreIndicador, $idTematica) == FALSE) {
                        $resp = $indicador->editarIndicador($idIndicador, $nombreIndicador, $descripcionIndicador, $posicion, $mapa);
                        if ($resp == "Editado") {
                            $log->crearLog($idModulo, "Indicador " . $idIndicador . ' editado correctamente.');
                            return "Editado";
                        } else {
                            $log->crearLog($idModulo, "Error al editar Indicador " . $idIndicador . '.');
                            return "Error al editar";
                        }
                    } else {
                        $log->crearLog($idModulo, "Error al editar Indicador " . $idIndicador . '. Ya existe un indicador con el nombre ' . $nombreIndicador . '.');
                        return "Nombre indicador en uso";
                    }
                }
            } else {
                $log->crearLog($idModulo, "Error al editar Indicador " . $idIndicador . '. El Id del indicador no existe.');
                return "Id indicador no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al editar Indicador " . $idIndicador . '. El Id de la temática no existe.');
            return "Id tematica no existe";
        }
    }

    public function eliminarIndicador($idIndicador) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "indicadores";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $indicador = new Indicador();
        $existeId = $this->existeIdIndicador($idIndicador);
        $existeSerieDatos = $this->existeSerieDatosEnIndicador($idIndicador);
        if ($existeSerieDatos == FALSE) {
            if ($existeId !== FALSE) {
                $resp = $indicador->eliminarIndicador($idIndicador);
                if ($resp == "Eliminado") {
                    $log->crearLog($idModulo, "Indicador " . $idIndicador . ' eliminado correctamente.');
                    return "Eliminado";
                } elseif ($resp == "1451") {
                    $log->crearLog($idModulo, "Error 1451 al eliminar indicador " . $idIndicador . '.');
                    return "1451";
                } else {
                    $log->crearLog($idModulo, "Error al eliminar indicador " . $idIndicador . '.');
                    return "Error al eliminar";
                }
            } else {
                $log->crearLog($idModulo, "Error al eliminar indicador " . $idIndicador . '. El Id no existe.');
                return "Id indicador no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error 1451 al eliminar indicador " . $idIndicador . '.');
            return "1451";
        }
    }

    public function activarIndicador($idIndicadorAc) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "indicadores";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $indicador = new Indicador();
        $activado = $indicador->consultarActivo($idIndicadorAc);
        if ($activado == 1) {
            $activado = 0;
            $indicador->editarActivo($idIndicadorAc, $activado);
            $log->crearLog($idModulo, "Indicador " . $idIndicadorAc . ' activado.');
            return "0";
        } else {
            $activado = 1;
            $indicador->editarActivo($idIndicadorAc, $activado);
            $log->crearLog($idModulo, "Indicador " . $idIndicadorAc . ' desactivado.');
            return "1";
        }
    }

    public function existeSerieDatosEnIndicador($idIndicador) {
        $indicador = new Indicador();
        $existe = $indicador->indicadorTieneSerieDatos($idIndicador);
        $totalExiste = sizeof($existe);
        if ($totalExiste > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeTematica($idTematica) {
        $tematica = new Tematica();
        $existe = $tematica->idTematicaExiste($idTematica);
        if ($existe["idTematica"] !== NULL && $existe["idTematica"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIndicadorTematica($nombreIndicador, $idTematica) {
        $indicador = new Indicador();
        $existe = $indicador->nombreIndicadorExisteTematica($nombreIndicador, $idTematica);
        if ($existe["idIndicador"] !== NULL && $existe["idIndicador"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIdIndicador($idIndicador) {
        $indicador = new Indicador();
        $existe = $indicador->idIndicadorExiste($idIndicador);
        if ($existe["idIndicador"] !== NULL && $existe["idIndicador"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarIndicadorForm($idIndicador) {
        $indicador = new Indicador();
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEditarIndicador = $indicador->consultarIndicador($idIndicador);
        $respIdTematicaIndicador = $respEditarIndicador["idTematica"];
        $respIdDimensionIndicador = $tematica->consultarDimensionPorTematica($respIdTematicaIndicador)["idDimension"];
        $respIdConjuntoIndicador = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionIndicador)["idConjuntoIndicadores"];
        include 'view/modules/admin/indicadores/formEditarIndicador.php';
    }

    public function eliminarIndicadorForm($idIndicador) {
        $indicador = new Indicador();
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEliminarIndicador = $indicador->consultarIndicador($idIndicador);
        $respIdTematicaIndicador = $respEliminarIndicador["idTematica"];
        $respIdDimensionIndicador = $tematica->consultarDimensionPorTematica($respIdTematicaIndicador)["idDimension"];
        $respIdConjuntoIndicador = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionIndicador)["idConjuntoIndicadores"];
        include 'view/modules/admin/indicadores/formEliminarIndicador.php';
    }

    public function listarIndicadoresTematica($idTematica) {
        $indicador = new Indicador();
        $resp = $indicador->listarIndicadoresPorTematica($idTematica);
        echo '<option value="Seleccione">Seleccione un indicador</option>';
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idIndicador"] . '">' . $item["nombreIndicador"] . '</option>';
        }
    }

    public function listarIndicadoresTematicaDatos($idTematica) {
        $indicador = new Indicador();
        $resp = $indicador->listarIndicadoresPorTematica($idTematica);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['nombreIndicador'],
                "title" => $item['nombreIndicador'],
                "value" => $item['idIndicador'],
                "selected" => false);
        }
        echo json_encode($options);
    }

}
