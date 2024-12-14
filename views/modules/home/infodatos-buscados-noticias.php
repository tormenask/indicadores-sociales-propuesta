<?php
include_once 'models/noticias.php';
include_once 'controllers/noticias.php';
include_once 'models/consultas.php';
include_once 'controllers/consultas.php';
require_once 'models/indicadores.php';
require_once 'controllers/indicadores.php';
require_once 'models/datos.php';
require_once 'controllers/datos.php';
require_once 'models/seriesDatos.php';
require_once 'controllers/seriesDatos.php';
?>
<style>
    @media only screen and (max-width: 768px) and (min-width: 201px) { 
        #searches {height: 100px;}
    }
    @media only screen and (max-width: 991px) and (min-width: 768px) { 
        .diferent_visibility {visibility:hidden !important;}
        .diferent_visibility_btn {margin-top: -160px !important;}       
    }

.m-widget4 .m-widget4__item {
    display: table;
    padding-top: 1.15rem;
    padding-bottom: 1.25rem
}
.m-widget4 .m-widget4__item .m-widget4__img.m-widget4__img--pic img {
    width: 4rem;
    border-radius: 50%
}
.m-widget4 .m-widget4__item .m-widget4__info {
    display: table-cell;
    width: 100%;
    padding-left: 1.2rem;
    padding-right: 1.2rem;
    font-size: 1rem;
    vertical-align: middle
}
.m-widget4 .m-widget4__item .m-widget4__info .m-widget4__title {
    font-size: 1rem;
    font-weight: 600
}
</style>
<script src="views/resources/lib/jQCloud/jqcloud/jqcloud-1.0.4.min.js"></script>

<div class="row margin-infodatos">
<div class="col-xs-12 col-sm-4">
        <div class="panel panel-principal" style="box-shadow: 0px 15px 25px rgba(0,0,0,.23);">
            <div style="padding: 8px 8px;">
                    <div class="panel-title" style="display: inline-block; padding: 0 10px; border-radius: 4px; text-align: left importat!; color: #fff;background-color: #07812d;">INFODATOS</div>
                    <a href="#" style="margin-left: 50%;"></a>
            </div>
            <div class="panel-body" style="height: 400px;padding: 5px 9px;">
                <div id="infodatos-carousel" class="carousel slide" data-ride="carousel" data-interval="15000">
                    <div class="col-xs-12">
                        <div class="carousel-inner blocks" style="height: 400px">
                            <div class="item active">
                                <div class="carousel-content">
                                    <div>
                                        <h3 class="center-tittle" style="color: #07812d;">ANÁLISIS DE DATOS</h3>
                                        <p>Es un proceso de inspeccionar, limpiar y transformar datos con el objetivo de resaltar información útil, lo que sugiere conclusiones...</p>
                                        <h3 class="center-tittle diferent_visibility" style="color: #07812d;">EFICACIA</h3>
                                        <p class="diferent_visibility">Mide el logro de los resultados propuestos y provee información sobre el grado en el que se realizan las actividades planificadas y la capacidad...</p>
                                        <div class="bottom diferent_visibility_btn" style="padding: 5px; background-color: #07812d; color: #fff;">
                                            <a href="informacion-interes/glosario" style="color:#fff; font-weight: bold;">Ver glosario</a>
                                        </div>
                                    </div>                                       
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-content">
                                    <div>
                                        <h3 class="center-tittle" style="color: #07812d;">EFECTIVIDAD</h3>
                                        <p>Mide el impacto de la gestión en el logro de los resultados y en el manejo de recursos. También miden el nivel de satisfacción del usuario que aspira a recibir un servicio...</p>
                                        <h3 class="center-tittle diferent_visibility" style="color: #07812d;">FRECUENCIA DE MEDICIÓN</h3>
                                        <p class="diferent_visibility">Periodo de tiempo con el que se realiza la medición de un indicador los cuales pueden ser: mensual...</p>
                                        <div class="bottom diferent_visibility_btn" style="padding: 5px; background-color: #07812d; color: #fff;">
                                            <a href="informacion-interes/glosario" style="color:#fff; font-weight: bold;">Ver glosario</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="carousel-content">
                                    <div>
                                        <h3 class="center-tittle" style="color: #07812d;">INDICADOR</h3>
                                        <p>Representación cuantitativa establecida mediante una variable o la relación entre dos o más variables, que ayuda a la entidad medir el...</p>
                                        <h3 class="center-tittle diferent_visibility" style="color: #07812d;">INDICE</h3>
                                        <p class="diferent_visibility">Es una cifra que indica la evolución o cambio, con el tiempo o de un lugar a otro, de una cantidad que es descriptiva del volumen de un agregado...</p>
                                        <div class="bottom diferent_visibility_btn" style="padding: 5px; background-color: #07812d; color: #fff;">
                                            <a href="informacion-interes/glosario" style="color:#fff; font-weight: bold;">Ver glosario</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a style="width: 3%; background-image: none; color: #ddd;" class="left carousel-control" href="#infodatos-carousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" style="font-size: 20px; margin-left: -18px; margin-top:66px"></span>
                    </a>
                    <a style="width: 3%; background-image: none; color: #ddd;" class="right carousel-control" href="#infodatos-carousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" style="font-size: 20px; margin-right: -18px; margin-top:66px"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4">       
        <div class="panel panel-principal" style="box-shadow: 0px 15px 25px rgba(0,0,0,.23)">
            <div class="panel-body" style="padding: 0px 0px 0px 0px;">
                <div id="news-carousel" 
                     class="carousel bs-slider slide control-round indicators-line" 
                     data-ride="carousel" data-pause="hover" data-interval="10000" style="background: none;" >
                    <div class="carousel-inner" role="listbox" style="width: 100%;">
                        <?php
                        $noticia = new NoticiaController();
                        $noticia->listarNoticiasHome();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Controls -->
        <a style="width: 3%; background-image: none; color: #ddd;" class="left carousel-control" href="#news-carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" style="font-size: 20px; margin-left: 10px; "></span>
        </a>
        <a style="width: 3%; background-image: none; color: #ddd;" class="right carousel-control" href="#news-carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" style="font-size: 20px; margin-right: 10px; "></span>
        </a>
    </div>
    <!-- <div class="col-xs-12 col-sm-4">
        <div class="panel panel-principal" style="box-shadow: 0px 15px 25px rgba(0,0,0,.23);">
            <div style="padding: 8px 8px;">
                    <div class="panel-title" style="display: inline-block; padding: 0 10px; border-radius: 4px; text-align: left importat!; color: #fff;background-color: #cd1118;">INDICADORES MAS BUSCADOS</div>
                    <a href="#" style="margin-left: 50%;"></a>
            </div>
            <div class="panel-body" style="height: 400px;">
                <div id="searches" >
                    <br>
                    <?php
                    // $cons = new ConsultasController();
                    // $cons->consultaIndicadoresMasBuscadosController();
                    ?>
                </div>
            </div>
        </div>
    </div>   -->
    
    

    <div class="col-xs-12 col-sm-4">
        <div class="panel panel-principal" style="box-shadow: 0px 15px 25px rgba(0,0,0,.23);">
            <div style="padding: 8px 8px;">
                    <div class="panel-title" style="display: inline-block; padding: 0 10px; border-radius: 4px; text-align: left importat!; color: #fff;background-color: #cd1118;">INDICADORES MAS BUSCADOS</div>
                    <a href="#" style="margin-left: 50%;"></a>
            </div>
            <div class="panel-body" style="height: 400px;">
                <div class="col-xs-12 col-sm-12"> 
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_widget4_tab1_content">
                                <div class="m-widget4 m-widget4--progress">
                                    <?php
                                        $cons = new ConsultasController();
                                        $cons->consultaIndicadoresMasBuscadosController();
                                    ?>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    



    
</div>