<html lang="ea">
    <head>
        <title>Error</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php include 'view/modules/head.php'; ?>
        <link rel="stylesheet" href="view/resources/css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="container-fluid" id="top-container-fluid-nav">
                <div class="container">				
                    <div class="jumbotron">
                        <h1 class="display-1">4<i class="fa  fa-spin fa-cog fa-3x"></i>4</h1>
                        <h1 class="display-3">ERROR</h1>
                        <div class="w3-container w3-pale-red">
                            <h1><?php echo $_GET['mensaje']; ?></h1>
                            <a class="enlace" href="index.php">Volver a ingresar</a>
                        </div>
                    </div>
                </div>
            </div>			
        </div>
    </body>
</html>