<?php

class FichaTecnicaController {

    public function listarFichas($idConjuntoIndicadores) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $ser = new FichaTecnica();
        $resp = $ser->listarFichasPorConjunto($idConjuntoIndicadores);
        $permiso = $rol->consultarPermisoRol("fichasTecnicas" . $idConjuntoIndicadores, $idRol);
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
            if ($idConjuntoIndicadores == "IGC") {
                echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 10, 11 ] , 
                        "bSearchable": false, "aTargets": [ 10, 11 ]
                    }]';
            } else {
                echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 19, 20 ] , 
                        "bSearchable": false, "aTargets": [ 19, 20 ]
                    }]';
            }
        } elseif ($modificar) {
            if ($idConjuntoIndicadores == "IGC") {
                echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 10 ] , 
                        "bSearchable": false, "aTargets": [ 10 ]
                    }]';
            } else {
                echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 19 ] , 
                        "bSearchable": false, "aTargets": [ 19 ]
                    }]';
            }
        } elseif ($eliminar) {
            if ($idConjuntoIndicadores == "IGC") {
                echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 10 ] , 
                        "bSearchable": false, "aTargets": [ 10 ]
                    }]';
            } else {
                echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 19 ] , 
                        "bSearchable": false, "aTargets": [ 19 ]
                    }]';
            }
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
                <h3>Gestión de fichas técnicas</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/fichasTecnicas/crearFichaTecnica&conj=' . $idConjuntoIndicadores . '" 
                            class="btn btn-primary" role="button">Crear ficha técnica</a>
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
                            <th style="text-align:center;">Dimensión</th>
                            <th style="text-align:center;">Temática</th>
                            <th style="text-align:center;">Indicador</th>';
        if ($idConjuntoIndicadores == "IGC") {
            echo '          <th style="text-align:center;">Justificación</th>
                            <th style="text-align:center;">Definición</th>
                            <th style="text-align:center;">Metodología</th>
                            <th style="text-align:center;">Referencia</th>
                            <th style="text-align:center;">Observaciones y limitaciones</th>
                            <th style="text-align:center;">Otras organizaciones que usan el indicador</th>';
        } else {
            echo '          <th style="text-align:center;">Sigla</th>
                            <th style="text-align:center;">Justificación</th>
                            <th style="text-align:center;">Definición</th>
                            <th style="text-align:center;">Métodos de medición</th>
                            <th style="text-align:center;">Fórmulas</th>
                            <th style="text-align:center;">Variables</th>
                            <th style="text-align:center;">Valores de referencia</th>
                            <th style="text-align:center;">Naturaleza</th>
                            <th style="text-align:center;">Desagregación temática</th>
                            <th style="text-align:center;">Desagregación geográfica</th>
                            <th style="text-align:center;">Línea base</th>
                            <th style="text-align:center;">Responsable</th>
                            <th style="text-align:center;">Observaciones</th>
                            <th style="text-align:center;">Fecha de elaboración</th>
                            <th style="text-align:center;">Tipo de gráfico</th>
                            ';
        }
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

            $idFicha = "";
            if ($idConjuntoIndicadores == "IGC") {
                $idFicha = $item["idFichaTecnicaIGC"];
                echo '</pre>';
                echo '  <tr>
                            <td id="prewrap">' . $idFicha . '</td>
                            <td id="prewrap">' . $item["nombreDimension"] . '</td>
                            <td id="prewrap">' . $item["nombreTematica"] . '</td>
                            <td id="prewrap">' . $item["nombreIndicador"] . '</td>   
                            <td id="prewrap">' . $item["justificacion"] . '</td>
                            <td id="prewrap">' . $item["definicion"] . '</td>
                            <td id="prewrap">' . $item["metodologia"] . '</td>
                            <td id="prewrap">' . $item["referencia"] . '</td>
                            <td id="prewrap">' . $item["observacionesLimitaciones"] . '</td>
                            <td id="prewrap">' . $item["otrasOrganizaciones"] . '</td>
                 ';
            } else {
                $idFicha = $item["idFichaTecnica"];
                echo'       <tr>
                            <td id="prewrap">' . $item["idFichaTecnica"] . '</td>
                            <td id="prewrap">' . $item["nombreDimension"] . '</td>
                            <td id="prewrap">' . $item["nombreTematica"] . '</td>
                            <td id="prewrap">' . $item["nombreIndicador"] . '</td>   
                            <td id="prewrap">' . $item["sigla"] . '</td>
                            <td id="prewrap">' . $item["justificacion"] . '</td>
                            <td id="prewrap">' . $item["definicion"] . '</td>
                            <td id="prewrap">' . $item["metodosMedicion"] . '</td>
                            <td id="prewrap">' . $item["formulas"] . '</td>
                            <td id="prewrap">' . $item["variables"] . '</td>
                            <td id="prewrap">' . $item["valoresReferencia"] . '</td>
                            <td id="prewrap">' . $item["naturaleza"] . '</td>
                            <td id="prewrap">' . $item["desagregacionTematica"] . '</td>
                            <td id="prewrap">' . $item["desagregacionGeografica"] . '</td>
                            <td id="prewrap">' . $item["lineaBase"] . '</td>
                            <td id="prewrap">' . $item["responsable"] . '</td>
                            <td id="prewrap">' . $item["observaciones"] . '</td>
                            <td id="prewrap">' . $item["fechaElaboracion"] . '</td>
                            <td id="prewrap">' . $item["tipoGrafico"] . '</td>
             ';
            }

            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/fichasTecnicas/editarFichaTecnica&fic=' . $idFicha . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/fichasTecnicas/eliminarFichaTecnica&fic=' . $idFicha . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>';
            }
        }
        echo'       </tbody>
                </table>
            </div>
        </div>';
    }

    public function crearFicha($idConjuntoIndicadores, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "fichasTecnicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $ficha = new FichaTecnica();
        $existeIndicador = $this->existeIndicador($idIndicador);
        $existeFichaIndicador = $ficha->fichaExisteIndicador($idConjuntoIndicadores, $idIndicador);
        if ($existeIndicador == TRUE) {
            if (empty($existeFichaIndicador)) {
                $idFichaTecnica = NULL;
                $resp = $ficha->crearFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico);
                if ($resp == "Creada") {
                    $log->crearLog($idModulo, "Ficha técnica para el indicador" . $idIndicador . ' creada correctamente.');
                    return "Creada";
                } else {
                    $log->crearLog($idModulo, "Error al crear Ficha técnica para el indicador" . $idIndicador . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear Ficha técnica para el indicador" . $idIndicador . '. Ya existe una ficha técnica para el indicador.');
                return "Ficha para indicador existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear Ficha técnica para el indicador" . $idIndicador . '. Id indicador no existe.');
            return "Id indicador no existe";
        }
    }

    public function crearFichaIGC($idConjuntoIndicadores, $justificacion, $definicion, $metodologia, $referencia, $observacionesLimitaciones, $otrasOrganizaciones, $idIndicador, $tipoGrafico) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "fichasTecnicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $ficha = new FichaTecnica();
        $existeIndicador = $this->existeIndicador($idIndicador);
        $existeFichaIndicador = $ficha->fichaExisteIndicador($idConjuntoIndicadores, $idIndicador);
        if ($existeIndicador == TRUE) {
            if (empty($existeFichaIndicador)) {
                $idFichaTecnica = NULL;
                $resp = $ficha->crearFichaIGC($idFichaTecnica, $justificacion, $definicion, $metodologia, $referencia, $observacionesLimitaciones, $otrasOrganizaciones, $idIndicador, $tipoGrafico);
                if ($resp == "Creada") {
                    $log->crearLog($idModulo, "Ficha técnica para el indicador" . $idIndicador . ' creada correctamente.');
                    return "Creada";
                } else {
                    $log->crearLog($idModulo, "Error al crear Ficha técnica para el indicador" . $idIndicador . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear Ficha técnica para el indicador" . $idIndicador . '. Ya existe una ficha técnica para el indicador.');
                return "Ficha para indicador existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear Ficha técnica para el indicador" . $idIndicador . '. Id indicador no existe.');
            return "Id indicador no existe";
        }
    }

    public function eliminarFicha($idConjuntoIndicadores, $idFichaTecnica) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "fichasTecnicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $ficha = new FichaTecnica();
        $existeId = $this->existeIdFicha($idConjuntoIndicadores, $idFichaTecnica);
        if ($existeId !== FALSE) {
            $resp = $ficha->eliminarFicha($idConjuntoIndicadores, $idFichaTecnica);
            if ($resp == "Eliminada") {
                $log->crearLog($idModulo, "Ficha técnica " . $idFichaTecnica . ' eliminada correctamente.');
                return "Eliminada";
            } else {
                $log->crearLog($idModulo, "Error al eliminar ficha técnica " . $idFichaTecnica . '.');
                return "Error al eliminar";
            }
        } else {
            $log->crearLog($idModulo, "Error al eliminar ficha técnica " . $idFichaTecnica . '. Id ficha no existe');
            return "Id ficha no existe";
        }
    }

    public function editarFicha($idFichaTecnica, $idConjuntoIndicadores, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "fichasTecnicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $ficha = new FichaTecnica();
        $existeIndicador = $this->existeIndicador($idIndicador);
        $existeIdFicha = $this->existeIdFicha($idConjuntoIndicadores, $idFichaTecnica);
        $fichaPerteneceIndicador = FALSE;
        $informacionFicha = $ficha->consultarFicha($idConjuntoIndicadores, $idFichaTecnica);
        if (strcmp($informacionFicha["idIndicador"], $idIndicador) == 0) {
            $fichaPerteneceIndicador = TRUE;
        }
        if ($existeIndicador == TRUE) {
            if ($existeIdFicha == TRUE) {
                if ($fichaPerteneceIndicador == TRUE) {
                    $resp = $ficha->editarFicha($idFichaTecnica, $sigla, $justificacion, $definicion, $metodosMedicion, $formulas, $variables, $valoresReferencia, $naturaleza, $desagregacionTematica, $desagregacionGeografica, $lineaBase, $responsable, $observaciones, $fechaElaboracion, $idIndicador, $tipoGrafico);
                    if ($resp == "Editada") {
                        $log->crearLog($idModulo, "Ficha técnica " . $idFichaTecnica . ' editada correctamente.');
                        return "Editada";
                    } else {
                        $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '.');
                        return "Error al editar";
                    }
                } else {
                    $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '. Id ficha no pertenece a indicador.');
                    return "Id ficha no pertenece indicador";
                }
            } else {
                $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '. Id ficha no existe.');
                return "Id ficha no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '. Id indicador no existe.');
            return "Id indicador no existe";
        }
    }

    public function editarFichaIGC($idFichaTecnica, $idConjuntoIndicadores, $justificacion, $definicion, $metodologia, $referencia, $observacionesLimitaciones, $otrasOrganizaciones, $idIndicador) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "fichasTecnicas";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $ficha = new FichaTecnica();
        $existeIndicador = $this->existeIndicador($idIndicador);
        $existeIdFicha = $this->existeIdFicha($idConjuntoIndicadores, $idFichaTecnica);
        $fichaPerteneceIndicador = FALSE;
        $informacionFicha = $ficha->consultarFicha($idConjuntoIndicadores, $idFichaTecnica);
        if (strcmp($informacionFicha["idIndicador"], $idIndicador) == 0) {
            $fichaPerteneceIndicador = TRUE;
        }
        if ($existeIndicador == TRUE) {
            if ($existeIdFicha == TRUE) {
                if ($fichaPerteneceIndicador == TRUE) {
                    $resp = $ficha->editarFichaIGC($idFichaTecnica, $justificacion, $definicion, $metodologia, $referencia, $observacionesLimitaciones, $otrasOrganizaciones);
                    if ($resp == "Editada") {
                        $log->crearLog($idModulo, "Ficha técnica " . $idFichaTecnica . ' editada correctamente.');
                        return "Editada";
                    } else {
                        $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '.');
                        return "Error al editar";
                    }
                } else {
                    $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '. Id ficha no pertenece a indicador.');
                    return "Id ficha no pertenece indicador";
                }
            } else {
                $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '. Id ficha no existe.');
                return "Id ficha no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al editar ficha técnica " . $idFichaTecnica . '. Id indicador no existe.');
            return "Id indicador no existe";
        }
    }

    public function existeIndicador($idIndicador) {
        $indicador = new Indicador();
        $existe = $indicador->idIndicadorExiste($idIndicador);
        if ($existe["idIndicador"] !== NULL && $existe["idIndicador"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIdFicha($idConjuntoIndicadores, $idFichaTecnica) {
        $ficha = new FichaTecnica();
        $existe = $ficha->idFichaExiste($idConjuntoIndicadores, $idFichaTecnica);
        if ($idConjuntoIndicadores == "IGC") {
            if ($existe["idFichaTecnicaIGC"] !== NULL && $existe["idFichaTecnicaIGC"] !== "") {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if ($existe["idFichaTecnica"] !== NULL && $existe["idFichaTecnica"] !== "") {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function editarFichaForm($idConjuntoIndicadores, $idFichaTecnica) {
        $ficha = new FichaTecnica();
        $indicador = new Indicador();
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEditarFicha = $ficha->consultarFicha($idConjuntoIndicadores, $idFichaTecnica);
        $respIdIndicadorFicha = $respEditarFicha["idIndicador"];
        $respIdTematicaFicha = $indicador->consultarTematicaPorIndicador($respIdIndicadorFicha)["idTematica"];
        $respIdDimensionFicha = $tematica->consultarDimensionPorTematica($respIdTematicaFicha)["idDimension"];
        $respIdConjuntoFicha = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionFicha)["idConjuntoIndicadores"];
        include 'view/modules/admin/fichasTecnicas/formEditarFichaTecnica.php';
    }

    public function eliminarFichaForm($idConjuntoIndicadores, $idFichaTecnica) {
        $ficha = new FichaTecnica();
        $indicador = new Indicador();
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEliminarFicha = $ficha->consultarFicha($idConjuntoIndicadores, $idFichaTecnica);
        $respIdIndicadorFicha = $respEliminarFicha["idIndicador"];
        $respIdTematicaFicha = $indicador->consultarTematicaPorIndicador($respIdIndicadorFicha)["idTematica"];
        $respIdDimensionFicha = $tematica->consultarDimensionPorTematica($respIdTematicaFicha)["idDimension"];
        $respIdConjuntoFicha = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionFicha)["idConjuntoIndicadores"];
        include 'view/modules/admin/fichasTecnicas/formEliminarFichaTecnica.php';
    }

}
