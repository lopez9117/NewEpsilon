<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
//archivo de conexion a la db
include("../../dbconexion/conexion.php");
$cn = conectarse();
include("select/selects.php");
//declaracion de variables con GET
$CurrentUser = $_GET['User'];
$Mod = $_GET['Mod'];
//comprobacion de los permisos del usuario
$sql = mysql_query("SELECT * FROM modulo_usuario WHERE idmodulo = '$Mod' AND idusuario='$CurrentUser'", $cn);
$res = mysql_num_rows($sql);

if ($res == 0 || $res == "") {
    echo 'Usted no tiene permisos para acceder a esta modulo';
} else {
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10"/>
        <script src="../../js/base64.js" type="text/javascript"></script>
        <script language="javascript">
            function validar() {
                var sede, notificacion;
                sede = document.FormSede.sede.value;
                encripta = Base64.encode(sede)
                notificacion = "<font color='#FF0000'>Por favor seleccione un elemento de la lista</font>";
                //validar campos del formulario
                if (sede == "") {
                    //mostrar mensaje en pantalla
                    document.getElementById('alerta').innerHTML = notificacion;
                }
                else {
                    enlace = "<a href='index.php?user=<?php echo base64_encode($CurrentUser) ?>&sede=" + encripta + "' target='_blank'>Continuar</a>";
                    close();
                    //redireccionar al index de RIS
                    document.getElementById('alerta').innerHTML = enlace;
                }
            }
        </script>
        <style type="text/css">
            body {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }

            .input {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12px;
            }

        </style>
    </head>
    <body>
    <form id="FormSede" name="FormSede" method="post" action="">
        <table width="90%" border="0" align="center">
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td><strong>Por favor seleccione la unidad de servicios donde se encuentra actualmente:</strong></td>
            </tr>
            <tr>
                <td><label for="sede"></label>
                    <select name="sede" id="sede" onchange="validar()" class="input">
                        <option value="">.: Seleccione un elemento de la lista :.</option>
                        <?php
                        while ($rowSede = mysql_fetch_array($listaSede)) {
                            echo '<option value="' . $rowSede['idsede'] . '">' . $rowSede['descsede'] . '</option>';
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <div id="alerta"></div>
                </td>
            </tr>
        </table>
    </form>
    </body>
    </html>
    <?php
}
?>