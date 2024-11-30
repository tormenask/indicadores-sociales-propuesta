<?php

class DatoController {

    public function mostrarCrearDato($idConjuntoIndicadores) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $dat = new Dato();
        $resp = $dat->listarDatosPorConjunto($idConjuntoIndicadores);
        $permiso = $rol->consultarPermisoRol("datos" . $idConjuntoIndicadores, $idRol);
        $crear = $permiso["crear"];
        $modificar = $permiso["modificar"];
        $eliminar = $permiso["eliminar"];
        if (!$crear && !$modificar && !$eliminar) {
            header("Location: index.php?action=admin/home");
        }
        echo '  <div class="row">
                    <div class="col-sm-12">
                        <h3>Gestión de datos</h3><br>
                    </div>
                </div>
                ';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/datos/crearDato&conj=' . $idConjuntoIndicadores . '" 
                            class="btn btn-primary" role="button">Agregar datos</a>
                        </div>
                        <hr>
                    </div>
                </div>';
        }
    }

    public function mostrarConsultarDatos($idConjuntoIndicadores) {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $dat = new Dato();
        $permiso = $rol->consultarPermisoRol("datos" . $idConjuntoIndicadores, $idRol);
        $crear = $permiso["crear"];
        $modificar = $permiso["modificar"];
        $eliminar = $permiso["eliminar"];
        if (!$crear && !$modificar && !$eliminar) {
            header("Location: index.php?action=admin/home");
        } else {
            include $_SERVER['DOCUMENT_ROOT'] . '/app/view/modules/admin/datos/consultaDatos.php';
        }
    }

    public function listarDatosIndicador($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica, $idRol) {
        $rol = new Rol();
        $dat = new Dato();
        $ser = new SerieDatos();
        $ind = new Indicador();
        $tem = new Tematica();
        $dim = new Dimension();
        $idTematica = $ind->consultarTematicaPorIndicador($idIndicador);
        $idDimension = $tem->consultarDimensionPorTematica($idTematica["idTematica"]);
        $idConj = $dim->consultarConjuntoIndicadoresPorDimension($idDimension["idDimension"]);
        $idConjuntoIndicadores = $idConj["idConjuntoIndicadores"];
        $idSerieDatos = $ser->consultarIdSeriePorIdIndicadorZonaTipoDesagregacionTematica($idIndicador, $tipoZonaGeografica, $zonaGeografica, $desagregacionTematica)[0];
        $resp = $dat->listarDatosPorIdSerie($idSerieDatos);
        $permiso = $rol->consultarPermisoRol("datos" . $idConjuntoIndicadores, $idRol);
        $crear = $permiso["crear"];
        $modificar = $permiso["modificar"];
        $eliminar = $permiso["eliminar"];
        if (!$crear && !$modificar && !$eliminar) {
            header("Location: index.php?action=admin/home");
        } else {

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
                    <p><b>Id de la serie de datos:</b> <span id="idSerieDat">' . $idSerieDatos . '</span></p>
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
                $idDato = $item["idDato"];
                $estadoObservacionDato = $item["estadoObservacionDato"];
                if ($item["estadoObservacionDato"] == "") {
                    $estadoObservacionDato = "-";
                }
                echo '      <tr>
                                <td></td>  
                                <td id="prewrap">' . $idDato . '</td>  
                                <td id="prewrap" style="text-align:center;">' . $item["fechaDato"] . '</td>
                                <td id="prewrap" style="text-align:right;">' . number_format($item["valorDato"], 2) . '</td>
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
                                <label class='control-label' for='idSerieDatos'>Id de la serie de datos</label>
                                <input name='idSerieDatos' id='idSerieDatos' required class='form-control' placeholder='Id de la serie de datos' disabled value='" . $idSerieDatos . "'>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='fechaDato'>Fecha del dato</label>
                                <select name='fechaDato' id='fechaDato' class='form-control'>
                                </select>
                            </div>
                            <script>
                                select = document.getElementById('fechaDato');
                                for(i = 1980; i <= 2030; i++){
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
                                <label class='control-label' for='id-serie-edit'>Id de la serie de datos</label>
                                <input name='idSerieDatos' id='id-serie-edit' required class='form-control' placeholder='Id de la serie de datos' disabled value='" . $idSerieDatos . "'>
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
                                for(i = 1980; i <= 2030; i++){
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
                                <label class='control-label' for='id-serie-delete'>Id de la serie de datos</label>
                                <input name='idSerieDatos' id='id-serie-delete' required class='form-control' placeholder='Id de la serie de datos' disabled value='" . $idSerieDatos . "'>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='id-dato-delete'>Id del dato</label>
                                <input name='id-dato-edit' id='id-dato-delete' required class='form-control' placeholder='Id del dato' disabled>
                            </div>
                            <div class='form-group'>
                                <label class='control-label' for='fecha-dato-delete'>Fecha del dato</label>
                                <select name='fecha-dato-edit' id='fecha-dato-delete' class='form-control' disabled>
                                </select>
                            </div>
                            <script>
                                select = document.getElementById('fecha-dato-delete');
                                for(i = 1980; i <= 2030; i++){
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
    }

    public function crearDato($fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatos) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "datos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $dato = new Dato();
        $serie = new SerieDatos();
        $existeSerie = $serie->idSerieDatosExiste($idSerieDatos);
        $existeDato = $this->existeDato($idSerieDatos, $fechaDato);
        if (empty($existeSerie)) {
            $log->crearLog($idModulo, "Error al crear dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . '. El Id de la serie no existe.');
            return "Id serie no existe";
        } else {
            if (empty($existeDato)) {
                $idDato = NULL;
                $resp = $dato->crearDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatos);
                if ($resp == "Creado") {
                    $log->crearLog($idModulo, "Dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . ' creado correctamente.');
                    return "Creado";
                } else {
                    $log->crearLog($idModulo, "Error al crear dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato);
                    return "Error al crear";
                }
            } else {
                $log->crearLog($idModulo, "Error al crear dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . '. Ya existe un dato para ese año en la serie.');
                return "Dato existe";
            }
        }
    }

    public function editarDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatos) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "datos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $dato = new Dato();
        $serie = new SerieDatos();
        $existeSerie = $serie->idSerieDatosExiste($idSerieDatos);
        $existeDato = $this->existeDato($idSerieDatos, $fechaDato);
        if (empty($existeSerie)) {
            $log->crearLog($idModulo, "Error al editar el dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . '. El Id de la serie no existe.');
            return "Id serie no existe";
        } else {
            if (empty($existeDato)) {
                $log->crearLog($idModulo, "Error al editar el dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . '. El dato no existe.');
                return "Dato no existe";
            } else {
                $resp = $dato->editarDato($idDato, $fechaDato, $valorDato, $estadoObservacionDato, $idSerieDatos);
                if ($resp == "Editado") {
                    $log->crearLog($idModulo, "Dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . ' editado correctamente.');
                    return "Editado";
                } else {
                    $log->crearLog($idModulo, "Error al editar el dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato);
                    return "Error al editar";
                }
            }
        }
    }

    public function eliminarDato($idDato, $fechaDato, $idSerieDatos) {
        session_start();
        $modulo = new Modulo();
        $nombreModulo = "datos";
        $idModulo = $modulo->consultarIdModuloPorNombre($nombreModulo);
        $log = new LogController();
        $dato = new Dato();
        $serie = new SerieDatos();
        $existeSerie = $serie->idSerieDatosExiste($idSerieDatos);
        $existeDato = $this->existeDato($idSerieDatos, $fechaDato);
        if (empty($existeSerie)) {
            $log->crearLog($idModulo, "Error al eliminar el dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . '. El Id de la serie no existe.');
            return "Id serie no existe";
        } else {
            if (empty($existeDato)) {
                $log->crearLog($idModulo, "Error al eliminar el dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . '. El dato no existe.');
                return "Dato no existe";
            } else {
                $resp = $dato->eliminarDato($idDato, $fechaDato, $idSerieDatos);
                if ($resp == "Eliminado") {
                    $log->crearLog($idModulo, "Dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato . ' eliminado correctamente.');
                    return "Eliminado";
                } else {
                    $log->crearLog($idModulo, "Error al eliminar el dato para la serie " . $idSerieDatos . ' - Fecha: ' . $fechaDato);
                    return "Error al eliminar";
                }
            }
        }
    }

    public function existeDato($idSerieDatos, $fechaDato) {
        $dato = new Dato();
        $existe = $dato->existeDato($idSerieDatos, $fechaDato);
        if ($existe["fechaDato"] !== NULL && $existe["fechaDato"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
