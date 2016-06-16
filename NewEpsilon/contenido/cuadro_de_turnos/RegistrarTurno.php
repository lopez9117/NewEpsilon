<?php
//Conexion a la base de datos
include('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$Funcionario = base64_decode($_GET['Funcionario']);
$Fecha = base64_decode($_GET['Fecha']);
$grupoEmpleado = base64_decode($_GET['grupoEmpleado']);
$tipo = base64_decode($_GET['tipo']);
$sede = base64_decode($_GET['sede']);
//consulta
$sqlFuncionario = mysql_query("SELECT nombres, apellidos FROM funcionario WHERE idfuncionario = '$Funcionario'", $cn);
$regFuncionario = mysql_fetch_array($sqlFuncionario);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Registrar Turnos :.</title>
<script src="../../js/jquery-1.9.1.js"></script>
<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script src="../../js/ui/jquery.ui.tabs.js"></script>
<script src="js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script src="../../js/ajax.js" type="text/javascript"></script>
<script src="js/FuncionesCuadroTurnos.js" type="text/javascript"></script>
<link href="../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
<link href="../../js/demos/demos.css" rel="stylesheet" type="text/css">
<link href="css/VisualStyles.css" rel="stylesheet" type="text/css">
<script>
//tabs jquery
$(function() {
$( "#tabs" ).tabs();
});
//timepicker jquery
$(function() {
$('.Reloj').timepicker({ 'timeFormat': 'H:i' });
});	
//datepicker jquery	 
$(function() {
	$("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
</head>
<body bgcolor="#FFFFFF">
<table>
	<tr>
    	<td><?php echo $regFuncionario['nombres'].'&nbsp;'.$regFuncionario['apellidos']?></td>
    </tr>
</table>
<div id="tabs">
<ul>
    <li><a href="#tabs-1">Turnos</a></li>
</ul>
<div id="tabs-1">
    <p><?php include("NewRegistro.php")?></p>
</div>
</div>
<div id="respuesta"></div>
</body>
</html>