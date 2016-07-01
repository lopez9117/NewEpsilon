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
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; Eventos Adversos</span>
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
				<a class="class_nombre" style="text-decoration:none" href="mostrar.php">
				<img src="img/evento.PNG" width="72" height="72" id="Image1" border="0"></a>
				</td><td width="75%" valign="middle">
				<div style="margin-left:4px">
				<span style="">
				<a class="class_login" style="text-decoration:none;font-size:16px" href="mostrar.php">
				Todos los eventos adversos</a></span><br />
				<span class="class_tr03" style="font-weight:normal;">Visualiza todas los eventos adversos de la organizaci&oacute;n.</span></div>
				</td></tr>
								</table>
				</td><td width="25%" height="100" align="center"><table width="80%">
				  <tr>
				    <td width="25%"><a class="class_nombre" style="text-decoration:none" href="index.php"> 
				    <img src="img/user.png" alt="" width="72" height="72" id="Image3" border="0" /></a></td>
				    <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="index.php">Nuevos eventos adversos</a></span><br />
				      <span class="class_tr03" style="font-weight:normal;">Registre los eventos adversos ocacionados en la compañia</span> </div></td>
				    </tr>
				  </table></td><td width="25%" height="100" align="center"><table width="80%">
				  <tr>
				    <td width="25%"><a class="class_nombre" style="text-decoration:none" href="ReportFacuracionSede2.php"> <img src="img/ex.png" alt="" width="72" height="72" id="Image3" border="0" /></a></td>
				    <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="reporte.php">Reporte de eventos</a></span><br />
				      <span class="class_tr03" style="font-weight:normal;">Desarcarge el reporte de todos los eventos registrados</span> </div></td>
				    </tr>
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