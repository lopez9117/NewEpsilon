<?php 
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION[currentuser] ;
	$mod = 5;
	include("../ValidarModulo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<link type="text/css" href="../../css/demo_table.css" rel="stylesheet" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link href="../../css/forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
</head>
<body topmargin="0">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; Talento Humano</span>
	</div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr><td width="25%" height="100" align="center">				<table width="80%">
								<tr>
								  <td width="25%">
				<a class="class_nombre" style="text-decoration:none" href="hojas_de_vida.php">
				<img src="../../images/folder_documents.png" width="72" height="72" id="Image1" border="0"></a>
				</td><td width="75%" valign="middle">
				<div style="margin-left:4px">
				<span style="">
				<a class="class_login" style="text-decoration:none;font-size:16px" href="hojas_de_vida.php">
				Hojas de vida</a></span><br />
				<span class="class_tr03" style="font-weight:normal;">Cree las hojas de vida del personal de su organizaci&oacute;n.</span></div>
				</td></tr>
								</table>
				</td><td width="25%" height="100" align="center"><table width="80%">
				  <tr>
				    <td width="25%"><a class="class_nombre" style="text-decoration:none" href="Vacaciones.php"> <img src="../../images/gohome.png" alt="" width="72" height="72" id="Image3" border="0" /></a></td>
				    <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="Vacaciones.php"> Programar Vacaciones</a></span><br />
				      <span class="class_tr03" style="font-weight:normal;">Registre con anticipaci&oacute;n las vacaciones de su personal.</span> </div></td>
				    </tr>
				  </table></td><td width="25%" height="100" align="center"><table width="80%">
				    <tr>
				      <td width="25%"><a class="class_nombre" style="text-decoration:none" href="#"> <img src="../../images/editpaste.png" alt="" width="72" height="72" id="Image4" border="0" /></a></td>
				      <td width="75%" valign="middle"><div style="margin-left:4px"> 
				        <p><span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="#">Seguridad y salud en el trabajo</a></span></p>
				        <p><span class="class_tr03" style="font-weight:normal;">Registre y controle el ausentismo  y causas de accidentalidad laboral.</span><br />
				          </p>
                      </div></td>
				      </tr>
				    </table></td><td width="25%" height="100" align="center">&nbsp;</td></tr><tr><td colspan=4 background="" height="8" align="center">&nbsp;</td></tr></table></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</body>
</html>