<div class="container">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <link href="/views/resources/css/custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script> 
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
    <div class="row">
        <?php include './views/modules/header.php'; ?>
    </div>
    <div id="tabsConsulta" hidden></div>
    <style>
        li {white-space: normal;}
    </style>
</div>
<?php include './views/modules/footer.php'; ?>
<script>
       $.LoadingOverlaySetup({
        background: "rgba(255, 255, 255, 0.5)",
        image           : "/views/resources/images/cube_load.gif",
        imageAnimation  : "3.5s fadein",
        imageColor      : "#ffcc00"
    });

    $("#tabsIndicador").LoadingOverlay("show");
        setTimeout(function () {
            $("#tabsIndicador").LoadingOverlay("hide");
        }, 7000);

    // jQuery(document).ready(function () {
    //     $.LoadingOverlay("show", {
    //         background: "rgba(255, 255, 255, 0.8)",
    //         image: "/views/resources/images/cube_load.gif"
    //     });
    //     setTimeout(function () {
    //         $.LoadingOverlay("hide");
    //     }, 5000);

    // });
</script>
<?php
if (isset($_GET['param'])) {
    $param = $_GET['param'];
    buscarIndicador($param);
} else {
    error();
}

function buscarIndicador($param) {
    if (!empty($param)) {
        ?>
        <script>
            var param = '<?php echo $param; ?>';
            if (param.length < 3) {
                var resp = "<div class='alert alert-danger alert-dismissable'>\n\
                    Error al realizar la búsqueda.<br>\n\
                    Debe ingresar al menos tres caracteres para realizar la búsqueda. <br>\n\
                    Para volver a la página principal, haga clic <a href='index.php' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n\
                    </div>";
                $('#tabsConsulta').html(resp);
                $('#tabsConsulta').show();
            } else {
                var data = new FormData();
                data.append('param', param);
                var url = "/views/modules/home/buscar-indicadores.php";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        $("#tabsConsulta").html(resp);
                        $("#tabsConsulta").show();
                    }
                });
            }
        </script>
        <?php
    } else {
        error();
    }
}

function error() {
    ?>
    <script>
        var resp = "<div class='alert alert-danger alert-dismissable'>\n\
    Error al realizar la búsqueda.<br>\n\
    Debe ingresar al menos tres caracteres para realizar la búsqueda. <br>\n\
    Para volver a la página principal, haga clic <a href='index.php' id='btn-accept' class='alert-link'><strong>aquí.</strong></a>\n\
    </div>";
        $('#tabsConsulta').html(resp);
        $('#tabsConsulta').show();
    </script>
    <?php
}
