<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
$usuario = $_GET['usuario'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Asignacion de Estudios :.</title>
<script src="../../../../js/ajax.js"></script>
<script src="../../../../js/jquery-1.9.1.js"></script>
<script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">
<script>
$(function() {
	$( "#tabs" ).tabs();
});
$(function() {
$( "#datepicker" ).datepicker({
  changeMonth: true,
    changeYear: true
});
});
$(function() {
$( "#datepicker2" ).datepicker({
  changeMonth: true,
    changeYear: true
});
});
$(function() {
$( "#datepicker3" ).datepicker({
  changeMonth: true,
    changeYear: true
});
});
$(function() {
$( ".datepicker4" ).datepicker({
  changeMonth: true,
    changeYear: true
});
});
//calendario
$(function() {
$( ".calendario" ).datepicker({
  changeMonth: true,
    changeYear: true
});
});
</script>
</head>
<body onfocus="MostrarAsignados();" onblur="CargarEstudiosPendientes(); MostrarAsignados();" onload="CargarFunciones()">
<script language="javascript">
function CargarFunciones()
{
	return CargarEstudiosPendientes();
}
</script>
<div style="width:99%; margin-top:0.5%;">
<div id="tabs">
  <ul>
    <li><a href="#tabs-1" onclick="CargarEstudiosPendientes()">Asignar pendientes por lectura</a></li>
    <li><a href="#tabs-2">Asignados</a></li>
    <li><a href="#tabs-3">Ver asignados por especialista</a></li>
  </ul>
  <div id="tabs-1">
    <?php include("ListaLecturasPendientes.php");?>
  </div>
  <div id="tabs-2">
    <?php include("ListaLecturasAsignadas.php");?>
  </div>
  <div id="tabs-3">
    <?php include("VerListadoGeneralEspecialista.php");?>
  </div>
</div>
</div>
</body>
</html>