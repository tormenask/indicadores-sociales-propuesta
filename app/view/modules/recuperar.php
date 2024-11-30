<html>
    <?php include 'head.php'; ?>
    <body>
        <section id="recuperar">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-wrap" style="text-align:center;">
                            <a href="index.php">
                                <img src="view/resources/images/logo.png" alt="Logo del Sistema de Indicadores Sociales" height="100px">
                            </a>
                            <h1>Recuperar contraseña</h1>
                            <!--action="../../controller/controller_login.php" method="post"-->
                            <form  id="login-recuperar" autocomplete="on">
                                <div class="form-group">
                                    <label for="Usuario" class="sr-only">Usuario</label>
                                    <input id="user" type="text" name="user" class="form-control" placeholder="Ingrese su correo electrónico">
                                </div>
                                <div id="error" class="alert alert-danger" style="background-color: #f2dede;border-color: #ebccd1;" hidden>
                                    <p id="errorText"></p>
                                </div>
                                <input type="button" name="enviar" id="enviar" class="btn btn-custom btn-lg btn-block" value="Enviar correo" href="login/recuperar">
                            </form>

                            <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="modal-recuperar">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header active">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Contraseña enviada</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p id="modal-content-recuperar-contrasena"></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" id="modal-btn-enviar-contrasena-ok">Aceptar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
        $("#enviar").on("click", function () {
            var recuperarCont = $("#user").val();
            if (recuperarCont === "") {
                $("#errorText").html("Los campos no pueden estar vacios.");
                $("#error").show();
            } else {
                recuperarContrasena();
                $("#modal-recuperar").modal('hide');
            }
        });
         $("#modal-btn-enviar-contrasena-ok").on("click", function () {
                $("#modal-recuperar").modal('hide');
                window.location.replace("index.php");
                });
    </script>
    <script>
        function recuperarContrasena() {
            var recuperarCont = $("#user").val();
            var url = "view/modules/admin/usuarios/funcionesUsuarios.php";
            var data = new FormData();
            data.append("recuperarContrasena", recuperarCont);
            $.ajax({
                url: url,
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function (resp) {
                    $("#login-recuperar")[0].reset();
                    if (resp === "Mensaje enviado") {
                        document.getElementById("modal-content-recuperar-contrasena").innerHTML = "La contraseña ha sido enviada al correo electronico.";
                        $("#modal-recuperar").modal('show');
                    } else if (resp === "Usuario no existe") {
                        $("#errorText").html("El correo ingresado no esta registrado.");
                        $("#error").show();
                    }else{
                        $("#errorText").html("Error al enviar el correo para la restauración de la clave.");
                        $("#error").show();
                    }
                    console.log(resp);
                }
            });
        }
    </script>
    <script>
        $("#usuarios").addClass("active");
    </script>
    <script>
        $(function () {
            $("input,select,textarea").not("[type=submit]").jqBootstrapValidation();
        });
    </script>
</html>