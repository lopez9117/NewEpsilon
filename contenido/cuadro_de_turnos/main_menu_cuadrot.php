<?php 
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION[currentuser] ;
	$mod = 2;
	include("../ValidarModulo.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache">
<title>Cuadro de Turnos - Prodiagnostico S.A</title>
<link href="../css/cuadroTurnos.css" rel="stylesheet" type="text/css" />
<link href="../../css/default.css" rel="stylesheet" type="text/css">
<link type="text/css" href="../css/demo_table.css" rel="stylesheet" />
<link href="../css/default.css" rel="stylesheet" type="text/css">
<!-- END VALIDADOR -->
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
<div class="show">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
	
	<div class="marco">
	<div class="ruta">
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; Cuadro de turnos</span>
	</div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE">
		  <tr>
		    <td height="100" align="center"><table width="80%">
		      <tr>
		        <td width="25%"><a href="CrearCuadroTurnos.php" class="class_nombre" style="text-decoration:none"> <img src="../../images/kjumpingcube.png" alt="" width="72" height="72" border="0" id="Image1" /></a></td>
		        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a href="CrearCuadroTurnos.php" class="class_login" style="text-decoration:none;font-size:16px"> Cuadro de turnos</a></span><br />
		          <span class="class_tr03" style="font-weight:normal;">Elabore cuadros de turnos para el personal de la empresa.</span></div></td>
		        </tr>
		      </table></td>
		    <td height="100" align="center"><table width="80%">
		      <tr>
		        <td width="25%"><a class="class_nombre" style="text-decoration:none" href="Convenciones/crearConvencion.php"> <img src="../../images/karbon.png" alt="" width="72" height="72" id="Image2" border="0" /></a></td>
		        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="Convenciones/crearConvencion.php"> Convenciones</a></span><br />
		          <span class="class_tr03" style="font-weight:normal;">Agilice su trabajo elaborando convenciones para registrar de manera rapida los turnos.</span></div></td>
		        </tr>
		      </table></td>
		    <td height="100" align="center"><table width="80%">
		      <tr>
		        <td width="25%"><a class="class_nombre" style="text-decoration:none" href="Disponibilidades/RegistrodeDisponibilidades.php"> <img src="../../images/clicknrun.png" alt="" width="72" height="72" id="Image3" border="0" /></a></td>
		        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="Disponibilidades/RegistrodeDisponibilidades.php"> Disponibilidades</a></span><br />
		          <span class="class_tr03" style="font-weight:normal;">Registrar disponibilidades para el personal asistencial y administrativo..</span></div></td>
		        </tr>
		      </table></td>
		    <td height="100" align="center"><table width="80%">
		      <tr>
		        <td width="25%"><a href="Novedades/RegistroNovedades.php"><img src="../../images/aim.png" alt="" width="72" height="72" border="0" id="Image5" /></a></td>
		        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a href="Novedades/RegistroNovedades.php" class="class_login" style="text-decoration:none;font-size:16px"> Consultar Cuadros de Turnos</a></span></div></td>
		        </tr>
		      </table></td>
		    </tr>
		  <tr>
		    <td width="25%" height="100" align="center"><table width="80%">
		      <tr>
		        <td width="25%"><a class="class_nombre" style="text-decoration:none" href="reports/Reports.php"> <img src="../../images/editpaste.png" alt="" width="72" height="72" id="Image4" border="0" /></a></td>
		        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="reports/Reports.php"> Reporte Horas</a></span><br />
		          <span class="class_tr03" style="font-weight:normal;">Revise los reportes del cuadro de turnos del personal.</span></div></td>
		        </tr>
		      </table></td><td width="25%" height="100" align="center"><table width="80%">
		        <tr>
		          <td width="25%"><a class="class_nombre" style="text-decoration:none" href="reports_disponibilidades/Reports.php"> <img src="../../images/editpaste.png" alt="" width="72" height="72" id="Image6" border="0" /></a></td>
		          <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="reports_disponibilidades/Reports.php"> Reporte disponibilidades</a></span><br />
		          </div></td>
		          </tr>
		        </table></td><td width="25%" height="100" align="center">&nbsp;</td><td width="25%" height="100" align="center">&nbsp;</td></tr><tr><td colspan=4 background="" height="8" align="center">&nbsp;</td></tr></table></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</div></div>
</body>
</html>