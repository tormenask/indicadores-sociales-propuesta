<?php include './views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/index.php" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li>Consulta de Indicadores</li>
        <li><a href="/consulta-indicadores/ods">Objetivos de Desarrollo Sostenible para Santiago de Cali</a></li>
        <li class="active"><a href="/consulta-indicadores/ods/presentacion">Presentación</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-4" id="wrapper">
        <?php include './views/modules/consulta-indicadores/ods/sidebar-ods.php'; ?>
    </div>
    <div class="col-xs-12 col-sm-8">
        <div id="page-content-wrapper">
            <div id="text-index">
                <h1>¿Qué son los Objetivos de Desarrollo Sostenible?</h1>
                <hr>
                <p>
                    Los Objetivos de Desarrollo Sostenible (ODS), también conocidos como Objetivos Mundiales, son un llamado universal a la adopción de medidas para poner fin a la pobreza, proteger el planeta y garantizar que todas las personas gocen de paz y prosperidad.
                </p>
                <br>
                <p>
                    Estos 17 Objetivos se basan en los logros de los Objetivos de Desarrollo del Milenio, aunque incluyen nuevas esferas como el cambio climático, la desigualdad económica, la innovación, el consumo sostenible y la paz y la justicia, entre otras prioridades. Los Objetivos están interrelacionados, con frecuencia la clave del éxito de uno involucrará las cuestiones más frecuentemente vinculadas con otro.
                </p>
                <br>
                <p>
                    Los ODS conllevan un espíritu de colaboración y pragmatismo para elegir las mejores opciones con el fin de mejorar la vida, de manera sostenible, para las generaciones futuras. Proporcionan orientaciones y metas claras para su adopción por todos los países en conformidad con sus propias prioridades y los desafíos ambientales del mundo en general.
                </p>
                <br>
                <img src= "/views/resources/images/ods/presentacion-ods.png"
                     alt="Presentación de los Objetivos de Desarrollo Sostenible" style="width: 100%;">
                <hr>
            </div>
        </div>
    </div>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
    $("#consulta-indicadores").addClass("active");
    $("#consulta-ods").addClass("active");
    $("#ods-presentacion").addClass("back-item-menu");
</script>