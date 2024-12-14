<?php

// include('Mail.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;

class UsuarioController {

    public function buscarUsuario($correoElectronico) {
        $user = new CrudUsuario();
        $resp = $user->consultarInformacionUsuario($correoElectronico);
        $org = new Organismo();
        $organismoUsuario = $org->consultarNombreOrganismo($resp["idOrganismo"]);
        $est = new Estado();
        $estadoUsuario = $est->consultarNombreEstado($resp["idEstado"]);
        $rol = new Rol();
        $rolUsuario = $rol->consultarNombreRol($resp["idRol"]);

        echo '
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading" style="height: 40px;">
                        <h3 class="panel-title pull-left" style="font-weight:bold;line-height: 1.3 !important;">' . $resp['nombre'] . '</h3>
                        <div class="btn-group pull-right" style="margin-top: -7px;">
                            <a href="index.php?action=admin/cambiarContrasena" 
                                class="btn btn-default" role="button">Cambiar contraseña</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3" style="text-align:center;">';

        if ($resp['genero'] == "Femenino") {
            echo '<img alt = "Imagen de usuario" src = "app/view/resources/images/login-female.png" class = "img-circle img-responsive">';
        } elseif ($resp['genero'] == "Masculino") {
            echo '<img alt = "Imagen de usuario" src = "app/view/resources/images/login-male.png" class = "img-circle img-responsive">';
        }
        echo '              </div>
                            <div class="col-sm-9">
                                <table class="table table-user-information">
                                    <tbody>
                                        <tr>
                                            <td>Nombre:</td>
                                            <td>' . $resp['nombre'] . '</td>
                                        </tr>
                                        <tr>
                                            <td>Identificación:</td>
                                            <td>' . $resp['numeroIdentificacion'] . '</td>
                                        </tr>
                                        <tr>
                                            <td>Correo electrónico:</td>
                                            <td>' . $resp['correoElectronico'] . '</td>
                                        </tr>
                                        <tr>
                                            <td>Organismo:</td>
                                            <td>' . $organismoUsuario . '</td>
                                        </tr>
                                        <tr>
                                            <td>Tipo de vinculación:</td>
                                            <td>' . $resp['tipoVinculacion'] . '</td>
                                        </tr>
                                        <tr>
                                            <td>Rol:</td>
                                            <td>' . $rolUsuario . '</td>
                                        </tr>
                                        <tr>
                                            <td>Estado:</td>
                                            <td>' . $estadoUsuario . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>';
    }

    public function listarUsuarios() {
        $user = new CrudUsuario();
        $resp = $user->listarUsuarios();
        $idRol = $_SESSION['userData']['idRol'];
        $rol = new Rol();
        $permiso = $rol->consultarPermisoRol("usuarios", $idRol);
        $crear = $permiso["crear"];
        $modificar = $permiso["modificar"];
        $eliminar = $permiso["eliminar"];
        if (!$crear && !$modificar && !$eliminar) {
            header("Location: index.php?action=admin/home");
        }
        echo ' 
        <script>
            $(document).ready(function() {
                $("#tablaConsulta").DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                    },
                    "pageLength": 10';
        if ($modificar && $eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 8, 9 ] , 
                        "bSearchable": false, "aTargets": [ 8, 9 ]
                    }]';
        } elseif ($modificar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 8 ] , 
                        "bSearchable": false, "aTargets": [ 8 ]
                    }]';
        } elseif ($eliminar) {
            echo ',
                    "aoColumnDefs": [{
                        "bSortable": false, "aTargets": [ 8 ] , 
                        "bSearchable": false, "aTargets": [ 8 ]
                    }]';
        }
        echo '   
                });
            });
        </script>
        <style>
            td#prewrap {white-space: pre-wrap;}
        </style>
        <div class="row">
            <div class="col-sm-12">
                <h3>Gestión de usuarios</h3><br>
            </div>
        </div>';
        if ($crear) {
            echo '
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-sm-12">
                        <div class="btn-group">
                            <a href="index.php?action=admin/usuarios/registroUsuarios" 
                            class="btn btn-primary" role="button">Registrar usuario</a>
                        </div>
                    </div>
                </div>';
        }
        echo'
        <div class="row">
            <div class="col-sm-12">
                <table id="tablaConsulta" class="table table-striped table-bordered dt-responsive nowrap display" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center;">Nombre</th>
                            <th style="text-align:center;">Género</th>
                            <th style="text-align:center;">Correo electrónico</th>
                            <th style="text-align:center;">Organismo</th>
                            <th style="text-align:center;">Tipo de vinculación</th>
                            <th style="text-align:center;">Identificación</th>
                            <th style="text-align:center;">Rol</th>
                            <th style="text-align:center;">Estado</th>';
        if ($modificar) {
            echo '          <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Editar</th>'
            ;
        }
        if ($eliminar) {
            echo '          <th style = "padding:0px 5px;vertical-align:middle;text-align:center;">Eliminar</th> 
                            <th style="padding:0px 5px;vertical-align:middle;text-align:center;">Cambiar Contraseña: </th>';
        }
        echo '
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($resp as $row => $item) {
            $org = new Organismo();
            $organismoUsuario = $org->consultarNombreOrganismo($item["idOrganismo"]);
            $est = new Estado();
            $estadoUsuario = $est->consultarNombreEstado($item["idEstado"]);
            $rol = new Rol();
            $rolUsuario = $rol->consultarNombreRol($item["idRol"]);
            echo '      <tr>
                            <td id = "prewrap">' . $item["nombre"] . '</td>';
            if ($item['genero'] == "Femenino") {
                echo '<td id = "prewrap"><img alt = "Imagen de usuario" style="width:60px;" src = "/app/view/resources/images/login-female.png" class = "img-circle img-responsive"></td>';
            } elseif ($item['genero'] == "Masculino") {
                echo '<td id = "prewrap"><img alt = "Imagen de usuario" style="width:60px;" src = "/app/view/resources/images/login-male.png" class = "img-circle img-responsive"></td>';
            }
            echo '
                            <td id = "prewrap">' . $item["correoElectronico"] . '</td>
                            <td id = "prewrap">' . $organismoUsuario . '</td>
                            <td id = "prewrap">' . $item["tipoVinculacion"] . '</td>
                            <td id = "prewrap">' . $item["numeroIdentificacion"] . '</td>
                            <td id = "prewrap">' . $rolUsuario . '</td>
                            <td id = "prewrap">' . $estadoUsuario . '</td>';
            if ($modificar) {
                echo '      <td id = "prewrap" style = "text-align:center;"><a href = "index.php?action=admin/usuarios/editarUsuario&user=' . $item["numeroIdentificacion"] . '"><i class = "fa fa-pencil fa-lg"></i></a></td>';
            }
            if ($eliminar) {
                echo '      <td id = "prewrap" style = "text-align:center;"><a href = "index.php?action=admin/usuarios/eliminarUsuario&user=' . $item["numeroIdentificacion"] . '"><i class = "fa fa-trash fa-lg"></i></a></td>
                        <td id = "prewrap" style = "text-align:center;"><a href = "index.php?action=admin/usuarios/cambiarContrasenaRoot"><i class = "fa fa-cogs fa-lg"></i></a></td>';
            }
            echo '
                        </tr>';
        }
        echo'       </tbody>
                </table>
            </div>
        </div>';
    }

    public function crearUsuario($nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $contrasenaUsuario, $idRolUsuario, $estadoUsuario) {
        $usuario = new CrudUsuario();
        $existeCorreo = $this->existeCorreoUsuario($correoUsuario);
        $existeIdentificacion = $this->existeIdentificacionUsuario($identificacionUsuario);
        if ($existeCorreo == FALSE) {
            if ($existeIdentificacion == FALSE) {
                $resp = $usuario->crearUsuario($nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $contrasenaUsuario, $idRolUsuario, $estadoUsuario);
                if ($resp == "Creado") {
                    return "Creado";
                } else {
                    return "Error al crear";
                }
            } else {
                return "Identificación existe";
            }
        } else {
            return "Correo electrónico existe";
        }
    }

    public function eliminarUsuario($identificacionUsuario) {
        $usuario = new CrudUsuario();
        $existeIdentificacion = $this->existeIdentificacionUsuario($identificacionUsuario);
        if ($existeIdentificacion !== FALSE) {
            $resp = $usuario->eliminarUsuario($identificacionUsuario);
            if ($resp == "Eliminado") {
                return "Eliminado";
            } else {
                return "Error al Eliminado";
            }
        } else {
            return "Identificación no existe";
        }
    }

    public function editarUsuario($nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $idRolUsuario, $estadoUsuario) {
        $usuario = new CrudUsuario();
        $existeIdentificacion = $this->existeIdentificacionUsuario($identificacionUsuario);
        $correoPerteneceUsuario = FALSE;
        $informacionUsuario = $usuario->consultarInformacionUsuarioIdentificacion($identificacionUsuario);
        if ($informacionUsuario["correoElectronico"] === $correoUsuario) {
            $correoPerteneceUsuario = TRUE;
        }
        $existeCorreo = $this->existeCorreoUsuario($correoUsuario);

        if ($existeIdentificacion) {
            if ($existeCorreo) {
                if ($correoPerteneceUsuario) {
                    $resp = $usuario->editarUsuario($nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $idRolUsuario, $estadoUsuario);
                    if ($resp == "Editado") {
                        return "Editado";
                    } else {
                        return "Error al editar";
                    }
                } else {
                    return "Correo en uso";
                }
            } else {
                $resp = $usuario->editarUsuario($nombreUsuario, $generoUsuario, $correoUsuario, $organismoUsuario, $vinculacionUsuario, $identificacionUsuario, $idRolUsuario, $estadoUsuario);
                if ($resp == "Editado") {
                    return "Editado";
                } else {
                    return "Error al editar";
                }
            }
        } else {
            return "Identificación no existe";
        }
    }

    public function existeCorreoUsuario($correoElectronico) {
        $usuario = new CrudUsuario();
        $existe = $usuario->correoUsuarioExiste($correoElectronico);
        if ($existe["correoElectronico"] !== NULL && $existe["correoElectronico"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function cambiarContrasenaRoot($correoElectronico, $contrasenaNuev) {
        $usuarioCrud = new CrudUsuario();
        session_start();
        $respCon = $usuarioCrud->cambiarContrasenaRoot($contrasenaNuev, $correoElectronico);
        if ($respCon == "Editado") {
            return"Editado";
        } else {
            return "Error al editar";
        }
    }

    public function traeCorreo($correoElectronico) {
        $usuario = new CrudUsuario();
        $existe = $usuario->traeCorreo($correoElectronico);
        return $existe;
    }

    public function enviaContrasenaRoot($contrasenaNueva) {
        $usuario = new CrudUsuario();
        $existe = $usuario->traeContrasena($contrasenaNueva);
        return $existe;
    }

    public function cambiarContrasena($contrasenaAnterior, $contrasenaNueva) {

        $usuarioCrud = new CrudUsuario();
        session_start();
        $correoElectronico = $_SESSION['userData']['correoElectronico'];
        $traeContrasena = $this->traeContrasena($correoElectronico);
        if (password_verify($contrasenaAnterior, $traeContrasena['contrasena'])) {
            $usuarioCrud->cambiarContrasena($contrasenaNueva, $correoElectronico);
            return "Editado";
        } else {
            return "Error al editar";
        }
    }

    public function traeContrasena($correoElectronico) {
        $usuario = new CrudUsuario();
        $existe = $usuario->traeContrasena($correoElectronico);
        return $existe;
    }

    public function enviaContrasena($contrasenaNueva) {
        $usuario = new CrudUsuario();
        $existe = $usuario->traeContrasena($contrasenaNueva);
        return $existe;
    }

    public function existeIdentificacionUsuario($numeroIdentificacion) {
        $usuario = new CrudUsuario();
        $existe = $usuario->identificacionUsuarioExiste($numeroIdentificacion);
        if ($existe["numeroIdentificacion"] !== NULL && $existe["numeroIdentificacion"] !== "") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function editarUsuarioForm($numeroIdentificacion) {
        $usuario = new CrudUsuario();
        $respEditarUsuario = $usuario->consultarInformacionUsuarioIdentificacion($numeroIdentificacion);
        include 'view/modules/admin/usuarios/formEditarUsuario.php';
    }

    public function eliminarUsuarioForm($numeroIdentificacion) {
        $usuario = new CrudUsuario();
        $respEliminarUsuario = $usuario->consultarInformacionUsuarioIdentificacion($numeroIdentificacion);
        include 'view/modules/admin/usuarios/formEliminarUsuario.php';
    }

    public function recuperarContrasena($recuperarContrasena) {
        $usuario = new CrudUsuario();
        $usuarioCrud = new CrudUsuario();
        $resp1 = $usuario->correoUsuarioExiste($recuperarContrasena);
        if ($resp1 !== FALSE) {
            $aleatorio = uniqid();
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
            $usuarioCrud->cambiarContrasenaRoot($aleatorio, $recuperarContrasena);
//            ENVIO DE CONTRASEÑA CON MAIL Y CONFIGURACION XAMP  
//            $asunto = "Cambio de contraseña para el Panel Administrador";
//            $cuerpo = 'Estimado(a) usuario:
//
//                       Usted ha pedido cambio de contraseña para ingresar al Panel Administrador del Sistema. 
//                       Porfavor ingrese al Panel Administrador del Sistema con la contraseña enviada.
//
//                       Su Nueva contraseña es:' . $aleatorio . ' 
//                       Desde su perfil, realice el cambio nuevamente de su contraseña.
//
//                       Sistema de Indicadores Sociales.';
//            $headers = "From: Panel Administrador <correo_sis@gmail.com>\r\n";
//            mail($recuperarContrasena, $asunto, $cuerpo, $headers);
                    
                    $to = "santanag5857@gmail.com";
                    $smtpHost = 'smtp.gmail.com';
                    $smtpUsuario = 'planestadistico@cali.gov.co';
                    $smtpClave = 'Ples2023*';
                    $mail = new PHPMailer();
                    $mail->IsSMTP();
                    $mail->SMTPAuth = true;
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->IsHTML(true);
                    $mail->CharSet = 'utf-8';
                    $mail->Host = $smtpHost;
                    $mail->Username = $smtpUsuario;
                    $mail->Password = $smtpClave;
                    $mail->From = $smtpUsuario;
                    $mail->FromName = 'Sistema de Indicadores Sociales';
                    $mail->addAddress($to);
                        $mail->Subject = 'Restauración de clave - Panel Administrador SIS.';
                        $body =  'Estimado(a) <b>'.$resp1["nombre"].'</b>:<br>
                                   <br>
                                   Usted ha pedido cambio de contraseña para ingresar al Panel Administrador del Sistema. <br>
                                   Porfavor ingrese al Panel Administrador del Sistema con la nueva contraseña.  <br>
                                   <br>
                                   Su Nueva contraseña es:<b>' . $aleatorio . '</b><br>
                                   Desde su perfil, realice el cambio nuevamente de su contraseña. <br>
                                   <br>
                                   Sistema de Indicadores Sociales.';
                        $mail->Body = $body;
                        $mail->SMTPOptions = array(
                            'ssl' => array(
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                                'allow_self_signed' => true
                            )
                        );
                        $sent = $mail->Send();
            if ($sent == TRUE) {    
                return "Mensaje enviado";
            }else {
                return "Error";
            }  
        } else {
            return "Usuario no existe";
        }
    }

}
