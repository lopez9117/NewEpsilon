<?php

session_start();
$error = base64_decode($_GET['error']);
$username = base64_decode($_GET['username']);
session_destroy();
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Login</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="css/styles.css">
        <script language="javascript">
            function ValidateForm() {
                var username, password, response, formulario;
                formulario = document.login;
                username = formulario.username.value;
                password = formulario.password.value;
                response = "<font color='#FF0000' size='-1'>Los datos son obligatorios</font>";
                if (username == "" || password == "") {
                    document.getElementById('error').innerHTML = response;
                }
                else {
                    formulario.submit();
                }
            }
        </script>
    </head>
    <body>
    <div id="container">
        <form name="login" id="login" method="post" action="validate/validateLogin.php">
            <label for="name">Usuario:</label>
            <input type="name" name="username" id="username" value="<?php echo $username; ?>">
            <label for="username">Contraseña:</label>
            <input type="password" id="password" name="password">

            <div id="lower">
                <input type="button" value="Entrar" onclick="ValidateForm()" class="button">
            </div>
            <br>

            <p align="center" id="error"><?php if ($error == 1) {
                    echo '<font color="#FF0000" size="-1">Error de inicio de sesión, por favor intente de nuevo</font>';
                } ?></p>
        </form>
    </div>
    </body>
    </html>
<?php
//phpinfo();
//echo date("H:i");
?>