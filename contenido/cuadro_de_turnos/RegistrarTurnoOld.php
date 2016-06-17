<?php
	//Conexion a la base de datos
	require_once('../../dbconexion/conexion.php');
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
<title>.: Turnos :.</title>
<script src="../../js/jquery-1.9.1.js"></script>
<!--<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>-->
<script src="../../js/ajax.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script type="text/javascript" src="../../js/ui/jquery.ui.datepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css" />
<link href="../../js/demos/demos.css" rel="stylesheet" type="text/css">
<link href="../../js/themes/cupertino/jquery-ui.css" rel="stylesheet" type="text/css">
<script>
$(function() {
$( "#tabs" ).tabs();
});
 $(function() {
                    $('.Reloj').timepicker({ 'timeFormat': 'H:i' });
			 });
			 
$(function() {
$( ".datepicker" ).datepicker({
});
});
</script>
</head>
<body bgcolor="#FFFFFF">
<table width="100%">
	<tr>
    	<td width="50%" align="left">Funcionario: <?php echo $regFuncionario[nombres].'&nbsp;'.$regFuncionario[apellidos]; ?></td>
        <td width="50%" align="right">Fecha: <?php echo $Fecha ?></td>
    </tr>
</table>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Turnos</a></li>
    <li><a href="#tabs-3">Ausentismo</a></li>
</ul>
  <div id="tabs-1">
    <p><?php include("NewRegistro.php")?></p>
  </div>
  <div id="tabs-3">
    <p></p>
  </div>
</div>
</body>
</html>