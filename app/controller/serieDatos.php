<?php

class SerieDatosController {

    public function listarSeries($idConjuntoIndicadores) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $ser = new SerieDatos();
        $resp = $ser->listarSeriesPorConjunto($idConjuntoIndicadores);
        $permiso = $rol->consultarPermisoRol("seriesDatos" . $idConjuntoIndicadores, $idRol);
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
        if ($modificar && $eliminar && $idConjuntoIndicadores == 'SIS') {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 15, 16 ] , 
                        "bSearchable": false, "aTargets": [ 15, 16 ]
                    }]';
        } elseif ($modificar && $eliminar && $idConjuntoIndicadores !== 'SIS') {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 12, 13 ] , 
                        "bSearchable": false, "aTargets": [ 12, 13 ]
                    }]';
        } elseif ($modificar && $idConjuntoIndicadores == 'SIS') {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 15 ] , 
                        "bSearchable": false, "aTargets": [ 15 ]
                    }]';
        } elseif ($modificar && $idConjuntoIndicadores !== 'SIS') {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 12 ] , 
                        "bSearchable": false, "aTargets": [ 12 ]
                    }]';
        } elseif ($eliminar && $idConjuntoIndicadores == 'SIS') {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 15 ] , 
                        "bSearchable": false, "aTargets": [ 15 ]
                    }]';
        } elseif ($eliminar && $idConjuntoIndicadores !== 'SIS') {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 12 ] , 
                        "bSearchable": false, "aTargets": [ 12 ]
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
                <h3>Gestión de series de datos</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/seriesDatos/crearSerieDatos&conj=' . $idConjuntoIndicadores . '" 
                            class="btn btn-primary" role="button">Crear serie de datos</a>
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
        if ($idConjuntoIndicadores == "SIS") {
            echo '          <th style="text-align:center;">Tipo de dato</th>';
        }
        echo '
                            
                            <th style="text-align:center;">Tipo de zona geográfica</th>
                            <th style="text-align:center;">Zona geográfica</th>
                            <th style="text-align:center;">Periodicidad</th>
                            <th style="text-align:center;">Entidad compiladora</th>
                            <th style="text-align:center;">Fuente de datos</th>';
        if ($idConjuntoIndicadores == "SIS") {
            echo '          <th style="text-align:center;">Url de la fuente de datos</th>';
        }
        echo '
                            
                            <th style="text-align:center;">Desagregación temática</th>
                            <th style="text-align:center;">Notas</th>
                            <th style="text-align:center;">Unidad de medida</th>';
        if ($idConjuntoIndicadores == "SIS") {
            echo '          <th style="text-align:center;">Número de consultas</th>';
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
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idSerieDatos"] . '</td>
                            <td id="prewrap">' . $item["nombreDimension"] . '</td>
                            <td id="prewrap">' . $item["nombreTematica"] . '</td>
                            <td id="prewrap">' . $item["nombreIndicador"] . '</td>';
            if ($idConjuntoIndicadores == "SIS") {
                echo '          <td id="prewrap">' . $item["tipoDato"] . '</td>';
            }
            echo '          <td id="prewrap">' . $item["tipoZonaGeografica"] . '</td>
                            <td id="prewrap">' . $item["zonaGeografica"] . '</td>
                            <td id="prewrap">' . $item["periodicidad"] . '</td>
                            <td id="prewrap">' . $item["entidadCompiladora"] . '</td>
                            <td id="prewrap">' . $item["fuenteDatos"] . '</td>';
            if ($idConjuntoIndicadores == "SIS") {
                $url1 = $item["urlFuenteDatos"];
                $url = filter_var($url1, FILTER_SANITIZE_URL);
                if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
                    echo '      <td id = "prewrap"><a href = "' . $item["urlFuenteDatos"] . '" target = "_blank">' . $item["urlFuenteDatos"] . '</a></td>';
                } else {
                    echo '      <td id = "prewrap">' . $url . '</td>';
                }
            }
            echo '          <td id="prewrap">' . $item["desagregacionTematica"] . '</td>
                            <td id="prewrap">' . $item["notas"] . '</td>
                            <td id="prewrap">' . $item["unidadMedida"] . '</td>';
            if ($idConjuntoIndicadores == "SIS") {
                echo '      <td id="prewrap">' . $item["numeroConsultas"] . '</td>';
            }
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/seriesDatos/editarSerieDatos&ser=' . $item["idSerieDatos"] . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/seriesDatos/eliminarSerieDatos&ser=' . $item["idSerieDatos"] . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>';
            }
            echo'       </tr>';
        }
        echo'       </tbody>
                </table>
            </div>
        </div>';
    }

    public function crearSerieDatos($tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $idIndicador) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "seriesdatos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $serie = new SerieDatos();
        $existeIndicador = $this->existeIndicador($idIndicador);
        $nombreUnicoSerie = $geografia . "_" . $zonaActual . "_" . $desagregacionTematica . "_" . $idIndicador;
        $existeSerieIndicador = $this->existeSerieIndicador(trim($nombreUnicoSerie), $idIndicador);
        if ($existeIndicador == TRUE) {
            if ($existeSerieIndicador == FALSE) {
                $cantidadSer = $serie->consultarUltimoId($idIndicador);
                if(!empty($cantidadSer)){  
                $consulta = explode('_S', $cantidadSer[0]);
                $idSerieDatos = $idIndicador ."_S". ($consulta[1] + 1);}
                else{$idSerieDatos = $idIndicador ."_S"."1";}
                $numeroConsultas = 0;
                $resp = $serie->crearSerieDatos($idSerieDatos, $nombreUnicoSerie, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $numeroConsultas, $idIndicador);
                if ($resp == "Creada") {
                    $log->crearLog($idModulo, "Serie de datos " . $idSerieDatos . ' - ' . $nombreUnicoSerie . ' del indicador ' . $idIndicador . ' creada correctamente.');
                    return "Creada";
                } else {
                    $log->crearLog($idModulo, "Error al crear serie de datos " . $idSerieDatos . ' - ' . $nombreUnicoSerie . ' del indicador ' . $idIndicador . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear serie de datos " . $idSerieDatos . ' - ' . $nombreUnicoSerie . ' del indicador ' . $idIndicador . '. Ya existe la serie en el indicador.');
                return "Serie existe en indicador";
            }
        } else {
            $log->crearLog($idModulo, "Error al crear serie de datos " . $idSerieDatos . ' - ' . $nombreUnicoSerie . ' del indicador ' . $idIndicador . '. El id del indicador no existe.');
            return "Id indicador no existe";
        }
    }

    public function eliminarSerieDatos($idSerieDatos) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "seriesdatos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $serie = new SerieDatos();
        $existeId = $this->existeIdSerie($idSerieDatos);
        $existeDato = $this->existeDatosEnSerieDatos($idSerieDatos);
        if ($existeDato == FALSE) {
            if ($existeId !== FALSE) {
                $resp = $serie->eliminarSerieDatos($idSerieDatos);
                if ($resp == "Eliminada") {
                    $log->crearLog($idModulo, "Serie de datos " . $idSerieDatos . ' eliminada correctamente.');
                    return "Eliminada";
                } elseif ($resp == "1451") {
                    $log->crearLog($idModulo, "Error 1451 al eliminar serie de datos " . $idSerieDatos . '.');
                    return "1451";
                } else {
                    $log->crearLog($idModulo, "Error al eliminar serie de datos " . $idSerieDatos . '.');
                    return "Error al eliminar";
                }
            } else {
                $log->crearLog($idModulo, "Error al eliminar serie de datos " . $idSerieDatos . '. Id serie no existe.');
                return "Id serie no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error 1451 al eliminar serie de datos " . $idSerieDatos . '.');
            return "1451";
        }
    }

    public function editarSerieDatos($idSerieDatos, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion, $idIndicador) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "seriesdatos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $serie = new SerieDatos();
        $existeIndicador = $this->existeIndicador($idIndicador);
        $existeIdSerie = $this->existeIdSerie($idSerieDatos);
        $nombreUnicoSerie = $zonaActual . "_" . $fuenteDatos . "_" . $desagregacionTematica . "_" . $idIndicador;
        $nombreUnicoPerteneceSerie = FALSE;
        $informacionSerie = $serie->consultarSerieDatos($idSerieDatos);
        if (strcmp($informacionSerie["nombreUnicoSerie"], $nombreUnicoSerie) == 0) {
            $nombreUnicoPerteneceSerie = TRUE;
        }
        if ($existeIndicador == TRUE) {
            if ($existeIdSerie == TRUE) {
                if ($nombreUnicoPerteneceSerie == TRUE) {
                    $resp = $serie->editarSerieDatos($idSerieDatos, $nombreUnicoSerie, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion);
                    if ($resp == "Editada") {
                        $log->crearLog($idModulo, "Serie de datos " . $idSerieDatos . ' editada correctamente.');
                        return "Editada";
                    } else {
                        $log->crearLog($idModulo, "Error al editar serie de datos " . $idSerieDatos . '.');
                        return "Error al editar";
                    }
                } else {
                    if ($this->existeSerieIndicador($nombreUnicoSerie, $idIndicador) == FALSE) {
                        $resp = $serie->editarSerieDatos($idSerieDatos, $nombreUnicoSerie, $tipoDato, $geografia, $zonaActual, $periodicidad, $entidadGeneradora, $fuenteDatos, $urlDatos, $desagregacionTematica, $notas, $unidadMedicion);
                        if ($resp == "Editada") {
                            $log->crearLog($idModulo, "Serie de datos " . $idSerieDatos . ' editada correctamente.');
                            return "Editada";
                        } else {
                            $log->crearLog($idModulo, "Error al editar serie de datos " . $idSerieDatos . '.');
                            return "Error al editar";
                        }
                    } else {
                        $log->crearLog($idModulo, "Error al editar serie de datos " . $idSerieDatos . '. Una serie con los datos suministrados ya existe para el indicador.');
                        return "Serie existe en indicador";
                    }
                }
            } else {
                $log->crearLog($idModulo, "Error al editar serie de datos " . $idSerieDatos . '. Id serie no existe.');
                return "Id serie no existe";
            }
        } else {
            $log->crearLog($idModulo, "Error al editar serie de datos " . $idSerieDatos . '. Id indicador ' . $idIndicador . '. no existe.');
            return "Id indicador no existe";
        }
    }

    public function existeDatosEnSerieDatos($idSerieDatos) {
        $serieDato = new SerieDatos();
        $existe = $serieDato->serieDatosTieneDatos($idSerieDatos);
        $totalExiste = sizeof($existe);
        if ($totalExiste > 0) {
            return TRUE;
        } else {
            return FALSE;
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

    public function existeSerieIndicador($nombreUnicoSerie, $idIndicador) {
        $serie = new SerieDatos();
        $existe = $serie->nombreUnicoSerieExisteIndicador($nombreUnicoSerie, $idIndicador);
        if ($existe["idSerieDatos"] !== NULL && $existe["idSerieDatos"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIdSerie($idSerieDatos) {
        $serie = new SerieDatos();
        $existe = $serie->idSerieDatosExiste($idSerieDatos);
        if ($existe["idSerieDatos"] !== NULL && $existe["idSerieDatos"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarSerieForm($idSerieDatos) {
        $serie = new SerieDatos();
        $indicador = new Indicador();
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEditarSerie = $serie->consultarSerieDatos($idSerieDatos);
        $respIdIndicadorSerie = $respEditarSerie["idIndicador"];
        $respIdTematicaSerie = $indicador->consultarTematicaPorIndicador($respIdIndicadorSerie)["idTematica"];
        $respIdDimensionSerie = $tematica->consultarDimensionPorTematica($respIdTematicaSerie)["idDimension"];
        $respIdConjuntoSerie = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionSerie)["idConjuntoIndicadores"];
        include 'view/modules/admin/seriesDatos/formEditarSerieDatos.php';
    }

    public function eliminarSerieForm($idSerieDatos) {
        $serie = new SerieDatos();
        $indicador = new Indicador();
        $tematica = new Tematica();
        $dimension = new Dimension();
        $respEliminarSerie = $serie->consultarSerieDatos($idSerieDatos);
        $respIdIndicadorSerie = $respEliminarSerie["idIndicador"];
        $respIdTematicaSerie = $indicador->consultarTematicaPorIndicador($respIdIndicadorSerie)["idTematica"];
        $respIdDimensionSerie = $tematica->consultarDimensionPorTematica($respIdTematicaSerie)["idDimension"];
        $respIdConjuntoSerie = $dimension->consultarConjuntoIndicadoresPorDimension($respIdDimensionSerie)["idConjuntoIndicadores"];
        include 'view/modules/admin/seriesDatos/formEliminarSerieDatos.php';
    }

    public function consultarTiposZonasGeograficasPorIndicador($idIndicador) {
        $serie = new SerieDatos();
        $resp = $serie->consultarTiposZonasGeograficasPorIndicador($idIndicador);
        echo '<option value="Seleccione">Seleccione un tipo de zona geográfica</option>';
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["tipoZonaGeografica"] . '">' . $item["tipoZonaGeografica"] . '</option>';
        }
    }

    public function listarTiposZonasGeograficasPorIndicador($idIndicador) {
        $serie = new SerieDatos();
        $resp = $serie->consultarTiposZonasGeograficasPorIndicador($idIndicador);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['tipoZonaGeografica'],
                "title" => $item['tipoZonaGeografica'],
                "value" => $item['tipoZonaGeografica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function listarZonasGeograficasPorTipo($idIndicador, $tipoZonaGeografica) {
        $serie = new SerieDatos();
        $resp = $serie->consultarZonasGeograficasPorTipo($idIndicador, $tipoZonaGeografica);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['zonaGeografica'],
                "title" => $item['zonaGeografica'],
                "value" => $item['zonaGeografica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function listarDesagregacionesTematicasPorIndicadorTipoZona($idIndicador, $tipoZonaGeografica, $zonaGeografica) {
        $serie = new SerieDatos();
        $resp = $serie->consultarDesagregacionesTematicasPorIndicadorTipoZona($idIndicador, $tipoZonaGeografica, $zonaGeografica);
        $options = array();
        foreach ($resp as $row => $item) {
            $options[] = array("label" => $item['desagregacionTematica'],
                "title" => $item['desagregacionTematica'],
                "value" => $item['desagregacionTematica'],
                "selected" => false);
        }
        echo json_encode($options);
    }

    public function consultarZonasGeograficasPorTipo($idIndicador, $tipoZonaGeografica) {
        $serie = new SerieDatos();
        $resp = $serie->consultarZonasGeograficasPorTipo($idIndicador, $tipoZonaGeografica);
        echo '<option value="Seleccione">Seleccione una zona geográfica</option>';
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["zonaGeografica"] . '">' . $item["zonaGeografica"] . '</option>';
        }
    }

    public function consultarDesagregacionesTematicasPorIndicadorTipoZona($idIndicador, $tipoZonaGeografica, $zonaGeografica) {
        $serie = new SerieDatos();
        $resp = $serie->consultarDesagregacionesTematicasPorIndicadorTipoZona($idIndicador, $tipoZonaGeografica, $zonaGeografica);
        echo '<option value="Seleccione">Seleccione una desagregación temática</option>';
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["desagregacionTematica"] . '">' . $item["desagregacionTematica"] . '</option>';
        }
    }

    public function consultarFuentesPorIndicadorTipoZonaDesagregacion($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica) {
        $serie = new SerieDatos();
        $resp = $serie->consultarFuentesPorIndicadorTipoZonaDesagregacion($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica);
        echo '<option value="Seleccione">Seleccione una fuente de datos</option>';
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["fuenteDatos"] . '">' . $item["fuenteDatos"] . '</option>';
        }
    }

}
