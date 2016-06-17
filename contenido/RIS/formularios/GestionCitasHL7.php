<?php
header('Content-Type: text/html; charset=ISO-8859-1');
	$idorden = base64_decode($_GET['idorden']);
	$usuario = base64_decode($_GET['usuario']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<script src="../../../js/jquery.js"></script>
<script src="../../../js/ui/jquery.ui.core.js"></script>
<script src="../../../js/ui/jquery.ui.widget.js"></script>
<script src="../../../js/ui/jquery.ui.datepicker.js"></script>
<script language="JavaScript" type="text/javascript" src="../javascript/ajax.js"></script>
<script src="../../../js/jquery.form.js"></script>
<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../styles/forms.css" rel="stylesheet" type="text/css">
<script>
$(function() {
	$( "#tabs" ).tabs();
});
$(function() {
$( ".datepicker" ).datepicker({
  	changeMonth: true,
    changeYear: true
});
});
</script>
<title>Agendar Cita</title>
<style type="text/css">
	input.text, select.text
	{
		width:250px;
		}
		input.textmedium, select.textmedium
	{
		width:113px;
		}
		input#textmedium, select#textmedium
	{
		width:113px;
		}
</style>
<head>
<body onBeforeUnload="return window.opener.mostrarAgenda();">
<table width="99%">
<tr>
	<td>
        <div id="tabs">
        <ul>
            <li><a href="#tabs-1">Agendar Cita</a></li>
        </ul>
        <div id="tabs-1"><?php include("asignar_agendaHL7.php");?></div>
        </div> 
    </td>
	</tr>
</table>
</div>
</body>
</html>