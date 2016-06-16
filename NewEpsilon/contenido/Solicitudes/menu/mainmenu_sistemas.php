<?php
session_start();
$CurrentUser = $_SESSION[currentuser];
if ($CurrentUser=="" || $CurrentUser==0)
{
echo 
		'<script type="text/javascript">
			mensaje = confirm("Es necesario iniciar session de nuevo para poder realizar solicitud, desea hacerlo ahora?");
			if(mensaje==true)
			{
			parent.parent.location.href = "../../../includes/logout.php";
			}
		</script>';
}
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
		<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px"><a href="../../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a><a href="../menu/main_menu_solicitudes.php"> &gt; Solicitudes</a> &gt; </span>Soportes Sistemas</span>	</div>
	<table width="98%" border="0">
	<tr>
	<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
	</tr>
	<tr>
	<td valign="top" align="center" bgcolor="#DEDEDE">
		<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr><td width="25%" height="100" align="center">
		<table width="80%">
								<tr>
								  <td width="25%">
				<a class="class_nombre" style="text-decoration:none" href="../SolicitudSistemas.php?User=<?php echo $CurrentUser?>">
				<img src="../../../images/gaimphone.png" width="72" height="72" id="Image1" border="0"></a>
				</td><td width="75%" valign="middle">
				<div style="margin-left:4px">
				<span style="">
				<a class="class_login" style="text-decoration:none;font-size:16px" href="../SolicitudSistemas.php?User=<?php echo $CurrentUser?>">Realizar Solicitud de Sistemas.</a></span><br />
				<span class="class_tr03" style="font-weight:normal;">Realice solicitudes de sistemas en tiempo real</span></div>
				</td></tr>
								</table>
				</td><td width="25%" height="100" align="center"><table width="80%">
				  <tr>
				    <td width="25%"><a class="class_nombre" style="text-decoration:none" href="../listado/Solicitudes.php"> <img src="../../../images/kate.png" alt="" width="72" height="72" id="Image3" border="0" /></a></td>
				    <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="../listado/Solicitudes.php"> Solicitudes de sistemas</a></span>.<br />
				      <span class="class_tr03" style="font-weight:normal;">Realice vistas de las solicitudes de sistemas en tiempo real.</span> </div></td>
				    </tr>
			  </table></td></tr><tr><td colspan=2 background="" height="8" align="center">&nbsp;</td></tr></table></td>
	</tr>
	</table>
	<br>
	</div>
</td></tr>
</table>
</div></div>

</body>
</html>

</body>
</html>