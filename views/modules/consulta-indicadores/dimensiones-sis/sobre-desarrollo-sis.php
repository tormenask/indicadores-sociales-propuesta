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
<div class="row">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true" style="margin: 5rem;">
        <div class="panel panel-default" style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3);">
            <div class="panel-heading" role="tab" id="headingOne"
                style="background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
                <h4 class="panel-title" style="font-size:20px;">
                    Acerca de los indicadores
                </h4>
                <button
                    style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color:white;">
                        Ver más
                    </a>
                </button>

            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" style="padding:10px">
                <div class="panel-body">
                    <div id="text-index">
                        <h1>Sobre el Desarrollo Social</h1>
                        <hr>
                        <p>
                            El concepto de desarrollo ha evolucionado a través del tiempo como respuesta a los cambios
                            experimentados por la sociedad. Todos, incluyen nuevos criterios que le permiten a los
                            gobernantes,
                            investigadores y ciudadanía en general, identificar las problemáticas que presenta la
                            sociedad y la
                            alejan del estado de bienestar. En la actualidad, son muchos los debates e interrogantes que
                            surgen
                            en torno a un marco conceptual que permita definir con precisión el desarrollo. La
                            construcción de
                            indicadores en el campo social y económico ha estado asociada a la evolución del concepto de
                            desarrollo, pasando de un enfoque reduccionista “economicista” a una concepción más integral
                            y
                            multidimensional como se observa en el siguiente cuadro.
                        </p>
                        <br>
                        <div class="centerTable">
                            <table class="table table-striped table-bordered table-hover table-responsive"
                                style="width: 80%">
                                <thead>
                                    <tr>
                                        <td style="background-color:#215a9a; color:#fff; text-align:center">Periodo</td>
                                        <td style="background-color:#215a9a; color:#fff; text-align:center">Enfoques
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align:center;">1945-1960</td>
                                        <td>Crecimiento Económico</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">1962-1969</td>
                                        <td>Crecimiento Económico + Social</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">1970-1980</td>
                                        <td>Crecimiento Económico + Social + Ambiental</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">1980-1990</td>
                                        <td>Crecimiento Económico + Social + Ambiental + Regional/Urbano + Humano</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align:center;">1990-2002</td>
                                        <td>Crecimiento Económico + Social + Ambiental + Regional/Urbano + Humano +
                                            Político
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <hr>
                        <h3>Los avances en la medición del Desarrollo Social</h3>
                        <p>
                            A nivel mundial, existe un universo muy amplio de indicadores para medir el desarrollo
                            social los
                            cuales han evolucionado desde indicadores simples hasta indicadores compuestos que se
                            calculan a
                            partir de una canasta de indicadores básicos y que incluyen cada vez más un número
                            representativo de
                            aspectos y temas que van cobrando relevancia en los diferentes momentos históricos.
                        </p>
                        <br>
                        <p>
                            La mayoría de ellos son medidos por organismos internacionales, como la Organización de la
                            Nacionales, ONU, y sus instituciones adscritas y especializadas, entidades multilaterales,
                            como el
                            Banco Mundial, BM, el Banco Interamericano de Desarrollo, BID, instituciones especializadas,
                            como el
                            Foro Económico Mundial, FMI, e internacionales como el Institute for Management Development,
                            IMD, y
                            la Organización para la Cooperación y el Desarrollo Económico, OCDE. A nivel regional, se
                            destacan
                            la Comisión Económica para América Latina y el Caribe, CEPAL, la Organización de Estados
                            Americanos,
                            OEA, entre otros.
                        </p>
                        <br>
                        <p>
                            No obstante, en el contexto global se ha cuestionado el enfoque sobre el desarrollo basado
                            en
                            indicadores tradicionales. Uno de los indicadores clave desarrollados para medir el
                            desarrollo es el
                            Índice de Desarrollo Humano (IDH) que involucra tres aspectos claves: la longevidad, medida
                            con la
                            esperanza de vida al nacer; el nivel educativo, calculado en función de la tasa de
                            alfabetización de
                            adultos y la tasa bruta de matrícula; y el nivel de vida, tomado con el PIB real per cápita.
                        </p>
                        <br>
                        <p>
                            No obstante, el IDH ha estado sujeto a diversas críticas, enfocadas principalmente en la
                            ponderación
                            impuesta a cada uno de los factores y en no tener en cuenta la proporción de personas con
                            bajos
                            ingresos, entre otras. Por esta razón, las Naciones Unidas en el 2010 propone tres índices
                            adicionales para medir el desarrollo humano: el Índice de Desarrollo Humano ajustado por la
                            Desigualdad, el Índice de Desigualdad de Género y el Índice de Pobreza Multidimensional. El
                            primero,
                            incluye una ponderación de las desigualdades en salud, educación e ingreso; el segundo,
                            introduce
                            las diferencias de género en salud reproductiva, empoderamiento y participación en el
                            mercado
                            laboral; y el tercero identifica las condiciones de los hogares en términos de salud,
                            educación y
                            niveles de vida.
                        </p>
                        <br>
                        <div style="text-align: center; justify-content:center; display:flex">
                            <img src="views/resources/images/sis/desarrollo_social.png" class="img-responsive"
                                style="width: 50%;" alt="Desarrollo Social">
                            <h6>Fuente: Elaboración Equipo SIS</h6>
                        </div>
                        <p>
                            Los cuestionamientos se han dado en diferentes direcciones. Uno de ellos es el hecho de
                            crearse
                            desde un único polo de poder (Occidente), de manera homogénea y sin considerar la diversidad
                            en la
                            elaboración de los índices existentes. Esto corrobora la idea que el mundo está dividido
                            entre
                            países centrales y periféricos, sin deslumbrar la riqueza que se esconde en la mal llamada
                            periferia
                            del mundo y sin responder plenamente a las nuevas dinámicas de las regiones y países en el
                            presente
                            siglo.
                        </p>
                        <br>
                        <p>
                            Esto ha propiciado la aparición de indicadores alternativos aportados por organismos
                            estatales y por
                            organizaciones de la sociedad civil suministrando información útil para medir el desarrollo,
                            aunque
                            no dentro de la corriente predominante. Un ejemplo de ello es el Índice de Progreso Social
                            (IPS),
                            que permite evaluar la eficacia con la que el éxito económico de un país se traduce en
                            progreso
                            social, logrando así un crecimiento inclusivo. Este indicador se ha venido midiendo para las
                            ciudades colombianas que hacen parte de la Red Colombiana de Ciudades Como Vamos.
                        </p>
                        <hr>
                        <h3>La medición del Desarrollo Social en Colombia</h3>
                        <p>
                            Para Ali y Zhuang (2007) el crecimiento inclusivo es aquel “crecimiento que no sólo crea
                            nuevas
                            oportunidades económicas, sino aquel que también asegura igual acceso a las oportunidades
                            creadas
                            para todos los segmentos de la sociedad. El crecimiento es inclusivo cuando permite a todos
                            los
                            miembros de la sociedad participar y contribuir al proceso de crecimiento en igualdad de
                            condiciones, independientemente de sus circunstancias individuales”.
                        </p>
                        <br>
                        <p>
                            En el contexto nacional también se ha dado un progreso similar al que se mencionó a nivel
                            internacional, en donde el DANE como Instituto Nacional de Estadística, calcula los
                            indicadores
                            clásicos a partir de metodologías internacionales para hacer comparables sus mediciones con
                            el
                            contexto global.
                        </p>
                        <br>
                        <p>
                            El DANE y las Naciones Unidas avanzaron durante los años 80 en la creación y aplicación de
                            medidas
                            para la pobreza con indicadores referentes al nivel de ingreso y a la evaluación de
                            necesidades no
                            satisfechas. Entre los primeros, uno de los más conocidos ha sido la Línea de Pobreza (LP),
                            y entre
                            los segundos, el Índice de Necesidades Básicas Insatisfechas, NBI y más recientemente, el
                            Índice de
                            Pobreza Multidimensional, IPM.
                        </p>
                        <br>
                        <p>
                            En los años 90, se crearon los indicadores que tienen un alcance mayor a las medidas
                            convencionales
                            de pobreza y desigualdad. Aparecen entre otros, el Índice de Condiciones de Vida (ICV)
                            creado por la
                            Misión Social del Departamento Nacional de Planeación, DNP, y las Naciones Unidas. También
                            surge el
                            ya mencionado Índice de Desarrollo Humano creado por el PNUD.
                        </p>
                        <br>
                        <p>
                            Con la Ley 1551 de 2012, se generó el marco para la construcción por parte del DANE del
                            Indicador de
                            Importancia Económica Municipal (Valor Agregado), para medir el peso relativo que representa
                            el PIB
                            de cada uno de los municipios dentro del departamento correspondiente.
                        </p>
                        <br>
                        <p>
                            Por su parte, el DNP ha liderado el diseño y elaboración de nuevos indicadores de desarrollo
                            territorial, como es el caso del Sistema de Indicadores Sociodemográficos, SISD, el cual
                            comprende
                            diferentes niveles:
                        </p>
                        <ul>
                            <li>Indicadores básicos a nivel sectorial, como: educación, salud, vivienda, servicios
                                públicos,
                                demografía, empleo e ingresos.</li>
                            <li>Indicadores globales de los sectores que intervienen en la determinación de la calidad
                                de vida,
                                como gastos sociales e indicadores globales de demografía y salud.</li>
                            <li>Indicadores como el NBI, Coeficiente de GINI, Línea de Pobreza, Línea de Indigencia,
                                Índice de
                                Calidad de Vida, Índice de Desarrollo Humano, Índice de Desarrollo Relativo al Género y
                                el
                                Índice de Potenciación al Género.</li>
                            <li>• Indicadores referentes a diversas manifestaciones de la violencia como, Criminalidad,
                                Orden
                                Público, Delitos Contra la Seguridad Social y el Desplazamiento Social.</li>
                        </ul>
                        <br>
                        <p>
                            Con la necesidad de ampliar estas mediciones a los contextos regionales y locales, y hacia
                            nuevas
                            dimensiones del desarrollo, han aparecido mediciones y metodologías nuevas avaladas por
                            entes
                            nacionales, donde se destacan las recientes propuestas con enfoque de “cierre de brechas”
                            del DNP,
                            como las Tipologías de los Entornos de Desarrollo y el Índice de Desempeño Integral
                            Municipal.
                        </p>
                        <br>
                        <p>
                            Sin embargo, la globalización, los medios de comunicación, los avances tecnológicos, entre
                            otros,
                            fueron evidencia de la debilidad del concepto para incluir algunos factores relevantes que
                            podrían
                            presentarse aún con altos niveles de crecimiento económico como: la inequidad de género, la
                            pobreza,
                            la desigualdad de la renta, entre otros. Es por esto que, para los años setenta la
                            eliminación y
                            reducción de la pobreza, la desigualdad y el desempleo, empezaron a ser fundamentales para
                            identificar el avance de un país en términos de desarrollo. Así, el concepto pasa de un
                            enfoque
                            únicamente económico a un proceso multidimensional que involucra los principales cambios en
                            la
                            estructura social, la pobreza y la desigualdad.
                        </p>
                        <br>
                        <p>
                            En Colombia, el Departamento Nacional de Planeación ha establecido el desarrollo integral
                            como el
                            concepto clave para la planificación de las políticas gubernamentales. Este se encuentra
                            definido
                            como: <i>“…un derecho humano fundamental reconocido internacionalmente, es un proceso de
                                transformación multidimensional, sistémico, sostenible e incluyente que se genera de
                                manera
                                planeada para lograr el bienestar de la población en armonía y equilibrio con lo
                                ambiental
                                (natural y construido), lo socio-cultural, lo económico, y lo político-administrativo en
                                un
                                territorio determinado (un municipio, un distrito, un departamento, una región, un
                                país), y
                                teniendo en cuenta el contexto global…”</i>.
                        </p>
                        <br>
                        <p>
                            Para este concepto el territorio es uno de los elementos fundamentales dentro del análisis,
                            puesto
                            que es ahí donde interactúan los seres humanos entre ellos y con el medio ambiente y es la
                            base para
                            algunos procesos de producción. Adicionalmente, para realizar un estudio detallado del
                            desarrollo,
                            es necesario revisar 6 dimensiones: poblacional, económica, ambiente construido, ambiente
                            natural,
                            política administrativa y sociocultural.
                        </p>
                        <br>
                        <p>
                            También para Colombia, en el libro Planificación del desarrollo (2001), se encuentra una
                            nueva
                            versión del concepto: <i>“El desarrollo es un proceso de cambio social que debe asegurar el
                                crecimiento y su distribución equitativa en toda la población. Su finalidad es ampliar
                                la gama
                                de opciones de autorrealización de la población. Debe ser sostenible, es decir, que
                                proteja las
                                opciones para las generaciones futuras. Cabe anotar que una de las condiciones
                                indispensables
                                para el desarrollo es el progreso técnico o desarrollo tecnológico”</i>.
                        </p>
                        <br>
                        <p>
                            Ambas definiciones involucran el concepto de desarrollo humano y sostenible propuesto por
                            organizaciones internacionales. Es así como se puede concluir que, aunque el concepto de
                            desarrollo
                            está lejos de ser único y exacto, es claro que pasó de mirar cuánto produce un país, a cómo
                            se
                            encuentran las personas y su entorno. Adicionalmente, este debe ser ajustado a las
                            necesidades y
                            contexto de cada país o región.
                        </p>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default" style="border-color:white; box-shadow: 0px 2px 6px 0px rgba(32,32,32,0.3); margin-top: 2rem;">
            <div class="panel-heading" role="tab" id="headingTwo"
                style="background-color:white; background-color:white; display:flex; justify-content:space-between; align-items:center; margin: 5px;">
                <h4 class="panel-title" style="font-size:20px;">
                    Análisis descriptivo para los indicadores sociales
                </h4>
                <button
                    style="padding:8px; background-color:#215a9a; border: 1px white solid; border-radius: 5px; hover:pointer; color:white">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color:white;">
                        Ver más
                    </a>
                </button>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" style="padding:10px">
                <div class="panel-body">
                    <div id="page-content-wrapper">
                        <div id="text-index">
                            <h1>Análisis descriptivo de indicadores sociales para Santiago de Cali</h1>
                            <hr>
                            <p>
                                A continuación se presenta el documento sobre el análisis descriptivo de los
                                indicadores del desarrollo social para Santiago de Cali
                            </p>
                            <hr>
                            <table class="table table-striped table-bordered table-hover table-responsive">
                                <thead style="text-align:center">
                                    <tr>
                                        <td style="width:70% ;text-align:center; background-color:#215a9a; color:#fff;">
                                            Nombre</td>
                                        <td style="width:15% ;text-align:center; background-color:#215a9a; color:#fff;">
                                            Año</td>
                                        <td style="width:15% ;text-align:center; background-color:#215a9a; color:#fff;">
                                            Descargar</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Análisis descriptivo de los indicadores del desarrollo social para
                                            Santiago de Cali - 2022</td>
                                        <td style="text-align:center">2022</td>
                                        <td style="text-align:center">
                                            <a href="public/SIS/Analisis-descriptivo-indicadores-sociales-2022.pdf"
                                                target="_blank">
                                                <i class="fa fa-file-pdf-o" style="font-size:48px;color:red;  "></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Análisis descriptivo de los indicadores del desarrollo social para
                                            Santiago de Cali - 2019</td>
                                        <td style="text-align:center">2019</td>
                                        <td style="text-align:center">
                                            <a href="public/SIS/Analisis-descriptivo-indicadores-sociales-2019.pdf"
                                                target="_blank">
                                                <i class="fa fa-file-pdf-o" style="font-size:48px;color:red;  "></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $resp->consultarListadoIndicadoresPorConjunto('SIS', ''); ?>

</div>
