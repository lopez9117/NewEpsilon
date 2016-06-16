<?php
//Conexion a la BD
include("../../dbconexion/conexion.php");
$cn = conectarse();
//Variable desencriptada
$User = base64_decode($_REQUEST['User']);

$sql = mysql_query("SELECT u.idusuario, u.email, f.nombres, f.apellidos FROM usuario u
INNER JOIN funcionario f ON f.idfuncionario = u.idusuario WHERE u.idusuario = '$User'", $cn);
$reg = mysql_fetch_array($sql);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../css/forms.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/jquery-1.7.1.js"></script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<body topmargin="0">
<script language="javascript">
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #UserData').submit(function() {
 		// Enviamos el formulario usando AJAX
        $.ajax({
		type: 'POST',
		url: $(this).attr('action'),
		data: $(this).serialize(),
		// Mostramos un mensaje con la respuesta de PHP
		success: function(data) {
		$('#Respuesta').html(data);
            }
        })        
        return false;
    }); 
})
</script>
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px">Mi Cuenta</span></span>
	</div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr>
		  <td width="100%" height="8" align="center" background=""><table width="50%" border="0">
        <form name="UserData" id="UserData" action="UpdateAcount.php" method="post">
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td><p>Usuario</p>
		      <p>
		        <label for="user"></label>
		        <input type="text" name="user" id="user" class="text" readonly="readonly" value="<?php echo $reg[idusuario]?>" />
		      </p></td>
		    <td><p>E-Mail</p>
		      <p>
		        <label for="email"></label>
		        <input type="text" name="email" id="email" class="text" value="<?php echo $reg[email] ?>" />
		      </p></td>
		    </tr>
		  <tr>
		    <td><p>Nombres</p>
		      <p>
		        <label for="nombres"></label>
		        <input type="text" name="nombres" id="nombres" class="text"  readonly="readonly" value="<?php echo $reg[nombres] ?>"/>
		      </p></td>
		    <td><p>Apellidos</p>
		      <p>
		        <label for="apellidos"></label>
		        <input type="text" name="apellidos" id="apellidos" class="text" readonly="readonly" value="<?php echo $reg[apellidos] ?>"/>
		      </p></td>
		    </tr>
		  <tr>
		    <td><p>Nuevo Password</p>
		      <p>
		        <label for="pass1"></label>
		        <input type="password" name="pass1" id="pass1" class="text" />
		      *</p></td>
		    <td><p>Confirmar Password</p>
		      <p>
		        <label for="pass2"></label>
		        <input type="password" name="pass2" id="pass2" class="text"/>
		      *</p></td>
		    </tr>
		  <tr>
		    <td>&nbsp;</td>
		    <td>&nbsp;</td>
		    </tr>
		  <tr>
		    <td><div id="Respuesta"></div></td>
		    <td><input type="submit" value="Actualizar Datos" /></td>
		    </tr></form>
		  </table></td></tr></table></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</body>
</html>