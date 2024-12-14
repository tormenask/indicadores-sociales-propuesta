<style>
    .panel-graph{border: 1px solid #ddd;padding: 0px;border-radius: 4px;margin-bottom: 10px;}
    #number-records-nd {font-size: 55px;}
    #unrest-row-chart g.row text {transform: translateY(5px);}
    #gender-row-chart g.row text {transform: translateY(22px);}
    #age-segment-row-chart g.row text {transform: translateY(-1px);}
    #location-row-chart g.row text {transform: translateY(10px);}
    #comuna-bar-chart {margin-left: -7px;}
    #comuna-bar-chart g rect.bar {fill: #0da24b;}
    #comuna-bar-chart g rect.bar {fill: #0da24b;}
    #comuna-bar-chart g.stack rect.bar.selected {fill: #0da24b;}
    #comuna-bar-chart g.stack rect.bar.deselected {fill: #ccc;}
    #comuna-bar-chart g.axis.x {transform: translate(31,230);}
    #comuna-bar-chart g.axis.y {transform: translate(40,5);}
    #year-bar-chart g rect.bar {fill: #0da24b;}
    #year-bar-chart g.stack rect.bar.selected {fill: #0da24b;}
    #year-bar-chart g.stack rect.bar.deselected {fill: #ccc;}
    #year-bar-chart g.axis.x {transform: translate(31,230);}
    #year-bar-chart g.axis.y {transform: translate(40,5);}
    .dc-chart g.row text {fill: #211d1d;}
</style>
<div class="row">
    <div class="col-sm-5">
        <div class="row panel-graph">
            <div class="col-xs-12">
                <h6 style="color:#2fb56a;"><b>Total (Eventos registrados)</b></h6>
            </div>
            <div class="col-xs-12">
                <div class="chart-stage" style="height: 50px; padding: 10px 0px!important;">
                    <div id="number-records-nd"></div>
                </div>
            </div>
        </div>
        <div class="row panel-graph">
            <div class="col-xs-12">
                <h6 style="color:#2fb56a;"><b>Mapa de Cali por Barrios</b></h6>
            </div>
            <div class="col-xs-12">
                <div class="chart-stage" style="padding: 0px !important;">
                    <div id="cali-chart" style="width: 100%; height: 500px;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="row">
            <div class="col-sm-4">
                <div class="panel-graph">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 style="color:#2fb56a;"><b>Delitos</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="padding: 0px 10px;">
                            <div id="unrest-row-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel-graph">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 style="color:#2fb56a;"><b>Sexo</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="gender-row-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="panel-graph">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 style="color:#2fb56a;"><b>Rangos de edad</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="age-segment-row-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel-graph">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 style="color:#2fb56a;"><b>Comunas</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="comuna-bar-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="panel-graph">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 style="color:#2fb56a;"><b>Barrios - Top 4</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="location-row-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="panel-graph">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6 style="color:#2fb56a;"><b>Eventos registrados por año</b></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="year-bar-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <hr>
        <p><strong>Template:</strong> Construido por <a href="https://keen.io" target="_blank">Keen IO</a></p>
        <p><strong>Modificado por:</strong> Equipo del Observatorio de Paz y Convivencia</p>
        <p><strong>Ajustado y publicado por:</strong> Equipo del Sistema de Indicadores Sociales</p>
        <hr>
    </div>
</div>

<script src="views/resources/opc/lib/js/underscore-min.js"></script>
<script src="views/resources/opc/lib/js/crossfilter.js"></script>
<script src="views/resources/opc/lib/js/d3.min.js"></script>
<script src="views/resources/opc/lib/js/dc.min.js"></script> 
<script src="views/resources/opc/lib/js/queue.js"></script>
<script src="views/resources/opc/lib/js/leaflet.js"></script>
<script src="views/resources/opc/lib/js/keen.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/Edmonton-Open-Data/Edmonton-Bylaw-Infractions-II@master/libs/dc_addons/base-map-chart.js"></script>
<script src='views/resources/opc/lib/js/dc.leaflet.js'></script>
<script src='views/resources/opc/js/graphs.js' type='text/javascript'></script>
