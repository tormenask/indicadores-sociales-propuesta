<?php
include_once 'models/noticias.php';
include_once 'controllers/noticias.php';
?>
<?php include 'views/modules/header.php'; ?>
<div class="row">
    <ul class="breadcrumb">
        <li> <a href="/" style="color: #000;"><i class="glyphicon glyphicon-home"></i></a></li>
        <li class="active"><a href="/noticias">Noticias</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-sm-3" id="wrapper">
        <?php include 'views/menus/noticias.php'; ?>
    </div>
    <div class="col-sm-9">
        <div id="page-content-wrapper">
            <div id="text-index">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Noticias del Sistema de Indicadores Sociales</h1>
                        <hr>
                    </div>
                </div>
                <div class="row" id="2023">
                    <div class="col-sm-12">
                        <h3 style="font-weight: bold;">2023</h3>
                    </div>
                </div>
                <?php
                $noticia = new NoticiaController();
                $noticia->listarNoticiasPorAnho('2023');
                ?>
                <div class="row" id="2022">
                    <div class="col-sm-12">
                        <h3 style="font-weight: bold;">2022</h3>
                    </div>
                </div>
                <?php
                $noticia = new NoticiaController();
                $noticia->listarNoticiasPorAnho('2022');
                ?>
                <div class="row" id="2019">
                    <div class="col-sm-12">
                        <h3 style="font-weight: bold;">2019</h3>
                    </div>
                </div>
                <?php
                $noticia = new NoticiaController();
                $noticia->listarNoticiasPorAnho('2019');
                ?>
                <div class="row" id="2018">
                    <div class="col-sm-12">
                        <h3 style="font-weight: bold;">2018</h3>
                    </div>
                </div>
                <?php
                $noticia->listarNoticiasPorAnho('2018');
                ?>
                <div class="row" id="2017">
                    <div class="col-sm-12">
                        <h3 style="font-weight: bold;">2017</h3>
                    </div>
                </div>
                <?php
                $noticia->listarNoticiasPorAnho('2017');
                ?>
                <div class="row" id="2016">
                    <div class="col-sm-12">
                        <h3 style="font-weight: bold;">2016</h3>
                    </div>
                </div>
                <?php
                $noticia->listarNoticiasPorAnho('2016');
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var URLhash = window.location.hash;
        if (URLhash !== "") {
            var destino = $(URLhash);
            scroll(destino);
        }
        $('a[href^="#"]').click(function () {
            var destino = $(this.hash);
            scroll(destino);
        });
        function scroll(destino) {
            $('html, body').animate({scrollTop: destino.offset().top - 200}, 500);
        }
    });
</script>
<?php include 'views/modules/footer.php'; ?>