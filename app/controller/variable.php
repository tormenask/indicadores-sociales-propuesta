<?php

class VariableController {

    public function listarVariablesCrear($idConjuntoIndicadores) {
        $variable = new Variable();
        $resp = $variable->listarVariablesPorConjunto($idConjuntoIndicadores);
        foreach ($resp as $row => $item) {
            echo '<option value="' . $item["idVariable"] . '">' . $item["nombreVariable"] . '</option>';
        }
    }

    public function listarVariablesEditar($idConjuntoIndicadores, $idVariable) {
        $variable = new Variable();
        $resp = $variable->listarVariablesPorConjunto($idConjuntoIndicadores);
        foreach ($resp as $row => $item) {
            if ($idVariable == $item["idVariable"]) {
                echo '<option value="' . $item["idVariable"] . '"selected>' . $item["nombreVariable"] . '</option>';
            } else {
                echo '<option value="' . $item["idVariable"] . '">' . $item["nombreVariable"] . '</option>';
            }
        }
    }

    public function listarVariables($idConjuntoIndicadores) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $var = new Variable();
        $resp = $var->listarVariablesPorConjunto($idConjuntoIndicadores);
        $permiso = $rol->consultarPermisoRol("variables" . $idConjuntoIndicadores, $idRol);
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
                        "bSortable": false, "aTargets": [ 13, 14 ] , 
                        "bSearchable": false, "aTargets": [ 13, 14 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 13 ] , 
                        "bSearchable": false, "aTargets": [ 13 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 13 ] , 
                        "bSearchable": false, "aTargets": [ 13 ]
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
                <h3>Gestión de variables</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/variables/crearVariable&conj=' . $idConjuntoIndicadores . '" 
                            class="btn btn-primary" role="button">Crear variable</a>
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
                            <th style="text-align:center;">Variable</th>
                            <th style="text-align:center;">Gestionar datos</th>
                            <th style="text-align:center;">Tipo</th>
                            <th style="text-align:center;">Tipo de zona geográfica</th>
                            <th style="text-align:center;">Zona geográfica</th>
                            <th style="text-align:center;">Periodicidad</th>
                            <th style="text-align:center;">Entidad compiladora</th>
                            <th style="text-align:center;">Fuente de datos</th>
                            <th style="text-align:center;">Url de la fuente de datos</th>
                            <th style="text-align:center;">Desagregación temática</th>
                            <th style="text-align:center;">Notas</th>
                            <th style="text-align:center;">Unidad de medida</th>
                            ';
        if ($modificar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Editar</th>';
        }
        if ($eliminar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Eliminar</th>';
        }
        echo '              
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            echo '
                        <tr>
                            <td id="prewrap">' . $item["idVariable"] . '</td>
                            <td id="prewrap">' . $item["nombreVariable"] . '</td>
                            <td style="text-align:center;">
                                <a href="index.php?action=admin/variables/gestionDatosVariable&var=' . $item["idVariable"] . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-cog fa-lg"></i>
                                </a>
                            </td>
                            <td id="prewrap">' . $item["tipoDato"] . '</td>
                            <td id="prewrap">' . $item["tipoZonaGeografica"] . '</td>
                            <td id="prewrap">' . $item["zonaGeografica"] . '</td>
                            <td id="prewrap">' . $item["periodicidad"] . '</td>
                            <td id="prewrap">' . $item["entidadCompiladora"] . '</td>
                            <td id="prewrap">' . $item["fuenteDatos"] . '</td>';
            $url = $item["urlFuenteDatos"];
            $url = filter_var($url, FILTER_SANITIZE_URL);
            if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
                echo '      <td id = "prewrap"><a href = "' . $item["urlFuenteDatos"] . '" target = "_blank">' . $item["urlFuenteDatos"] . '</a></td>';
            } else {
                echo '      <td id = "prewrap">' . $url . '</td>';
            }
            echo '          <td id="prewrap">' . $item["desagregacionTematica"] . '</td>
                            <td id="prewrap">' . $item["notas"] . '</td>
                            <td id="prewrap">' . $item["unidadMedida"] . '</td>
                            ';
            if ($modificar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/variables/editarVariable&var=' . $item["idVariable"] . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-pencil fa-lg"></i>
                                </a>
                            </td>';
            }
            if ($eliminar) {
                echo '      <td style="text-align:center;">
                                <a href="index.php?action=admin/variables/eliminarVariable&var=' . $item["idVariable"] . '&conj=' . $idConjuntoIndicadores . '">
                                    <i class="fa fa-trash fa-lg"></i>
                                </a>
                            </td>';
            }
            echo'       
                            
                        </tr>';
        }
        echo'       </tbody>
                </table>
            </div>
        </div>';
    }

    public function crearVariable($nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida, $idConjuntoIndicadores) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "variables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $variable = new Variable();
        $existeConjuntoIndicadores = $this->existeConjuntoIndicadores($idConjuntoIndicadores);
        $countVariables = $variable->contarVariablesPorConjunto($idConjuntoIndicadores);
        $nombreVariableExiste = $this->existeVariableConjunto($nombreVariable, $idConjuntoIndicadores);
        if ($existeConjuntoIndicadores == TRUE) {
            if ($nombreVariableExiste == FALSE) {
                $idVariable = 'VAR_' . $idConjuntoIndicadores . "_" . ($countVariables + 1);
                $resp = $variable->crearVariable($idVariable, $nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida, $idConjuntoIndicadores);
                if ($resp == "Creada") {
                    $log->crearLog($idModulo, "Variable " . $idVariable . ' - ' . $nombreVariable . ' del conjunto ' . $idConjuntoIndicadores . ' creada correctamente.');
                    return "Creada";
                } else {
                    $log->crearLog($idModulo, "Error al crear variable " . $idVariable . ' - ' . $nombreVariable . ' del conjunto ' . $idConjuntoIndicadores . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear variable " . $idVariable . ' - ' . $nombreVariable . ' del conjunto ' . $idConjuntoIndicadores . '. Variable ya existe en conjunto.');
                return "Variable existe en conjunto";
            }
        } else {
            return "Id conjunto no existe";
        }
    }

    public function eliminarVariable($idVariable) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "variables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $variable = new Variable();
        $existeId = $this->existeIdVariable($idVariable);
        if ($existeId !== FALSE) {
            $resp = $variable->eliminarVariable($idVariable);
            if ($resp == "Eliminada") {
                $log->crearLog($idModulo, "Variable " . $idVariable . ' eliminada correctamente.');
                return "Eliminada";
            } elseif ($resp == "1451") {
                $log->crearLog($idModulo, "Error 1451 al eliminar variable " . $idVariable . '.');
                return "1451";
            } else {
                $log->crearLog($idModulo, "Error al eliminar variable " . $idVariable . '.');
                return "Error al eliminar";
            }
        } else {
            $log->crearLog($idModulo, "Error al eliminar variable " . $idVariable . '. Id variable no existe.');
            return "Id variable no existe";
        }
    }

    public function editarVariable($idVariable, $nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida, $idConjuntoIndicadores) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "variables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $variable = new Variable();
        $existeVariable = $this->existeIdVariable($idVariable);
        $nombrePerteneceVariable = FALSE;
        $informacionVariable = $variable->consultarVariable($idVariable);
        if (strcmp($informacionVariable["nombreVariable"], $nombreVariable) == 0) {
            $nombrePerteneceVariable = TRUE;
        }
        if ($existeVariable == TRUE) {
            if ($nombrePerteneceVariable == TRUE) {
                $resp = $variable->editarVariable($idVariable, $nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida);
                if ($resp == "Editada") {
                    $log->crearLog($idModulo, "Variable " . $idVariable . ' del conjunto ' . $idConjuntoIndicadores . ' editada correctamente.');
                    return "Editada";
                } else {
                    $log->crearLog($idModulo, "Error al editar variable " . $idVariable . ' del conjunto ' . $idConjuntoIndicadores . '.');
                    return "Error al editar";
                }
            } else {
                if ($this->existeVariableConjunto($nombreVariable, $idConjuntoIndicadores) == FALSE) {
                    $resp = $variable->editarVariable($idVariable, $nombreVariable, $tipoDato, $tipoZonaGeografica, $zonaGeografica, $periodicidad, $entidadCompiladora, $fuenteDatos, $urlFuenteDatos, $desagregacionTematica, $notas, $unidadMedida);
                    if ($resp == "Editada") {
                        $log->crearLog($idModulo, "Variable " . $idVariable . ' del conjunto ' . $idConjuntoIndicadores . ' editada correctamente.');
                        return "Editada";
                    } else {
                        $log->crearLog($idModulo, "Error al editar variable " . $idVariable . ' del conjunto ' . $idConjuntoIndicadores . '.');
                        return "Error al editar";
                    }
                } else {
                    $log->crearLog($idModulo, "Error al editar variable " . $idVariable . ' del conjunto ' . $idConjuntoIndicadores . '. Ya existe una variable con este nombre en conjunto.');
                    return "Nombre variable existe en conjunto";
                }
            }
        } else {
            $log->crearLog($idModulo, "Error al editar variable " . $idVariable . ' del conjunto ' . $idConjuntoIndicadores . '. El Id de la variable no existe.');
            return "Id variable no existe";
        }
    }

    public function existeConjuntoIndicadores($idConjuntoIndicadores) {
        $conjunto = new ConjuntoIndicadores();
        $existe = $conjunto->idConjuntoExiste($idConjuntoIndicadores);
        if ($existe["idConjuntoIndicadores"] !== NULL && $existe["idConjuntoIndicadores"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeVariableConjunto($nombreVariable, $idConjuntoIndicadores) {
        $variable = new Variable();
        $existe = $variable->nombreVariableExiste($nombreVariable, $idConjuntoIndicadores);
        if ($existe["idVariable"] !== NULL && $existe["idVariable"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function existeIdVariable($idVariable) {
        $variable = new Variable();
        $existe = $variable->idVariableExiste($idVariable);
        if ($existe["idVariable"] !== NULL && $existe["idVariable"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarVariableForm($idVariable) {
        $variable = new Variable();
        $respEditarVariable = $variable->consultarVariable($idVariable);
        include 'view/modules/admin/variables/formEditarVariable.php';
    }

    public function eliminarVariableForm($idVariable) {
        $variable = new Variable();
        $respEliminarVariable = $variable->consultarVariable($idVariable);
        include 'view/modules/admin/variables/formEliminarVariable.php';
    }

    public function mostrarConsultarDatosVariable($idConjuntoIndicadores) {
        $idConj = $idConjuntoIndicadores;
        include $_SERVER['DOCUMENT_ROOT'] . '/sis/app/view/modules/admin/variables/consultaDatosVariable.php';
    }

    public function listarDatosVariable($idVariable) {
        $var = new Variable();
        $resp = $var->listarDatosPorIdVariable($idVariable);
        $nombreVariable = $var->consultarVariable($idVariable)['nombreVariable'];
        echo '
                <style>
                    .table>tbody>tr>td {
                        border-top: 1px solid #dddddd;
                        border-bottom: 1px solid #dddddd;
                        border-right: 1px solid #dddddd;
                    }
                    th:first-child {
                        border-left: 1px solid #dddddd;
                    }
                </style>
                    <p><b>Id de la variable:</b> <span id="idVariableDat">' . $idVariable . '</span></p>
                    <p><b>Nombre de la variable:</b> <span id="idNombreVariableDat">' . $nombreVariable . '</span></p>
                    <div class="btn-group" role="group" style="margin-bottom:15px;">
                        <button type="button" class="btn btn-primary" onclick="agregarDato()">Agregar dato</button>
                        <button type="button" class="btn btn-warning" id="btn-editar-dato">Editar dato</button>
                        <button type="button" class="btn btn-danger" id="btn-eliminar-dato">Eliminar dato</button>
                    </div>
                    <table class="dataTable table table-striped cell-border" id="tabla-consulta">
                        <thead>
                            <tr>
                                <th style="text-align:center;"><i class="fa fa-check-square"></i></th>
                                <th style="text-align:center;">Id del dato</th>
                                <th style="text-align:center;">Fecha del dato</th>
                                <th style="text-align:center;">Valor del dato</th>
                                <th style="text-align:center;">Estado de la observación</th>
                            </tr>
                        </thead>
                        <tbody>';
        foreach ($resp as $row => $item) {
            $idDato = $item["idDatoVariable"];
            $estadoObservacionDato = $item["estadoObservacionDatoVariable"];
            if ($item["estadoObservacionDatoVariable"] == "") {
                $estadoObservacionDato = "-";
            }
            echo '      <tr>
                                <td></td>  
                                <td id="prewrap">' . $idDato . '</td>  
                                <td id="prewrap" style="text-align:center;">' . $item["fechaDatoVariable"] . '</td>
                                <td id="prewrap" style="text-align:right;">' . number_format($item["valorDatoVariable"], 2) . '</td>
                                <td id="prewrap" style="text-align:center;">' . $estadoObservacionDato . '</td>
                            </tr>';
        }
        echo '
                        </tbody>
                    </table>';
        echo "
            <script>
                var table;
                $(document).ready(function() {
                    table = $('#tabla-consulta').DataTable({
                        'language': {
                            'url': '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
                        },
                        columnDefs: [{
                            orderable: false,
                            className: 'select-checkbox',
                            targets: 0
                            },
                            {
                            'searchable': false
                        }],
                        select: {
                            style: 'os',
                            selector: 'td:first-child',
                            blurable: true
                        },
                        order: [
                            [2, 'asc']
                        ]
                    });
                    table.on( 'select', function ( e, dt, type, ix ) {
                        var selected = dt.rows({selected: true});
                        if ( selected.count() > 1 ) {
                            alert('Puede seleccionar solo un dato');
                            dt.rows(ix).deselect();
                        }
                    });
                    $('#btn-editar-dato').on('click', function() {
                        var tblData = table.rows('.selected').data();
                        if(tblData[0]==''||tblData[0]==null||tblData[0]=='[object Object]'||tblData[0]=='undefined'){
                            document.getElementById('modal-content-error').innerHTML = 'Debe seleccionar el dato a editar. <br>Verifique la información e intente nuevamente.';
                            $('#modal-form-error').modal('show');
                        }else{
                            var rowData = table.rows('.selected').data().toArray();
                            var text = JSON.stringify(rowData);
                            editarDato(text);
                        }
                    })
                    $('#btn-eliminar-dato').on('click', function() {
                        var tblData = table.rows('.selected').data();
                        if(tblData[0]==''||tblData[0]==null||tblData[0]=='[object Object]'||tblData[0]=='undefined'){
                            document.getElementById('modal-content-error').innerHTML = 'Debe seleccionar el dato a eliminar. <br>Verifique la información e intente nuevamente.';
                            $('#modal-form-error').modal('show');
                        }else{
                            var rowData = table.rows('.selected').data().toArray();
                            var text = JSON.stringify(rowData);
                            eliminarDato(text);
                        }
                    })
                });
                $('#modal-btn-cancel').on('click', function () {
                    $('#modal-create').modal('hide');
                });
                $('#modal-btn-edit-cancel').on('click', function () {
                    $('#modal-edit').modal('hide');
                });
            </script>
            <div class='modal' tabindex='-1' role='dialog' aria-hidden='true' id='modal-create'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header active'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            <h4 class='modal-title'>Agregar dato</h4>
                        </div>
                        <div class='modal-body'>
                            <div class='form-group'>
                                <label class='control-label' for='idSerieDatos'>Id de la variable</label>
                                <input name='idVariable' id='idVariable' required class='form-control' placeholder='Id de la variable' disabled value='" . $idVariable . "'>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='fechaDato'>Fecha del dato</label>
                                <select name='fechaDato' id='fechaDato' class='form-control'>
                                </select>
                            </div>
                            <script>
                                select = document.getElementById('fechaDato');
                                for(i = 1980; i <= 2020; i++){
                                    option = document.createElement('option');
                                    option.value = i;
                                    option.text = i;
                                    select.appendChild(option);
                                }
                            </script>
                            <div class='form-group'>
                                <label class='control-label' for='valorDato'>Valor del dato</label>
                                <input name='valorDato' id='valorDato' type='number' required class='form-control' placeholder='Valor del dato'>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='estadoObservacion'>Estado de la observacion</label>
                                <select name='estadoObservacion' id='estadoObservacion' class='form-control'>
                                    <option value='Selecciona'></option>
                                    <option value='Estimado'>Estimado</option>
                                    <option value='Provisional'>Provisional</option>
                                    <option value='Definitivo'>Definitivo</option>
                                </select>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-primary' id='modal-btn-create' onclick=agregar()>Agregar dato</button>
                            <button type='button' class='btn btn-default' id='modal-btn-cancel'>Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>    
            <div class='modal' tabindex='-1' role='dialog' aria-hidden='true' id='modal-edit'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header active'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            <h4 class='modal-title'>Editar dato</h4>
                        </div>
                        <div class='modal-body'>
                            <div class='form-group'>
                                <label class='control-label' for='id-variable-edit'>Id de la variable</label>
                                <input name='idVariable' id='id-variable-edit' required class='form-control' placeholder='Id de la variable' disabled value='" . $idVariable . "'>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='id-dato-edit'>Id del dato</label>
                                <input name='id-dato-edit' id='id-dato-edit' required class='form-control' placeholder='Id del dato' disabled>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='fecha-dato-edit'>Fecha del dato</label>
                                <select name='fecha-dato-edit' id='fecha-dato-edit' class='form-control' disabled>
                                </select>
                            </div>
                            <script>
                                select = document.getElementById('fecha-dato-edit');
                                for(i = 1980; i <= 2020; i++){
                                    option = document.createElement('option');
                                    option.value = i;
                                    option.text = i;
                                    select.appendChild(option);
                                }
                            </script>
                            <div class='form-group'>
                                <label class='control-label' for='valor-dato-edit'>Valor del dato</label>
                                <input name='valor-dato-edit' id='valor-dato-edit' type='number' required class='form-control' placeholder='Valor del dato'>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='estado-dato-edit'>Estado de la observacion</label>
                                <select name='estado-dato-edit' id='estado-dato-edit' class='form-control'>
                                    <option value='Selecciona'></option>
                                    <option value='Estimado'>Estimado</option>
                                    <option value='Provisional'>Provisional</option>
                                    <option value='Definitivo'>Definitivo</option>
                                </select>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-primary' id='modal-btn-edit' onclick=editar()>Editar dato</button>
                            <button type='button' class='btn btn-default' id='modal-btn-edit-cancel'>Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal' tabindex='-1' role='dialog' aria-hidden='true' id='modal-delete'>
                <div class='modal-dialog modal-sm'>
                    <div class='modal-content'>
                        <div class='modal-header active'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            <h4 class='modal-title'>Eliminar dato</h4>
                        </div>
                        <div class='modal-body'>
                            <div class='form-group'>
                                <label class='control-label' for='id-variable-delete'>Id de la variable</label>
                                <input name='idVariable' id='id-variable-delete' required class='form-control' placeholder='Id de la variable' disabled value='" . $idVariable . "'>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='id-dato-delete'>Id del dato</label>
                                <input name='id-dato-delete' id='id-dato-delete' required class='form-control' placeholder='Id del dato' disabled>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='fecha-dato-delete'>Fecha del dato</label>
                                <select name='fecha-dato-edit' id='fecha-dato-delete' class='form-control' disabled>
                                </select>
                            </div>
                            <script>
                                select = document.getElementById('fecha-dato-delete');
                                for(i = 1980; i <= 2020; i++){
                                    option = document.createElement('option');
                                    option.value = i;
                                    option.text = i;
                                    select.appendChild(option);
                                }
                            </script>
                            <div class='form-group'>
                                <label class='control-label' for='valor-dato-delete'>Valor del dato</label>
                                <input name='valor-dato-edit' id='valor-dato-delete' type='number' required class='form-control' placeholder='Valor del dato' disabled>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='estado-dato-delete'>Estado de la observacion</label>
                                <select name='estado-dato-edit' id='estado-dato-delete' class='form-control' disabled>
                                    <option value='Selecciona'></option>
                                    <option value='Estimado'>Estimado</option>
                                    <option value='Provisional'>Provisional</option>
                                    <option value='Definitivo'>Definitivo</option>
                                </select>
                            </div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-primary' id='modal-btn-delete' onclick=eliminar()>Eliminar dato</button>
                            <button type='button' class='btn btn-default' id='modal-btn-delete-cancel'>Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

    public function existeDatoVariable($idVariable, $fechaDato) {
        $variable = new Variable();
        $existe = $variable->existeDatoVariable($idVariable, $fechaDato);
        if ($existe["fechaDatoVariable"] !== NULL && $existe["fechaDatoVariable"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function crearDatoVariable($fechaDato, $valorDato, $estadoObservacionDato, $idVariable) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "variables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $variable = new Variable();
        $existeVariable = $variable->idVariableExiste($idVariable);
        $existeDato = $this->existeDatoVariable($idVariable, $fechaDato);
        if (empty($existeVariable)) {
            $log->crearLog($idModulo, 'Error al crear dato para la fecha ' . $fechaDato . ' para la variable ' . $idVariable . '. El Id de la variable no existe.');
            return "Id variable no existe";
        } else {
            if (empty($existeDato)) {
                $idDato = NULL;
                $resp = $variable->crearDatoVariable($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idVariable);
                if ($resp == "Creado") {
                    $log->crearLog($idModulo, 'El dato para la fecha ' . $fechaDato . ' para la variable ' . $idVariable . ' ha sido creado correctamente.');
                    return "Creado";
                } else {
                    $log->crearLog($idModulo, 'Error al crear dato para la fecha ' . $fechaDato . ' para la variable ' . $idVariable . '.');
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, 'Error al crear dato para la fecha ' . $fechaDato . ' para la variable ' . $idVariable . '. El dato ya existe.');
                return "Dato existe";
            }
        }
    }

    public function editarDatoVariable($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idVariable) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "variables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $variable = new Variable();
        $existeVariable = $variable->idVariableExiste($idVariable);
        $existeDato = $this->existeDatoVariable($idVariable, $fechaDato);
        if (empty($existeVariable)) {
            $log->crearLog($idModulo, 'Error al editar dato ' . $idDato . ' para la variable ' . $idVariable . '. El Id de la variable no existe.');
            return "Id variable no existe";
        } else {
            if (empty($existeDato)) {
                $log->crearLog($idModulo, 'Error al editar dato ' . $idDato . ' para la variable ' . $idVariable . '. El dato no existe.');
                return "Dato no existe";
            } else {
                $resp = $variable->editarDatoVariable($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idVariable);
                if ($resp == "Editado") {
                    $log->crearLog($idModulo, 'El dato ' . $idDato . ' para la variable ' . $idVariable . ' ha sido editado correctamente.');
                    return "Editado";
                } else {
                    $log->crearLog($idModulo, 'Error al editar dato ' . $idDato . ' para la variable ' . $idVariable . '.');
                    return "Error al editar";
                }
            }
        }
    }

    public function eliminarDatoVariable($idDato, $fechaDato, $idVariable) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "variables";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $variable = new Variable();
        $existeVariable = $variable->idVariableExiste($idVariable);
        $existeDato = $this->existeDatoVariable($idVariable, $fechaDato);
        if (empty($existeVariable)) {
            $log->crearLog($idModulo, 'Error al eliminar dato ' . $idDato . ' para la variable ' . $idVariable . '. El Id de la variable no existe.');
            return "Id variable no existe";
        } else {
            if (empty($existeDato)) {
                $log->crearLog($idModulo, 'Error al eliminar dato ' . $idDato . ' para la variable ' . $idVariable . '. El dato no existe.');
                return "Dato no existe";
            } else {
                $resp = $variable->eliminarDatoVariable($idDato, $fechaDato, $idVariable);
                if ($resp == "Eliminado") {
                    $log->crearLog($idModulo, 'El dato ' . $idDato . ' para la variable ' . $idVariable . ' ha sido eliminado correctamente.');
                    return "Eliminado";
                } else {
                    $log->crearLog($idModulo, 'Error al eliminar dato ' . $idDato . ' para la variable ' . $idVariable . '.');
                    return "Error al eliminar";
                }
            }
        }
    }

}
