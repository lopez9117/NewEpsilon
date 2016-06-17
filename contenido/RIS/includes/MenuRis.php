<?php 
include("../Session/session_info.php");
include("../../../dbconexion/conexion.php");
$cn = Conectarse();
$sql = mysql_query("SELECT idrol FROM usuario WHERE idusuario = '$user'", $cn);
$reg = mysql_fetch_array($sql);
$rol = $reg['idrol'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../../js/themes/cupertino/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<script src="../../../js/jquery-1.9.1.js"></script>
<script src="../../../js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript">
jQuery.noConflict();
jQuery(function() {
jQuery( "#accordion" ).accordion();
});
</script>
<style>
body{
font: 62.5% "Trebuchet MS", sans-serif;
margin-left: 0px;
margin-top: 0px;
margin-right: 0px;
}
img
{
	border:none;
	width:16px;
	height:16px;
	}
	
.menuHeader
{position:inherit;
}
</style>
</head>
<body>
<table width="95%" align="center">
<tr>
<td>
<div id="accordion">
<?php
	if($rol==1)
	{
		include("menu/administrador.php");
	}
	elseif($rol==2)
	{
		include("menu/UsuarioEsp.php");
	}
	elseif($rol==3)
	{
		include("menu/Visitante.php");
	}
	elseif($rol==4)
	{
		include("menu/Transcriptor.php");
	}
	elseif($rol==5)
	{
		include("menu/Especialista.php");
	}
	elseif($rol==6)
	{
		include("menu/ImagDiagnosticas.php");
	}
	elseif($rol==7)
	{
		include("menu/Auditoria.php");
	}
	elseif($rol==8)
	{
		include("menu/Enfermeria.php");
	}
?>
</div>
</td>
</tr>
</table>
</body>
</html>