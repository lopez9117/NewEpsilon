<?php 
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION['currentuser'] ;
	$mod = 9;
	include("../ValidarModulo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
<script type="text/javascript" src="../../js/ajax.js"></script>
<script>
$(document).ready(function(){
    verlistado()
    //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
})
function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
	  var randomnumber=Math.random()*11;
	$.post("listado_funcionarios.php", {
		randomnumber:randomnumber
	}, function(data){
	  $("#contenido").html(data);
	});
}
</script>
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<div id="nav">
<div class="chou">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a href="#">Gesti&oacute;n de Usuarios</a></span></div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7">&nbsp;</td>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE" id="contenido"></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</div></div>
</body>
</html>