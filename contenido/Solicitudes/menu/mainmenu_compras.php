<?php
session_start();
	include("../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con POST
	$idusuario = $_SESSION['currentuser'];
	$sql = mysql_query("SELECT idgrupo_empleado, idfuncionario FROM funcionario WHERE idgrupo_empleado='10
	' AND idfuncionario='$idusuario' OR idgrupo_empleado='16' AND idfuncionario='$idusuario' OR idgrupo_empleado='1' AND idfuncionario='$idusuario' OR idgrupo_empleado='7' AND idfuncionario='$idusuario';", $cn);
	$reg = mysql_num_rows($sql);
	if($reg==0 || $reg=="")
	{
		echo 
		'<script type="text/javascript">
			alert("Acceso denegado");
			window.location = "main_menu_solicitudes.php";
		</script>';
	}
	else 
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Prodiagnostico S.A</title>
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
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
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a> <a href="../menu/main_menu_solicitudes.php"> > Solicitudes</a> &gt; </span>Soportes Compras</span>	</div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr><td width="25%" height="100" align="center">				<table width="80%">
								<tr>
								  <td width="25%">
				<a class="class_nombre" style="text-decoration:none" href="../SolicitudCompra.php">
				<img src="../../../images/gaimphone.png" width="72" height="72" id="Image1" border="0"></a>
				</td><td width="75%" valign="middle">
				<div style="margin-left:4px">
				<span style="">
				<a class="class_login" style="text-decoration:none;font-size:16px" href="../SolicitudCompra.php">Realizar Solicitud de Compra o Servicio</a></span>.<br />
				<span class="class_tr03" style="font-weight:normal;">Realice solicitudes de compra de Activos o compras de Servicios..</span></div>
				</td></tr>
								</table>
				</td>
		    <td width="25%" align="center"><table width="80%">
		      <tr>
		        <td width="25%"><a class="class_nombre" style="text-decoration:none" href="../listado/SolicitudesCompras.php"> <img src="../../../images/kate.png" alt="" width="72" height="72" id="Image2" border="0" /></a></td>
		        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="../listado/SolicitudesCompras.php">  Aprobaci&oacute;n de compras </a></span>.<br />
		          <span class="class_tr03" style="font-weight:normal;">Realice vistas de las solicitudes de compra de activosl.</span></div></td>
		        </tr>
		      </table></td>
		    <td width="25%" height="100" align="center"><table width="80%">
				  <tr>
				    <td width="25%"><a class="class_nombre" style="text-decoration:none" href="../listado/SolicitudesServicios.php"> <img src="../../../images/advancedsettings.png" alt="" width="72" height="72" id="Image3" border="0" /></a></td>
				    <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="../listado/SolicitudesServicios.php"> Aprobaci&oacute;n de servicios</a></span>.<br />
				      <span class="class_tr03" style="font-weight:normal;">Realice vistas de las solicitudes de servicios.</span> </div></td>
				    </tr>
			  </table></td></tr><tr><td colspan=3 background="" height="8" align="center">&nbsp;</td></tr></table></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</div>
</div>
</body>
</html>
<?php
}
?>
