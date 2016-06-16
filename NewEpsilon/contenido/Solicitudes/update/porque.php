<?php
	//incluir archivo que contiene consultas para llenar selects
	include("../../select/SelectsListado.php");
	//variable session
session_start();
$CurrentUser = $_SESSION['currentuser'];
	$idsolicitud = $_GET['id'];
	$sqlSolicitud = mysql_query("SELECT * FROM solicitud WHERE idsolicitud='$idsolicitud'", $cn);
	$regSolicitud = mysql_fetch_array($sqlSolicitud);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script language='javascript'>
ClosingVar =true
window.onbeforeunload = ExitCheck;
function ExitCheck()
{  
///control de cerrar la ventana///
 if(ClosingVar == true) 
  { ExitCheck = false
    return "Si decide continuar,abandonará la página pudiendo perder los cambios si no ha GUARDADO ¡¡¡";
  }
}
</script> 
<script type="text/javascript" src="../../../js/jquery.js"></script>
<script type="text/javascript" src="../../../js/ajax.js"></script>
<script type="text/javascript">
$(document).ready(function(){
   $("#nav a").each(function(){
      var href = $(this).attr("href");
      $(this).attr({ href: "#"});
      $(this).click(function(){
         $(".show").load(href);
      });
   });
});
</script>
<link type="text/css" href="../../../css/demo_table.css" rel="stylesheet" />
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
html,body { 
  overflow:hidden; 
}
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<script type="text/javascript" src="../../../js/jquery-1.7.1.js"></script>
<script language='javascript'>
function Validarporque()
{
	var porque;
	porque = document.Newregistro.porque.value;
	if(porque=="")
	{
		mensaje = '<font size="2" color="#FF0000">Es necesario que escribas la razón.</font>';
		//etiqueta donde voy a mostrar la respuesta
		document.getElementById('notificacion').innerHTML = mensaje;
	}
	else
	{
		document.Newregistro.submit();
	}
}
</script>
</head>
<body onBeforeUnload="return window.opener.cargardiv()">
<tr><td width="260" height="270" align="center" valign="middle">
	<table width="98%" border="0" align="center">
	<tr>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE">
    <form action="nosatisfecho.php" method="post" name="Newregistro" id="Newregistro">
    <table top=300,left=300,width=300,height=300">
      <tr>
        <h1>&iquest;Por qu&eacute;?</h1>
        Es necesario para el departamento de sistemas, saber el porque no se encuentra satisfecho con la solicitud, por favor describa la raz&oacute;n por la cual no te encuentras satisfecho.<br>
        Muchas Gracias.
        </tr>
      <tr>
      <td height="126"><textarea name="porque" id="porque" cols="33" rows="10" value="<?php echo $regSolicitud['porque']?>"></textarea></td>  
       </tr>
    <td><input type="button" name="guardar" id="guardar" value="Enviar" onclick="Validarporque()" />
      <input type="reset" name="restablecer" id="restablecer" value="Restablecer" />
      <label>
        <input type="hidden" name="idsolicitud" id="idsolicitud" value="<?php echo $idsolicitud  
	  ?>" />
      </label>
<div id="notificacion" class="notificacion"></div>
</td>
  </tr>
  </form>
</body>
</html>