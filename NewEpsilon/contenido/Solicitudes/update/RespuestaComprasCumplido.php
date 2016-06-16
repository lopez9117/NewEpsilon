<?php
	//incluir archivo que contiene consultas para llenar selects
	include("../../select/SelectsListado.php");
	//variable session
session_start();
$CurrentUser = $_SESSION[currentuser];
	$idsolicitud = $_GET[id];
	$sqlSolicitud = mysql_query("SELECT * FROM solicitud WHERE idsolicitud='$idsolicitud'", $cn);
	$regSolicitud = mysql_fetch_array($sqlSolicitud);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script> 
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
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #Newregistro').submit(function() {
 		// Enviamos el formulario usando AJAX
        $.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serialize(),
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
		$('#notificacion').html(data);
            }
        })        
        return false;
    }); 
}) 
</script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
</head>
<body onBeforeUnload="return window.opener.cargardiv();">
<table width="100%" height="100%">
<tr><td>
	
	<div class="marco">
	<table width="98%" border="0" align="center">
	<tr>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE">
    <form action="update_solicitudCumplido_Compras.php" method="post" name="Newregistro" id="Newregistro">
    <table>
      <tr>
        <th><h1 align="center">&iquest;Como va la Solicitud?</h1>
        <tr>
      <tr>
      <td ><span id="sprytextarea1">
        <textarea name="porque" id="porque" cols="100" rows="10" value="<?php echo $regsolicitud[porque]?>"><?php echo $regSolicitud[porque]?></textarea>
        <span class="textareaRequiredMsg">*</span></span>
      <tr>
    <td><input type="submit" name="guardar" id="guardar" value="Enviar" />
      <input type="reset" name="restablecer" id="restablecer" value="Restablecer" />
      <label>
      
        <input type="hidden" name="Id" id="Id" value="<?php echo $idsolicitud  
	  ?>" />
      </label>
<div id="notificacion" class="notificacion"></div>
</td>
      
  </tr>
    </table> 
    
      </form></td>
	</tr>
	</table>
	<br><br>
	</div>
</td></tr>
</table>
</div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
</script>
</body>
</html>