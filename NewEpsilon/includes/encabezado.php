<?php
include("../validate/ValidateSecurity.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Main Menu :.</title>
<script type="text/javascript" src="../js/funciones.js"></script>
<!-- VALIDADOR -->
<link href="../js/Validate/validate.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/mootools.js"></script>
<script type="text/javascript" src="JavaScript/funcionesHeader.js"></script>
<script type="text/javascript" src="../js/Validate/validate.js"></script>
<link href="css/notificaciones.css" rel="stylesheet" type="text/css">
<link href="../css/default.css" rel="stylesheet" type="text/css">
</head>
<body topmargin="0">
<table width="100%" class="tabla" border="0" cellspacing="0" cellpadding="0" align="center" style="min-width:1100px">
<tr>
<td> <span class="class_login"> <?php echo $nombreUsuario ?></span></td>
</tr>
<tr class="class_tr" valign="top">
<td>
</br><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr class="class_tr_top">
<td width="1%">&nbsp;</td>
<td width="8%">
	<table class="class_tr" border="0" cellspacing="0" cellpadding="0"><tr><td><div class="img_inicio" sr></div></td><td>&nbsp;
	<a href="main_menu.php" target="main">Inicio</a>
	</td></tr></table>
</td>
<td width="1%"><div class="img_sep02"></div></td>
<td width="10%">
	<table class="class_tr" border="0" cellspacing="0" cellpadding="0"><tr><td> <?php 
	if ($area==1)
	{
	echo '<div>
	<a href="../contenido/Solicitudes/listado/Solicitudes.php" target="main">Pendientes<span id="notificacion" style="margin-left:5px;"></span></a>       
   </div>';
	}
	else if ($area==5 || $area==3 || $area==7)
	{
		echo '<div>
	<a href="../contenido/Solicitudes/menu/mainmenu_compras.php" target="main">Pendientes<span id="notificacion" style="margin-left:5px;"></span></a>       
   </div>';
	}
	else if ($area==2)
	{
		echo '<div>
	<a href="../contenido/Solicitudes/listado/SolicitudesBiomedico.php" target="main">Pendientes<span id="notificacion" style="margin-left:5px;"></span></a>       
   </div>';
	}
	else if ($area==8)
	{
		echo '<div>
	<a href="../contenido/Solicitudes/listado/SolicitudesInfraestructura.php" target="main">Pendientes<span id="notificacion" style="margin-left:5px;"></span></a>       
   </div>';
	}
	else
	{
	echo '<div>
	<a href="main_menu.php" target="main">Pendientes<span id="notificacion" style="margin-left:5px;"></span></a>       
   </div>';
	}
	?> </tr></table
></td>
<td width="1%"><div class="img_sep02"></div></td>
<td width="11%">
<table class="class_tr" border="0" cellspacing="0" cellpadding="0"><tr><td nowrap="nowrap">&nbsp;
	<a href="../contenido/MiCuenta/MyAcount.php?User=<?php echo base64_encode($CurrentUser) ?>" target="main">Mi cuenta</a>
	&nbsp;</td></tr></table>
</td>
<td width="1%"><div class="img_sep02"></div></td>
<td width="10%">
</td>
<td width="1%"><div class="img_sep02"></div></td>
<td width="50%">
</td>
<td width="1%"><div class="img_sep02"></div></td>
<td width="10%"><a href="#" onclick="salir()"><span><span>Salir</span></span></a>	
</td>
<td width="69%"></td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>