<?php
header('Set-Cookie: same-site-cookie=foo; SameSite=Lax');
header('Set-Cookie: _biz_uid=21f9648999fb4dfbb620e7fabb6a4aae; SameSite=None; Secure');
?>
<!DOCTYPE html>
<html lang="es">
    <head>
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-120901382-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-120901382-1');
        </script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="El Sistema de Indicadores Sociales de Santiago de Cali, almacena, procesa, difunde y analiza datos producidos por la Administración Municipal.">
        <meta name="author" content="Sistema de Indicadores Sociales">
        <meta name="keywords" content="">
        <link rel="shortcut icon" type="image/png" href="/views/resources/images/favicon.png"/>
        <title></title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link href="/views/resources/css/custom.css" rel="stylesheet" type="text/css"/>
        <link href="/views/resources/css/sidebar.css" rel="stylesheet" type="text/css"/>
        <link href="/views/resources/lib/jquery-ui-themes-1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Syncopate" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Abel" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,600,900' rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" media="all">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.css" rel="stylesheet" />
        <link href="/views/resources/lib/jQCloud/jqcloud/jqcloud.css" rel="stylesheet" type="text/css">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="/views/resources/lib/jquery-number/jquery.number.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/jquery.jqplot.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidGridRenderer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidAxisRenderer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.pyramidRenderer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqPlot/1.0.9/plugins/jqplot.canvasTextRenderer.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script src="https://d3js.org/d3.v3.min.js"></script>        
        <script src="https://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
        <script src="/views/resources/lib/tableExport/libs/FileSaver/FileSaver.min.js"></script>
        <script src="/views/resources/lib/tableExport/libs/js-xlsx/xlsx.core.min.js" ></script>
        <script src="/views/resources/lib/tableExport/libs/jsPDF/jspdf.min.js"></script>
        <script src="/views/resources/lib/tableExport/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
        <script src="/views/resources/lib/tableExport/libs/html2canvas/html2canvas.min.js"></script>
        <script src="/views/resources/lib/tableExport/tableExport.min.js"></script>
        <script src="/views/resources/js/html2canvas.min.js"></script>
        <script src="/views/resources/lib/jQCloud/jqcloud/jqcloud-1.0.4.min.js"></script>
        <!-- <script src="https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"></script> -->
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/canvas2image@1.0.5/canvas2image.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-ui-Slider-Pips/1.11.4/jquery-ui-slider-pips.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jQuery-ui-Slider-Pips/1.11.4/jquery-ui-slider-pips.min.css" />
    </head>
    <body>
        <?php
        $module = new UrlController();
        $module->urlsController();
        ?>
    </body>
</html>