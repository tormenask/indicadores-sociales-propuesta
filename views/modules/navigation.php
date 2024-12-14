<div class="row">
    <div class="col-sm-12 row-navigation">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container" style="width: 100%; margin-left: -30px;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand">
                        <a href="" title="Ir a la página principal">
                            <img alt="Sistema de Indicadores" class="img-logo-sis"
                                 src="views/resources/images/logo2.png">
                        </a>
                    </div>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav"></ul>
                    <ul class="nav navbar-nav navbar-right ajust-menu" >
                        <li id="home">
                            <a href="" title="Ir a la página principal"> 
                                <i class="fa fa-home" aria-hidden="true" style="font-size: 25px;"></i>
                            </a>
                        </li>
                        <li id="quienes-somos" class="dropdown">
                            <a href="#" class="dropdown-toggle" title="Módulo Quiénes Somos">Quiénes somos<b class="caret"></b></a>
                            <ul class="dropdown-menu menu-quienes-somos">
                                <li id="quienes-somos-presentacion" class="li-navb"><a href="quienes-somos/presentacion" title="Presentación del Sistema de Indicadores Sociales">Presentación</a></li>
                                <li id="quienes-somos-que-es" class="li-navb"><a href="quienes-somos/que-es" title="Qué es el Sistema de Indicadores Sociales">¿Qué es?</a></li>
                                <li id="quienes-somos-objetivos" class="li-navb"><a href="quienes-somos/objetivos" title="Objetivos del Sistema de Indicadores Sociales">Objetivos</a></li>
                                <li id="quienes-somos-ventajas" class="li-navb"><a href="quienes-somos/ventajas" title="Ventajas del Sistema de Indicadores Sociales">Ventajas</a></li>
                                <li id="quienes-somos-estructura" class="li-navb"><a href="quienes-somos/estructura" title="Estructura del Sistema de Indicadores Sociales">Estructura</a></li>
                                <li id="quienes-somos-estructura" class="li-navb"><a href="quienes-somos/analisis" title="Análisis del Sistema de Indicadores Sociales">Análisis</a></li>
                            </ul>
                        </li>
                        <li id="consulta-indicadores" class="dropdown">
                            <a href="#" class="dropdown-toggle" title="Módulo Consulta de Indicadores">Consulta de Indicadores<b class="caret"></b></a>
                            <ul class="dropdown-menu menu-consulta">
                                <li id="consulta-sis" class="li-navb"><a href="consulta-indicadores/dimensiones-sis" title="Consulta de Dimensiones para la Medición del Desarrollo Social">Dimensiones para la Medición del Desarrollo Social</a></li>
                                <li id="consulta-ods" class="li-navb"><a href="consulta-indicadores/ods" title="Consulta de Indicadores de los Objetivos de Desarrollo Sostenible">Indicadores de los Objetivos de Desarrollo Sostenible</a></li>
                                <li id="consulta-igc" class="li-navb"><a href="consulta-indicadores/igc" title="Consulta de Indicadores Globales de Ciudad">Indicadores Globales de Ciudad</a></li>
                                <li id="consulta-comunas" class="li-navb"><a href="consulta-indicadores/dimensiones-sis-comunas" title="Consulta de Indicadores por comunas">Indicadores por comunas</a></li>
                                <!-- <li id="consulta-piia" class="li-navb"><a href="consulta-indicadores/piia" title="Consulta de Indicadores de la Política de Primera Infancia, Infancia y Adolescencia">Indicadores de la Política de Primera Infancia, Infancia y Adolescencia</a></li> -->
                                <li id="consulta-exp" class="li-navb"><a href="consulta-indicadores/exp" title="Consulta de Indicadores del Expediente Municipal">Indicadores del Expediente Municipal</a></li>

                                <!-- <li id="consulta-dadii" class="li-navb"><a href="consulta-indicadores/dadii" title="Indicadores de desempeño Institucional">Indicadores de desempeño Institucional</a></li>
                                <li id="consulta-odraf" class="li-navb"><a href="consulta-indicadores/odraf" title="Consulta de Indicadores del Observatorio del Deporte, la Recreación y la Actividad Física">Indicadores del Observatorio del Deporte, la Recreación y la Actividad Física</a></li>
                                <li id="consulta-opc" class="li-navb"><a href="consulta-indicadores/opc" title="Visualizador de datos del Observatorio de Paz y Cultura Ciudadana">Visualizador de datos del Observatorio de Paz y Cultura Ciudadana</a></li> -->
                            </ul>
                        </li>
                        <li id="informacion-interes" class="dropdown">
                            <a href="#" class="dropdown-toggle" title="Módulo Información de Interés">Información de Interés<b class="caret"></b></a>
                            <ul class="dropdown-menu menu-informacion-interes">
                                <li id="informacion-interes-enlaces" class="li-navb"><a href="informacion-interes/enlaces" title="Enlaces">Enlaces</a></li>
                                <li id="informacion-interes-glosario" class="li-navb"><a href="informacion-interes/glosario" title="Glosario">Glosario</a></li>
                            </ul>
                        </li>
                        <li id="noticias"><a href="noticias" title="Noticias">Noticias</a></li>
                        <li id="contacto"><a href="http://www.cali.gov.co/participacion/publicaciones/43/oficina_de_atencin_al_ciudadano/" title="Contacto" target="_blank">Contacto</a></li>
                        <li id="home">
                            <a href="javascript:buscadorIndicadores()" title="Buscar indicadores"> 
                                <i class="fa fa-search-plus" aria-hidden="true" style="font-size: 25px;"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <script>
        $('ul.nav li.dropdown').hover(function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });
    </script>
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        function buscadorIndicadores(){
            var x = document.getElementById("consultaOtros");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
</div>
