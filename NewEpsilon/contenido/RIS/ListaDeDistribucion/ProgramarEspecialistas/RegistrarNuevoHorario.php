<?php
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//$fecha = date("Y-m-d");
//declaracion de variables
$idEspecialista = base64_decode($_GET['idEspecialista']);
$fecha = base64_decode($_GET['fecha']);
//obtener nombres del especialista
$consEspecialista = mysql_query("SELECT CONCAT(nombres, ' ', apellidos) AS especialista FROM funcionario WHERE idfuncionario = '$idEspecialista'", $cn);
$regsEspecialista = mysql_fetch_array($consEspecialista);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Agendar Especialista :.</title>
<script src="../../../../js/ajax.js"></script>
<script src="../../../../js/jquery-1.9.1.js"></script>
<script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
<script src="../../js/timepicker.js"></script>
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">
<link href="../ListasDeDistribucionCss/formularios.css" rel="stylesheet" type="text/css">
<script>
$(function() {
	$( "#tabs" ).tabs();
});
$(function() {
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',
  changeMonth: true,
    changeYear: true
});
});
$(document).ready(function() {
   $('.timepicker').timepicker({
	   hours: { starts: 0, ends: 23 },
	   minutes: { interval: 30 },
	   rows: 2,
	  // showPeriodLabels: true,
	   minuteText: '&nbsp;&nbsp;Min',
	   hourText : '&nbsp;&nbsp;Hora',
   })
});
</script>
</head>
<body onfocus="CargarAgendaEspecialista();" onload="CargarAgendaEspecialista();">
<div style="width:99%; margin-top:0.5%;">
<div id="tabs">
  <ul>
    <li><a href="#tabs-1"><?php echo ucwords(strtolower($regsEspecialista['especialista'])) ?></a></li>
  </ul>
  <div id="tabs-1">
    <?php include("AsignarNuevoEspecialista.php");?>
  </div>
</div>
</div>
</body>
</html>