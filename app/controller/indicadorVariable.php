<?php

class IndicadorVariableController {

    public function listarIndicadoresVariables($idConjunto) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $indv = new IndicadorVariable();
        $resp = $indv->listarIndicadoresVariablesPorConjunto($idConjunto);
        $permiso = $rol->consultarPermisoRol("indicadoresvariables" . $idConjunto, $idRol);
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
                <h3>Gestión de relaciones Indicadores - Variables</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/indicadoresvariables/crearIndicadorVariable&conj=' . $idConjunto . '" 
                            class="btn btn-primary" role="button">Crear relación</a>
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
                            <th style="text-align:center;">Nombre Indicador</th>
                            <th style="text-align:center;">Nombre variable</th>
                            <th style="text-align:center;">Tipo variable</th>';
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
            $indicador = new Indicador();
            $variable = new Variable();
            $nombreIndicador = $indicador->consultarNombreIndicador($item['idIndicador']);
            $informacionVariable = $variable->consultarVariable($item['idVariable']);
            echo '
                        <tr>
                            <td id="prewrap">' . $item["id"] . '</td>
                            <td id="prewrap">' . $nombreIndicador . '</td>
                            <td id="prewrap">' . $informacionVariable['nombreVariable'] . '</td>
                            <td id="prewrap">' . $informacionVariable['tipoDato'] . '</td>';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/indicadoresvariables/editarIndicadorVariable&indV=' . $item["id"] . '&conj=' . $idConjunto . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/indicadoresvariables/eliminarIndicadorVariable&indV=' . $item["id"] . '&conj=' . $idConjunto . '">
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

    public function crearRelacion($idIndicador, $idVariable) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "indicadoresvariables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $indV = new IndicadorVariable();
        $indicador = new Indicador();
        $variable = new Variable();
        $existeVariable = $variable->idVariableExiste($idVariable);
        $existeIndicador = $indicador->idIndicadorExiste($idIndicador);
        $informacionVariable = $variable->consultarVariable($idVariable);
        $tipoVariable = $informacionVariable["tipoDato"];
        $relacionesIndicador = $indV->consultarRelacionesPorIndicador($idIndicador);
        $existeTipoDato = FALSE;
        if (!empty($existeVariable)) {
            if (!empty($existeIndicador)) {
                if (!empty($relacionesIndicador)) {
                    foreach ($relacionesIndicador as $key => $value) {
                        $idVarTemp = $value["idVariable"];
                        $tipoDatoTemp = $variable->consultarVariable($idVarTemp)['tipoDato'];
                        if ($idVariable === $idVarTemp) {
                            $log->crearLog($idModulo, "Error al crear relación " . $idIndicador . ' - ' . $idVariable . '. Ya existe la relación.');
                            return 'Relacion existe';
                        } else {
                            if ($tipoVariable === $tipoDatoTemp) {
                                $log->crearLog($idModulo, "Error al crear relación " . $idIndicador . ' - ' . $idVariable . '. Ya existe el tipo de dato (numerador o denominador).');
                                return 'Tipo dato existe';
                            } else {
                                $id = NULL;
                                $resp = $indV->crearRelacion($id, $idIndicador, $idVariable);
                                if ($resp == "Creada") {
                                    $log->crearLog($idModulo, "Relación " . $idIndicador . ' - ' . $idVariable . ' creada correctamente.');
                                    return "Creada";
                                } else {
                                    $log->crearLog($idModulo, "Error al crear relación " . $idIndicador . ' - ' . $idVariable . '.');
                                    return "Error al crear";
                                }
                            }
                        }
                    }
                } else {
                    $id = NULL;
                    $resp = $indV->crearRelacion($id, $idIndicador, $idVariable);
                    if ($resp == "Creada") {
                        $log->crearLog($idModulo, "Relación" . $idIndicador . ' - ' . $idVariable . ' creada correctamente.');
                        return "Creada";
                    } else {
                        $log->crearLog($idModulo, "Error al crear relación" . $idIndicador . ' - ' . $idVariable . '.');
                        return "Error al crear";
                    }
                }
            } else {
                $log->crearLog($idModulo, "Error al crear relación" . $idIndicador . ' - ' . $idVariable . '. Id indicador no existe.');
                return "Id indicador no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear relación" . $idIndicador . ' - ' . $idVariable . '. Id variable no existe.');
            return "Id variable no existe";
        }
    }

    public function eliminarRelacion($idIndV) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "indicadoresvariables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $indV = new IndicadorVariable();
        $existeId = $this->existeIdRelacion($idIndV);
        if ($existeId !== FALSE) {
            $resp = $indV->eliminarRelacion($idIndV);
            if ($resp == "Eliminada") {
                $log->crearLog($idModulo, "Relación " . $idIndV . ' eliminada correctamente.');
                return "Eliminada";
            } elseif ($resp == "1451") {
                $log->crearLog($idModulo, "Error 1451 al eliminar relación " . $idIndV . '.');
                return "1451";
            } else {
                $log->crearLog($idModulo, "Error al eliminar relación " . $idIndV . '.');
                return "Error al eliminar";
            }
        } else {
            $log->crearLog($idModulo, "Error 1451 al eliminar relación " . $idIndV . '. Id relación no existe.');
            return "Id relacion no existe";
        }
    }

    public function editarRelacion($idIndV, $idIndicador, $idVariable) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "indicadoresvariables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $indV = new IndicadorVariable();
        $existeRelacion = $this->existeIdRelacion($idIndV);
        $indicador = new Indicador();
        $variable = new Variable();
        $existeVariable = $variable->idVariableExiste($idVariable);
        $existeIndicador = $indicador->idIndicadorExiste($idIndicador);
        $informacionVariable = $variable->consultarVariable($idVariable);
        $tipoVariable = $informacionVariable["tipoDato"];
        $relacionesIndicador = $indV->consultarRelacionesPorIndicador($idIndicador);
        $existeTipoDato = FALSE;
        if ($existeRelacion === FALSE) {
            return 'Id relacion no existe';
        } else {
            if (!empty($existeVariable)) {
                if (!empty($existeIndicador)) {
                    if (!empty($relacionesIndicador)) {
                        foreach ($relacionesIndicador as $key => $value) {
                            $idVarTemp = $value["idVariable"];
                            $tipoDatoTemp = $variable->consultarVariable($idVarTemp)['tipoDato'];
                            if ($idVariable === $idVarTemp) {
                                $log->crearLog($idModulo, "Error al editar relación " . $idIndV . '. Ya existe la relación.');
                                return 'Relacion existe';
                            } else {
                                if ($tipoVariable === $tipoDatoTemp) {
                                    $log->crearLog($idModulo, "Error al editar relación " . $idIndV . '. Ya existe el tipo de dato (numerador o denominador).');
                                    return 'Tipo dato existe';
                                } else {
                                    $id = NULL;
                                    $resp = $indV->editarRelacion($idIndV, $idIndicador, $idVariable);
                                    if ($resp == "Editada") {
                                        $log->crearLog($idModulo, "Relación " . $idIndV . ' editada correctamente.');
                                        return "Editada";
                                    } else {
                                        $log->crearLog($idModulo, "Error al editar relación " . $idIndV . '.');
                                        return "Error al editar";
                                    }
                                }
                            }
                        }
                    } else {
                        $id = NULL;
                        $resp = $indV->crearRelacion($id, $idIndicador, $idVariable);
                        if ($resp == "Creada") {
                            $log->crearLog($idModulo, "Relación " . $idIndicador . ' - ' . $idVariable . ' creada correctamente.');
                            return "Creada";
                        } else {
                            $log->crearLog($idModulo, "Error al editar relación " . $idIndicador . ' - ' . $idVariable . '. No se puede crear la relación.');
                            return "Error al crear";
                        }
                    }
                } else {
                    $log->crearLog($idModulo, "Error al editar relación " . $indV . '-' . $idIndicador . ' - ' . $idVariable . '. Id indicador no existe.');
                    return "Id indicador no existe";
                }
            } else {
                $log->crearLog($idModulo, "Error al editar relación " . $indV . '-' . $idIndicador . ' - ' . $idVariable . '. Id variable no existe.');
                return "Id variable no existe";
            }
        }
    }

    public function existeIdRelacion($idIndV) {
        $indV = new IndicadorVariable();
        $existe = $indV->idRelacionExiste($idIndV);
        if ($existe["id"] !== NULL && $existe["id"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarRelacionForm($idIndV) {
        $indV = new IndicadorVariable();
        $variable = new Variable();
        $respEditarIndV = $indV->consultarRelacion($idIndV);
        $respConjuntoIndV = $variable->consultarVariable($respEditarIndV['idVariable'])['idConjuntoIndicadores'];
        include 'view/modules/admin/indicadoresVariables/formEditarIndicadorVariable.php';
    }

    public function eliminarRelacionForm($idIndV) {
        $indV = new IndicadorVariable();
        $variable = new Variable();
        $respEliminarIndV = $indV->consultarRelacion($idIndV);
        $respConjuntoIndV = $variable->consultarVariable($respEliminarIndV['idVariable'])['idConjuntoIndicadores'];
        include 'view/modules/admin/indicadoresVariables/formEliminarIndicadorVariable.php';
    }

}
