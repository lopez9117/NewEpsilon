<?php
	$usuario = $_GET['usuario'];
	$sede = $_GET['sede'];
	$fecha = date("Y-m-d");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Asignacion de Especialista :.</title>
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
$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',
  changeMonth: true,
    changeYear: true
});
});

$(function() {
$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd',
  changeMonth: true,
    changeYear: true
});
});
</script>
</head>
<body onfocus="CargarAgenda(); MostrarDistribucion()">
<div style="width:99%; margin-top:0.5%;">
<div id="tabs">
<ul>
<li><a href="#tabs-1">Asignar Especialistas</a></li>
<li><a href="#tabs-2">Contadores</a></li>
</ul>
<div id="tabs-1">
<?php include("ListaEspecialistasPorSede.php");?>
</div>
<div id="tabs-2">
<?php include("DistribucionDeEstudios.php");?>
</div>
</div>
 </div>
</body>
</html>