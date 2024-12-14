<!-- Sidebar -->
<?php
require_once 'controllers/dimensiones.php';
require_once 'models/dimensiones.php';

require_once 'controllers/tematicas.php';
require_once 'models/tematicas.php';

require_once 'controllers/indicadores.php';
require_once 'models/indicadores.php';

require_once 'controllers/seriesDatos.php';
require_once 'models/seriesDatos.php';

require_once 'controllers/datos.php';
require_once 'models/datos.php';

require_once 'controllers/consultas.php';
require_once 'models/consultas.php';

$resp = new ConsultasController();
?>
<div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading" style="background-color: #fff;text-align: center;">
        <img src="views/resources/images/home/logoDadii.png" style="height: 90px;" alt="Imagen de presentación del Departamento Administrativo de Desarrollo e Innovación Institucional" style="height: 90px;"/>    
    </div>    
    <!--<div class="sidebar-nav">-->     
    <div class="panel-group" id="accordion">
        <div class="panel panel-default" >
            <div class="panel-heading" style="background-color: #2fb56a;">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#informacion-conjunto" 
                       style="font-size: 14px; color: #fff;">
                        Acerca del organismo
                    </a>
                </h4>
            </div>
            <div id="informacion-conjunto" class="panel-collapse collapse in">
                <ul class="list-group" style="font-size: 13px;">
                    <li class="list-group-item"><a style="color: #000;" href="consulta-indicadores/dadii/presentacion">Presentación</a></li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #2fb56a;">
                <h4 class="panel-title" style="font-size: 14px; color: #fff;">
                    Consulta por nombre del indicador o por código del proceso 
                </h4>
            </div>
        </div>   
        <div id="informacion-conjunto" >
            <div class="form-group" style="width: 100%;">
                <select class="form-control" id="listarIndicadores" name="listarIndicadores" multiple="multiple">
                </select>
            </div>
        </div>
        <form class="panel panel-default"  style="background-color: #f5f5f5;" action="javascript:buscarProceso();">
            <input id="buscarProcesoText" class="input-searcherDadii" name="buscarProcesoText" placeholder="Ingrese el código del proceso a consultar" type="text" value="" onkeyup="contarCaracteres();"onkeydown="contarCaracteres();" /> 
            <button class="btn btn-searcher" style="background-color: #f5f5f5;"><i class="fa fa-search" style="color: #333;"></i></button>
        </form>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #2fb56a;">
                <h4 class="panel-title" style="font-size: 14px; color: #fff;">
                    Consulta general de los indicadores de desempeño
                </h4>
            </div> 
        </div> 
        <a href="consulta-indicadores/dadii/GENERALIDADES/INDICADORES" class="panel panel-default list-group-item indicadores-titulos" >Indicadores de gestión</a>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #2fb56a;">
                <h4 class="panel-title" style="font-size: 14px; color: #fff;">
                    Consulta los indicadores de desempeño
                </h4>
            </div> 
        </div> 

        <?php
        $resp->consultarListadoIndicadoresDadii('DADII', '');
        ?>
    </div>
    <script>
        function contarCaracteres() {
            var param = document.getElementById("buscarProcesoText").value;
            if (param.length < 3) {
                $("#error-contar-caracteres").show();
            } else {
                $("#error-contar-caracteres").hide();
            }
        }
        function buscarProceso() {
            var param = document.getElementById("buscarProcesoText").value;
            if (param.length < 3) {
                var resp = "<div class='alert alert-danger alert-dismissable'>\n\
                Error al realizar la búsqueda.<br>\n\
                Debe ingresar al menos tres caracteres para realizar la búsqueda. <br>\n\
                Para volver a la página principal, haga clic <a href='consulta-indicadores/dadii/' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n\
                </div>";
                $('#tabsTematica').html(resp);
                $('#tabsTematica').show();
            } else {
                $("#error-contar-caracteres").hide();
                consultarProceso(param);
            }
        }
    </script>

    <script>
        function consultarProceso(param) {
            if (param.length >= 3) {
                var data = new FormData();
                data.append("consultaProceso", param);
                var url = "/views/modules/consulta-indicadores/dadii/consultas.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        console.log(resp);
                        if (resp.includes("consulta-indicadores/dadii/")) {
                            window.location.href = resp;
                        } else {
                            $("#tabsTematica").html(resp);
                            $("#tabsTematica").show();
                        }
                    }
                });
            }
        }
    </script>
    <script>
        $("#listarIndicadores").multiselect({
            nonSelectedText: "Ingrese el nombre del indicador a consultar",
//            nSelectedText: ' desagregaciones seleccionadas',
            enableHTML: "Seleccione el indicador a consultar",
            buttonWidth: "100%",
            disableIfEmpty: true,
            enableCaseInsensitiveFiltering: true,
            maxHeight: 250,
            filterPlaceholder: 'Buscar indicador',
            onChange: function (element, checked) {
                var brands = $('#listarIndicadores option:selected');
                var indicadorSelect = [];
                $(brands).each(function (index, brand) {
                    indicadorSelect.push([$(this).val()]);
                });
                consultaIndicadorDadii(indicadorSelect);
            }
        });
        function consultaIndicadorDadii(indicadorSelect) {
            var data = new FormData();
            var url = "/views/modules/consulta-indicadores/dadii/consultas.php";
            data.append("indicadorSelect", indicadorSelect);
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                cache: false,
                async: true,
                contentType: false,
                processData: false,
                success: function (resp) {
//                    var result = eval(resp);
                    console.log(resp);
                    if (resp.includes("consulta-indicadores/dadii/")) {
                        window.location.href = resp;
                    }
//                    $('#listarIndicadores').multiselect('dataprovider', result);
                }
            });
        }
    </script>