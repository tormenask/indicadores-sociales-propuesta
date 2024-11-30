<html>
    <?php include 'view/modules/head.php'; ?>
    <body>
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-wrap" style="text-align:center;">
                            <a href="index.php">
                                <img src="view/resources/images/logo2.png" alt="Logo del Sistema de Indicadores Sociales" height="100px">
                            </a>
                            <h1>Inicio de sesión</h1>
                            <form role="form" action="./controller/controller_login.php" method="post" id="login-form" autocomplete="on">
                                <div class="form-group">
                                    <label for="Usuario" class="sr-only">Usuario</label>
                                    <input id="user" type="text" name="user" class="form-control" placeholder="Ingrese su correo electrónico">
                                </div>
                                <div class="form-group">
                                    <label for="key" class="sr-only">Contraseña</label>
                                    <input id="password" type="password" name="password" class="form-control" placeholder="Ingrese su contraseña">
                                </div>
                                <div id="error" class="alert alert-danger" style="background-color: #f2dede;border-color: #ebccd1;" hidden>
                                    <p id="errorText"></p>
                                </div>
                                <input type="submit" name="ingresar" id="ingresar" class="btn btn-custom btn-lg btn-block" value="Ingresar">
                                <a href="index.php?action=recuperar-contrasena"  style="text-align:center;">Recuperar contraseña</a>
                            </form>
                            <hr class="colorgraph">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div id="oval"></div>
        <div id="oval_2"></div>
        <div id="oval_3"></div>
        <div id="oval_4"></div>
    </body>
    <script>
        function getParameterByName(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                    results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
        $(document).ready(function () {
            var error = "";
            if (getParameterByName('error') !== "") {
                error = <?php
    if (isset($_GET['error'])) {
        echo $_GET['error'];
    } else {
        echo "''";
    }
    ?>;
                if (error === 0) {
                    $("#errorText").html("Los campos no pueden estar vacios.");
                    $("#error").show();
                } else if (error === 1) {
                    $("#errorText").html("Su usuario se encuentra bloqueado.");
                    $("#error").show();
                } else if (error === 2) {
                    $("#errorText").html("Su usuario se encuentra inactivo.");
                    $("#error").show();
                } else if (error === 3) {
                    $("#errorText").html("Su estado de usuario no es válido. Contacte al administrador.");
                    $("#error").show();
                }

            }

        });
    </script>
</html>