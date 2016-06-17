<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include('../../../../dbconexion/conexion.php');
$cn = Conectarse();
include("../../select/selects.php");
$usuario = $_GET['usuario'];
$sede = $_GET['sede'];
$hoy = date('Y-m-d');
$nuevafecha = strtotime ( '-1 month' , strtotime ( $hoy ) ) ;
$nuevafecha = date('Y-m-d' , $nuevafecha );
$month = date('m');
$year = date('Y');
$PrimerDia = date('Y-m-d', mktime(0,0,0, $month, 1, $year));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10" />
<title>.: Toma de Estudios :.</title>
<script src="../../../../js/ajax.js"></script>
<script src="../../../../js/jquery-1.9.1.js"></script>
<script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
<link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css" />
<link href="../../styles/forms.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../ajax.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet"/>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
$(function() {
$( ".calendar" ).datepicker({
  changeMonth: true,
  changeYear: true,
  dateFormat: "yy-mm-dd"
});
});
</script>
</head>
<body onFocus="misEstudios(), CargarAgenda(), ListadoGeneral()">
<div style="width:99%; margin-top:0.5%;">
  <div id="tabs">
    <ul>
      <li><a href="#tabs-1" onclick="CargarAgenda()">Pendientes por lectura</a></li>
      <li><a href="#tabs-2" onclick="misEstudios()">Pendientes por aprobar</a></li>
      <li><a href="#tabs-3" onclick="ListadoGeneral()">Todos los pendientes</a></li>
      <li><a href="#tabs-4" onclick="VerMisLecturas()">Mi producción</a></li>
    </ul>
    <div id="tabs-1"><?php include("ListaLecturasPendientes.php");?></div>
    <div id="tabs-2"><?php include("MisLecturas.php");?></div>
    <div id="tabs-3"><?php include("PendientesPorLecturaGeneral.php");?></div>
    <div id="tabs-4"><?php include("MisEstudiosLeidos.php");?></div>
  </div>
</div>
</body>
<?php mysql_close($cn); ?>