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
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<body onBeforeUnload="return window.opener.cargardiv();">
<body topmargin="0">
</head>
<body>
<div id="nav">
<div class="show">
<body topmargin="0">
<table width="100%" border="0" align="center">
<tr><td align="center" valign="middle">
	
	<div class="marco">
	<table width="98%" border="0" align="center">
	<tr>
	</tr>
	<tr>
	<td valign="top" align="left" bgcolor="#DEDEDE">
    <form action="../update/update_solicitud.php" method="post" name="Newregistro" id="Newregistro">
    <table width="100%" aling="center">
      <tr>
        <th height="17" align="center"><strong>Responder Solicitud </strong>        <tr>
      <tr>
        <td height="17" align="center">Estado:      
      <tr>
        <td height="37" align="center"><span id="spryselect1">
          <label>
            <select name="estado" id="estado">
            <option value="">.:Seleccione:.</option>
	  <?php
					while($rowEstado = mysql_fetch_array($listaestado_solicitud))
					{
						echo '<option value="'.$rowEstado[idestado_solicitud].'">'.$rowEstado[descestado_solicitud].'</option>';
					}
				?>
            </select>
          </label>
          <span class="selectRequiredMsg">Seleccione un elemento.</span></span>      
        *<tr>
    <td height="17" align="center">Diagnostico:
    <tr>
      <td height="126" align="center"><textarea name="Diagnostico" id="Diagnostico" cols="80" rows="10" value="<?php $regsolicitud[Diagnostico]?>"></textarea>    
      <tr>
    <td align="center"><input type="submit" name="guardar" id="guardar" value="Enviar" />
      <input type="reset" name="restablecer" id="restablecer" value="Restablecer" />
      <label>
        <input type="hidden" name="Id" id="Id" value="<?php echo $idsolicitud  
	  ?>" />
      <input type="hidden" name="Session" id="Session" value="<?php echo $CurrentUser  
	  ?>" />
</label>
<div id="notificacion" class="notificacion" align="center"></div>
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
</body>
</html>