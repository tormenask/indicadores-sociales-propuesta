<?php

class PerfilController {

    public function mostrarConsultarDatosPerfiles() {
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("perfiles", $idRol);
        $crear = $permiso["crear"];
        $modificar = $permiso["modificar"];
        $eliminar = $permiso["eliminar"];
        if (!$crear && !$modificar && !$eliminar) {
            header("Location: index.php?action=admin/home");
        } else {
            include $_SERVER['DOCUMENT_ROOT'] . '/app/view/modules/admin/perfiles/consultaPerfiles.php';
        }
    }

    public function listarDatosTipoZona($tipoZonaGeografica, $idRol) {

        $rol = new Rol();
        $perf = new Perfil();
        $permiso = $rol->consultarPermisoRol("perfiles", $idRol);
        $resp1 = $perf->listarDatosPorZonaGeograficaCali($tipoZonaGeografica);
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
                    .table>thead:first-child>tr:first-child>th {
                        border: 1px solid #ddd;
                    }
                </style>
                    <p><b>Tipo de zona geográfica:</b> <span id="tipo-zona-geografica">' . $tipoZonaGeografica . '</span></p>
                  
                    <table class="dataTable table table-striped cell-border" id="tabla-consulta">
                        <thead>
                            <tr>   
                                <th style="text-align:center;">Estado</th>                                
                                <th style="text-align:center;">Id</th>
                                <th style="text-align:center;">Dimensión</th>
                                <th style="text-align:center;">Tematica</th>
                                <th style="text-align:center;">Indicador</th>
                                <th style="text-align:center;">Zona Geográfica</th>
                                <th style="text-align:center;">Fecha</th>
                                <th style="text-align:center;">Valor</th>
                                <th style="text-align:center;">Unidad de medición</th>
                                <th style="text-align:center;">Fuente de datos</th>
                                <th style="text-align:center;">Regresar estado</th> 
                                
                            </tr>
                        </thead>
                        <tbody>';

            foreach ($resp1 as $row => $item) {
                $valorDato = $item["valorDato"];

                if ($valorDato !== "" && $valorDato !== "-") {
                    $valorDato = number_format($valorDato, 2);
                }
                $estado = "";
                if ($item['cali'] == 1 || $item['comuna'] == 1 || $item['corregimiento'] == 1) {
                    $estado = "Guardado";
                } else {
                    $estado = ' <button type="button" onClick="guardarEstado(' . "'" . $item['idIndicador'] . "'" . ');'
                            . '" id="idIndicadorGuardar" name="idIndicadorGuardar" class="btn btn-primary"> Guardar    </button>';
                }

                $estado2 = "";
                if ($estado != "Guardado" ) {
                    $estado2 = "Estado inicial";
                }else {
                    $estado2 = ' <button type="button" onClick="guardarEstadoDesguardar(' . "'" . $item['idIndicador'] . "'" . ');'
                            . '" id="idIndicadorDesguardar" name="idIndicadorDesguardar" class="btn btn-primary"> Desguardar   </button>';}
                echo '      <tr>
                                <td id="prewrap" style="text-align:center;">' . $estado . '</td>                                
                                <td id="prewrap" style="text-align:center;">' . $item["idIndicador"] . '</td>
                                <td id="prewrap" style="text-align:center;">' . $item["nombreDimension"] . '</td>
                                <td id="prewrap" style="text-align:center;">' . $item["nombreTematica"] . '</td>                                
                                <td id="prewrap" style="text-align:center;">' . $item["nombreIndicador"] . '</td>                                
                                <td id="prewrap" style="text-align:center;">' . $item["zonaGeografica"] . '</td>
                                <td id="prewrap" style="text-align:center;">' . $item["fechaDato"] . '</td>
                                <td id="prewrap" style="text-align:right;">' . $valorDato . '</td>
                                <td id="prewrap" style="text-align:center;">' . $item["unidadMedida"] . '</td>
                                <td id="prewrap" style="text-align:center;">' . $item["fuenteDatos"] . '</td>
                              <td id="prewrap" style="text-align:center;">' . $estado2 .'</td>
                            </tr>';
            }


            echo '
                        </tbody>
                    </table>';
            echo "
            <script>
            function guardarEstado(idIndicador) {
                var tipoZonaGeograficaGuardar = $('#tipoZonaGeograficaConsultaPerfiles').val();
                var url = 'view/modules/admin/perfiles/funcionesPerfiles.php';
                var data = new FormData();
                data.append('idIndicadorGuardar', idIndicador);
                data.append('tipoZonaGeograficaGuardar', tipoZonaGeograficaGuardar);                
            $.ajax({
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (resp) {
                        location.reload(); 
                        console.log(resp);
                        
                    }
                         });
            
            }
            </script>
            
            <script>
 function guardarEstadoDesguardar(idIndicador) {
                var tipoZonaGeograficaDesguardar = $('#tipoZonaGeograficaConsultaPerfiles').val();
                var url = 'view/modules/admin/perfiles/funcionesPerfiles.php';
                var data = new FormData();
                data.append('idIndicadorDesguardar', idIndicador);
                data.append('tipoZonaGeograficaDesguardar', tipoZonaGeograficaDesguardar);                
            $.ajax({
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function (resp) {
                        location.reload(); 
                        console.log(resp);
                        
                    }
                         });
            
            }
                       </script>
            

            <script>
                var table;
                $(document).ready(function() {
                    table = $('#tabla-consulta').DataTable({
                        'language': {
                            'url': '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
                        },
                        
             
        
                        
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
                           
                                ";
        }
    }

    public function crearDatoPerfil($zonaGeografica, $fechaDato, $valorDato, $posicion, $dimension, $indicador, $unidadMedicion, $fuenteDatos) {
        $perfil = new Perfil();
        $existeDato = $this->existeDato($zonaGeografica, $fechaDato, $dimension, $indicador);
        if (empty($existeDato)) {
            $idDato = NULL;
            $resp = $perfil->crearDatoPerfil($idDato, $zonaGeografica, $fechaDato, $valorDato, $posicion, $dimension, $indicador, $unidadMedicion, $fuenteDatos);
            if ($resp == "Creado") {
                return "Creado";
            } else {
                return "Error al crear";
            }
        } else {
            return "Dato existe";
        }
    }

    public function cambiarEstadoNotificacion($idIndicadorGuardar, $tipoZonaGeograficaGuardar) {
        $perfil = new Perfil();

        $resp = $perfil->estadoDeGuardado($idIndicadorGuardar,$tipoZonaGeograficaGuardar);
        if ($resp == "Editada") {
            return "Editada";
        } else {
            return "Error al editar";
        }
    }

    public function volverEstadoNotificacion($idIndicadorDesguardar,$tipoZonaGeograficaDesguardar) {
        $perfil = new Perfil();

        $resp = $perfil->volverEstado($idIndicadorDesguardar,$tipoZonaGeograficaDesguardar);
        if ($resp == "Editada") {
            return "Editada";
        } else {
            return "Error al editar";
        }
    }

    public function existeDato($zonaGeografica, $fechaDato, $dimension, $indicador) {
        $perfil = new Perfil();
        $existe = $perfil->existeDato($zonaGeografica, $fechaDato, $dimension, $indicador);
        if ($existe["fechaDato"] !== NULL && $existe["fechaDato"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

//
}
