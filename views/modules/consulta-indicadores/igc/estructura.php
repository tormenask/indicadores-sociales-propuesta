<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li><a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/igc">Indicadores Globales de Ciudad</a></li>
        <li class="active"><a href="/consulta-indicadores/igc/estructura">Estructura</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/igc/sidebar-igc.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>Estructura de los Indicadores Globales de Ciudad</h1>
                <hr>
                <h3>Categorías y Temáticas</h3>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <img src="/views/resources/images/igc/estructura/servicios_ciudad.png" 
                                     class="img-circle img-dim" alt="Categoría: Servicios de Ciudad">
                                <h3 class="panel-title text-title">
                                    Servicios de Ciudad
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-5 lista-ul">
                                    <ul>
                                        <li>Agua Potable</li>
                                        <li>Aguas Residuales</li>
                                        <li>Educación</li>                                        
                                        <li>Energía</li>
                                        <li>Finanzas</li>
                                        <li>Gobernanza</li>
                                    </ul>
                                </div>
                                <div class="col-sm-7">
                                    <ul>
                                        <li>Recreación</li>
                                        <li>Residuos Sólidos</li>
                                        <li>Respuesta a Incendios y Emergencias</li>
                                        <li>Salud</li>
                                        <li>Seguridad</li>
                                        <li>Transporte</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <img src="/views/resources/images/igc/estructura/calidad_vida.png" 
                                         class="img-circle img-dim" alt="Categoría: Calidad de vida">
                                    Calidad de vida
                                </h3>
                            </div>
                            <div class="panel-body">
                                <ul>
                                    <li>Cultura</li>
                                    <li>Economía</li>
                                    <li>Equidad Social</li>
                                    <li>Medio Ambiente</li>
                                    <li>Participación Ciudadana</li>
                                    <li>Planificación y Desarrollo Urbano</li>
                                    <li>Tecnología e innovación</li>
                                    <li>Vivienda</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="text-align: center;">
                    <h6>Fuente: Elaboración DAP – Equipo SIS</h6>
                </div>
                <br>
                <p>
                    De la misma manera, cada temática tiene asociado una serie de indicadores que expresan la medida del desempeño de las ciudades en cada uno de estos temas. Los indicadores son clasificados en indicadores centrales y de apoyo, determinados de acuerdo al reconocimiento entre recursos y capacidades. La siguiente tabla contiene el número de indicadores asociados a cada temática: 
                </p>
                <br>
                <div class="centerTable">
                    <table class= "table table-striped table-bordered table-hover table-responsive" style="width: 80%">
                        <thead>
                            <tr>
                                <td style="background-color:#215a9a; color:#fff; text-align:center">Categoría</td>
                                <td style="background-color:#215a9a; color:#fff; text-align:center">Temas</td>
                                <td style="background-color:#215a9a; color:#fff; text-align:center">N° de indicadores</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="13" style="text-align:center;">1. Servicios de ciudad</td>
                                <td>1. Agua Potable</td>
                                <td style="text-align: center;">6</td>
                            </tr>
                            <tr>
                                <td>2. Aguas Residuales</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr>
                                <td>3. Educación</td>
                                <td style="text-align: center;">7</td>
                            </tr>
                            <tr>
                                <td>4. Energía</td>
                                <td style="text-align: center;">6</td>
                            </tr>
                            <tr>
                                <td>5. Finanzas</td>
                                <td style="text-align: center;">4</td>
                            </tr>
                            <tr>
                                <td>6. Gobernanza</td>
                                <td style="text-align: center;">1</td>
                            </tr>
                            <tr>
                                <td>7. Recreación</td>
                                <td style="text-align: center;">2</td>
                            </tr>
                            <tr>
                                <td>8. Residuos Sólidos</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr>
                                <td>9. Respuesta a Incendios y Emergencias</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr>
                                <td>10. Salud</td>
                                <td style="text-align: center;">5</td>
                            </tr>
                            <tr>
                                <td>11. Seguridad</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr>
                                <td>12. Transporte</td>
                                <td style="text-align: center;">6</td>
                            </tr>
                            <tr>
                                <td rowspan="7" style="text-align:center;">2. Servicios de ciudad</td>
                                <td>14. Cultura</td>
                                <td style="text-align: center;">1</td>
                            </tr>
                            <tr>
                                <td>15. Economía</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr>
                                <td>16. Equidad Social</td>
                                <td style="text-align: center;">1</td>
                            </tr>
                            <tr>
                                <td>17. Medio Ambiente</td>
                                <td style="text-align: center;">5</td>
                            </tr>
                            <tr>
                                <td>18. Participación Ciudadana</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr>
                                <td>19. Planificación y Desarrollo Urbano</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr>
                                <td>20. Tecnología e información</td>
                                <td style="text-align: center;">5</td>
                            </tr>
                            <tr>
                                <td>21. Vivienda</td>
                                <td style="text-align: center;">3</td>
                            </tr>
                            <tr style="background-color: #74bdd5; color: #fff; text-align: center;" >
                                <td><strong>Total</strong></td>
                                <td><strong>21</strong></td>
                                <td><strong>74</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <h6>Fuente: Elaboración DAP – Equipo SIS</h6>
                </div>

                <div style="text-align: center;">
                    <hr>
                    <h6>Tabla 1:  Propuesta de Indicadores Globales para Ciudades</h6>
                    <div style="text-align: left;">
                        <table class= "table table-striped table-bordered table-responsive ajustar-table" style="width: 45%">
                            <tbody>
                                <tr>
                                    <td style="background-color:#f01564; border-color: #f01564; text-align: center; width: 9%;"></td>
                                    <td style="color:#f01564; border-color: #f01564; text-align: center;">Indicadores centrales</td>
                                    <td style="background-color:#009bcc; border-color:#009bcc; text-align: center; width: 9%;"></td>
                                    <td style="color:#009bcc; border-color:#009bcc; text-align: center;">Indicadores de apoyo</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class= "table table-striped table-bordered table-responsive ajustar-table">
                        <thead>
                            <tr style="text-align: center; background-color:#215a9a; color:#fff; ">
                                <td style="width: 15%;">Tema</td>
                                <td>Indicadores Globales para Ciudades</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: left; background-color: #e4e4e4">Servicios de Ciudad</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Educación</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de niños que concluyen la educación primaria y secundaria</li>
                                        <li style="color:#f01564;">Porcentaje de niños en edad escolar inscritos en escuelas (por género)</li>
                                        <li style="color:#009bcc;">Proporción estudiante/profesor</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Energía</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de la población en la ciudad que cuenta con servicios de energía eléctrica autorizada</li>
                                        <li style="color:#009bcc;">Uso total de electricidad per cápita</li>
                                        <li style="color:#009bcc;">Número y duración de interrupciones eléctricas por año por consumidor</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Finanzas</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Proporción del servicio de la deuda</li>
                                        <li style="color:#009bcc;">Impuestos recolectados como porcentaje de impuestos cobrados</li>
                                        <li style="color:#009bcc;">Ganancias por fuentes propias como porcentaje de ganancias totales</li>
                                        <li style="color:#009bcc;">Gastos capitales como porcentaje de gastos totales</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Incendios y Respuesta a Emergencias</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Número de bomberos por 100,000 habitantes</li>
                                        <li style="color:#f01564;">Número de muertes relacionadas a incendios por 100,000 habitantes</li>
                                        <li style="color:#009bcc;">Tiempo de respuesta de los bomberos desde la llamada inicial</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Gobernanza</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Responsabilidad y Transparencia</li>
                                        <li style="color:#009bcc;">Porcentaje de trabajadores del gobierno de la ciudad que son mujeres o minorías</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Salud</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Mortalidad en niños menores a cinco años por 1,000 nacimientos vivos</li>
                                        <li style="color:#f01564;">Inmunizaciones contra enfermedades infecciosas infantiles</li>
                                        <li style="color:#009bcc;">Número de camas para pacientes hospitalizados por 100,000 habitantes</li>
                                        <li style="color:#009bcc;">Número de médicos por 100,000 habitantes</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Seguridad</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Número de homicidios por 100,000 habitantes</li>
                                        <li style="color:#f01564;">Número de policías bajo juramento por 100,000 habitantes</li>
                                        <li style="color:#009bcc;">Crimen violento por 100,000 habitantes</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Residuos sólidos</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de la población en la ciudad con recolección regular de residuos sólidos</li>
                                        <li style="color:#f01564;">Porcentaje de residuos sólidos dispuestos en un relleno sanitario/ incinerado o quemado abiertamente/ dispuesto en un botadero</li>
                                        <li style="color:#009bcc;">Generación total de residuos sólidos per cápita</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Transporte</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Km de sistema de transporte por 100,000 habitantes</li>
                                        <li style="color:#f01564;">Número anual de viajes por transporte público per cápita</li>
                                        <li style="color:#009bcc;">Conectividad aérea comercial (número de destinos aéreos comerciales sin parada)</li>
                                        <li style="color:#009bcc;">Facilidades de transporte por 100,000 habitantes</li>
                                        <li style="color:#009bcc;">Velocidad promedio de transporte en rutas primarias durante horas pico</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Aguas Residuales</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de la población citadina con servicio de abastecimiento de agua potable</li>
                                        <li style="color:#009bcc;">Consumo de agua potable per cápita</li>
                                        <li style="color:#009bcc;">Número de interrupciones en el servicio de abastecimiento de agua potable</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left; background-color: #e4e4e4">Calidad de vida</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Participación Ciudadana</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Participación de votantes (como porcentaje de votantes hábiles)</li>
                                        <li style="color:#009bcc;">Número de oficiales locales elegidos para el cargo por 100,000 habitantes</li>
                                        <li style="color:#009bcc;">Número de organizaciones cívicas por 100,000 habitantes</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Cultura</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Número de establecimientos culturales por 100,000 habitantes</li>
                                        <li style="color:#009bcc;">Gastos de la ciudad en cultura como porcentaje del presupuesto total de la ciudad</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Economía</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Producto de la ciudad per cápita</li>
                                        <li style="color:#009bcc;">Relación de empleo por edad y sexo</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Medio Ambiente</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Emisiones de efecto invernadero medidos en toneladas per cápita</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Vivienda</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de la población citadina que vive en barriadas</li>
                                        <li style="color:#009bcc;">Área de asentamientos informales como porcentaje del área de la cuidad y población</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Equidad Social</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de la población citadina que vive en la pobreza</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Tecnología e innovación</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Número de conexiones a Internet por 100,000 habitantes</li>
                                        <li style="color:#009bcc;">Número de teléfonos (líneas fijas y teléfonos celulares) por 100,000 habitantes</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    <h6>Tabla 2:  Propuesta de Futuros Indicadores e Índices Deseados</h6>
                    <div style="text-align: left;">
                        <table class= "table table-striped table-bordered table-responsive" style="width: 45%">
                            <tbody>
                                <tr>
                                    <td style="background-color:#f01564; border-color: #f01564; text-align: center; width: 9%;"></td>
                                    <td style="color:#f01564; border-color: #f01564; text-align: center;">Indicadores centrales</td>
                                    <td style="background-color:#009bcc; border-color:#009bcc; text-align: center; width: 9%;"></td>
                                    <td style="color:#009bcc; border-color:#009bcc; text-align: center;">Indicadores de apoyo</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <table class= "table table-striped table-bordered table-responsive">
                        <thead>
                            <tr style="text-align: center; background-color:#215a9a; color:#fff; ">
                                <td style="width: 15%;">Tema</td>
                                <td>Indicadores Globales para Ciudades</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="2" style="text-align: left; background-color: #e4e4e4">Servicios de Ciudad</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Educación</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Número de bibliotecas por 100,000 habitantes</li>
                                        <li style="color:#f01564;">Número de visitas a la biblioteca por 100,000 habitantes</li>
                                        <li style="color:#f01564;">Desempeño en pruebas (exámenes) estandarizadas</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Energía</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Participación en uso de energías renovables para la provisión de energía primaria</li>
                                        <li style="color:#f01564;">Uso residencial de energía por vivienda por tipo de energía</li>
                                        <li style="color:#009bcc;">Índice de uso total de energía</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Respuesta a Incendios y Emergencias</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Tiempo de respuesta de la ambulancia desde la llamada inicial</li>
                                        <li style="color:#f01564;">Indicadores de servicios de emergencia médica</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Gobernanza</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Número promedio de días para obtener una licencia de negocios</li>
                                        <li style="color:#f01564;">Solicitud de tiempo de respuesta para los servicios</li>
                                        <li style="color:#009bcc;">Índice de Gobernanza de Ciudades</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Salud</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Índice anual de muertes por HIV/SIDA por 100,000 habitantes</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Seguridad</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Percepción de la seguridad</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Residuos sólidos</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de la población que participa en programas de reciclaje</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Transporte</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Gastos totales en vías y tránsito municipal per cápita</li>
                                        <li style="color:#f01564;">División modal</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Aguas Residuales</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Un indicador de la efectividad del tratamiento de agua residual</li>
                                        <li style="color:#f01564;">Porcentaje de la capacidad asimilativa del uso del cuerpo de agua receptor</li>
                                        <li style="color:#009bcc;">Número de interrupciones en el servicio de abastecimiento de agua potable</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Agua</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Porcentaje de agua tratada que se pierde durante la distribución</li>
                                        <li style="color:#f01564;">Calidad de agua (en relación a los estándares nacionales y avisos públicos de hervir el agua)</li>
                                        <li style="color:#f01564;">Incidencia de enfermedades relacionadas al agua</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left; background-color: #e4e4e4">Calidad de vida</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Cultura</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Asistencia a eventos culturales per cápita</li>
                                        <li style="color:#009bcc;">Niveles de inversión</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Economía</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Evaluaciones comerciales/ industriales como porcentaje de las evaluaciones totales</li>
                                        <li style="color:#f01564;">Relación de empleo por edad y sexo</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Medio Ambiente</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Número de días que se excede el nivel de PM10</li>
                                        <li style="color:#f01564;">Indicador que relacione la calidad de aire con problemas respiratorios</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Vivienda</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Relación de precio de viviendas/ ingresos</li>
                                        <li style="color:#f01564;">Relación de renta/ ingreso</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Equidad Social</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Costo de las necesidades básicos o Medida de Canasta Básica</li>
                                        <li style="color:#f01564;">Porcentaje de la población que recibe asistencia financiera del gobierno</li>
                                        <li style="color:#009bcc;">Índice de Capital Social</li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Tecnología e innovación</td>
                                <td style="text-align:justify;">
                                    <ul>
                                        <li style="color:#f01564;">Inversiones de capital de riesgo</li>
                                        <li style="color:#f01564;">Relación de penetración de la banda ancha</li>
                                        <li style="color:#009bcc;">Índice de creatividad</li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consultaIndicadores").addClass("active");
    $("#consultaIGC").addClass("active");
</script>