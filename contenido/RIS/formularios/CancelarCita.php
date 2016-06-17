<?php
//conexion a la base de datos
include("../../../dbconexion/conexion.php");
$cn = Conectarse();
include("../select/selects.php");
//archivo con listas seleccionables
$Idinforme = base64_decode($_GET['idInforme']);
$usuario = base64_decode($_GET['usuario']);
$Consulta = mysql_query("SELECT id_estadoinforme FROM r_informe_header WHERE id_informe = '$Idinforme'", $cn);
$registro = mysql_fetch_array($Consulta);
$estado = $registro['id_estadoinforme'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script src="../../../js/jquery.js"></script>
<script language="javascript" src="../../../js/jquery.maskedinput.js" type="text/javascript"></script>
<script language="javascript" src="../../../js/jquery.form.js"></script>
<script language="javascript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
<script src="JavasScript/FuncionesAgendamiento.js"></script>
<script>
    $(function () {
        $("#tabs").tabs({
            beforeLoad: function (event, ui) {
                ui.jqXHR.error(function () {
                    ui.panel.html( "Lo sentimos, no es posible cargar el contenido en este momento. " + "Por favor contacte el personal de sistemas.");
                });
            }
        });
    });
    //Calendario con restriccion de meses y dias anteriores Jquery
    $(function () { $("#datepicker").datepicker({minDate: "-4M", maxDate: "+4M", dateFormat: 'yy-mm-dd'});  });
    $(function () { $("#datepicker2").datepicker({minDate: "-0D", dateFormat: 'yy-mm-dd'}); });
    // classs for datepicker
    $(function () {
        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });
    });
</script>
<style type="text/css">
    .asterisk { color: #F00; }
    .textlarge { width: 90%; font-family: Arial, Helvetica, sans-serif; font-size: 12px; height: 12px; }
    .selectlarge { width: 95%; font-family: Arial, Helvetica, sans-serif; font-size: 12px; height: 20px; }
    select { width: 95%; font-family: Arial, Helvetica, sans-serif; font-size: 12px; height: 20px; }
    textarea { width: 95%; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
    body { font-family: Arial, Helvetica, sans-serif; }
</style>
<title>.: Cancelar / Modificar Citas :.</title>
<head>
<body>
<table width="99%">
    <tr>
        <td>
            <div id="tabs">
                <?php if($estado > 1) { ?>
                    <ul>
                        <li><a href="#tabs-1">Modificar Cita</a></li>
                    </ul>
                    <div id="tabs-1"><?php include("FormModificarCita.php") ?></div>
                    <?php
                }
                else { ?>
                    <ul>
                        <li><a href="#tabs-1">Modificar Cita</a></li>
                        <li><a href="#tabs-2">Cancelar Cita</a></li>
                    </ul>
                    <div id="tabs-1"><?php include("FormModificarCita.php") ?></div>
                    <div id="tabs-2"><?php include("FormCancelarCita.php") ?></div>
                <?php
                }
                    ?>
            </div>
        </td>
    </tr>
</table>
</body>
</html>