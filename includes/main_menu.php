<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
include("../validate/ValidateSecurity.php");
//current user
$_SESSION['username'];
$_SESSION['user_id'];
if($_SESSION['username']=="" || $_SESSION['user_id']=="" )
{
	echo 'POR FAVOR INICIAR SESSION NUEVAMENTE';
}
else
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_SESSION['username']; ?></title>	
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache">
<link href="../css/default.css" rel="stylesheet" type="text/css">
<link href="../css/ventanas_modales.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/ajax.js"></script>
 <script type="text/javascript" src="../js/jquery-1.9.1.js"></script>	
<script type="text/javascript" src="js/jquery.min.js"></script>	
<script type="text/javascript" src="../js/ventanas_modales.js"></script>
</head>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
<body>
<div id="nav">
<div class="show">
<table width="100%" border="0">
<tr><td align="center" valign="middle">
<div class="marco" id="marco">
<div class="ruta">
<span class="class_cargo" style="font-size:14px">MEN&Uacute; PRINCIPAL</span>
</div>
<table width="98%" border="0">
<tr>
<td colspan="2" height="7"><div style="border-bottom: #D3D3D3 2px dotted"></div><br></td>
</tr>
<tr>
<td valign="top" align="center" bgcolor="#DEDEDE">
<table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr><td width="25%" height="100" align="center">				
<table width="80%">
	<tr>
		<td width="25%"><a class="class_nombre" style="text-decoration:none" href="#"><img src="../images/file-manager.png" width="72" height="72" id="Image1" border="0"></a>
		</td>
	<td width="75%" valign="middle">
		<div style="margin-left:4px">
			<span style=""><a class="class_login" style="text-decoration:none;font-size:16px" href="#">Gesti&oacute;n Documental</a>
        	</span><br/>
			<span class="class_tr03" style="font-weight:normal;">Cree y controle sus documentos.</span></div>
		</td>
	</tr>
</table>
</td>
<td width="25%" height="100" align="center">				
	<table width="80%">
	<tr>
		<td width="25%"><a class="class_nombre" style="text-decoration:none" href="../contenido/cuadro_de_turnos/main_menu_cuadrot.php?Mod=2&User=<?php echo $CurrentUser?>"><img src="../images/lassists.png" width="72" height="72" id="Image3" border="0"></a>
			</td>
            <td width="75%" valign="middle">
				<div style="margin-left:4px">
                <span style=""><a class="class_login" style="text-decoration:none;font-size:16px" href="../contenido/cuadro_de_turnos/main_menu_cuadrot.php?Mod=2&User=<?php echo $CurrentUser?>">Cuadro de turnos</a>
                </span><br/>
<span class="class_tr03" style="font-weight:normal;">Registre turnos para su personal administrativo y asistencial.</span></div>
			</td>
            </tr>
     </table>
</td>
<td width="25%" height="100" align="center">
	<table width="80%">
	<tr>
		<td width="25%"><a href="../contenido/RIS/ValidateRIS.php?Mod=3&User=<?php echo $CurrentUser?>" class="clsVentanaIFrame" rel="Sistema de Informacion Radiologica RIS" style="text-decoration:none" ><img src="../images/kedit.png" width="72" id="Image4" border="0"></a>
		</td>
        	<td width="75%" valign="middle"><div style="margin-left:4px"><span style=""><a href="../contenido/RIS/ValidateRIS.php?Mod=3&User=<?php echo $CurrentUser?>"class="clsVentanaIFrame" rel="istema de Informacion Radiologica RIS" style="text-decoration:none;font-size:16px; font-family: Trebuchet MS, Arial, Verdana; font-weight:bold; color: #0B5781"  >RIS</a></span><br />
<span class="class_tr03" style="font-weight:normal;">Sistema de informacion radiologica.</span></div>
			</td>
     </tr>
</table>
</td><td width="25%" height="100" align="center">				<table width="80%">
<tr>
<td width="25%">
<a class="class_nombre" style="text-decoration:none" href="../contenido/Solicitudes/menu/main_menu_solicitudes.php?Mod=4&User=<?php echo $CurrentUser?>">
<img src="../images/gaimphone.png" width="72" height="72" id="Image8" border="0"></a>
</td><td width="75%" valign="middle">
<div style="margin-left:4px">
<span style="">
<a class="class_login" style="text-decoration:none;font-size:16px" href="../contenido/Solicitudes/menu/main_menu_solicitudes.php?Mod=4&User=<?php echo $CurrentUser?>">
Solicitudes</a></span><br />
<span class="class_tr03" style="font-weight:normal;">Realice solicitudes para su area en tiempo real.</span>
</div>
</td></tr>
</table>
</td></tr><tr><td colspan=4 background="" height="8" align="center"><div style="border-bottom: #FFFFFF 4px dotted"></div></td></tr></table><table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE"><tr>
<td width="25%" height="100" align="center"><table width="80%">
<tr>
<td width="25%"><a class="class_nombre" style="text-decoration:none" href="../contenido/talento_humano/main_menu_talentoh.php?Mod=5&User=<?php echo $CurrentUser?>"><img src="../images/Community Help.png" width="72" height="72" id="Image9" border="0"></a></td>
<td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="../contenido/talento_humano/main_menu_talentoh.php?Mod=2&User=<?php echo $CurrentUser?>">Talento Humano</a></span><br />
<span class="class_tr03" style="font-weight:normal;">Registre el personal de su empresa y administre sus hojas de vida de forma virtual.</span> </div></td>
</tr>
</table></td><td width="25%" height="100" align="center">				<table width="80%">
<tr>
<td><a class="class_nombre" style="text-decoration:none" href="../contenido/ActivosFijos/main_menu_activosfijos.php"> <img src="../images/qr.png" alt="" width="60" height="60" id="Image10" border="0"></a></td>
<td valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="#"> Activos Fijos</a></span><br />
  <span class="class_tr03" style="font-weight:normal;">Controle los activos fijos de la empresa.</span></div></td>
</tr>
</table>
</td><td width="25%" height="100" align="center"><table width="80%">
<tr>
<td width="25%">
<a class="class_nombre" style="text-decoration:none" href="../contenido/reportes/main_menu_reportes.php?Mod=7&User=<?php echo $CurrentUser?>">
<img src="../images/editpaste.png" width="72" height="72" id="Image5" border="0"></a>
</td><td width="75%" valign="middle">
<div style="margin-left:4px">
<span style="">
<a class="class_login" style="text-decoration:none;font-size:16px" href="../contenido/reportes/main_menu_reportes.php?Mod=7&User=<?php echo $CurrentUser?>">
Reportes</a></span><br />
<span class="class_tr03" style="font-weight:normal;">Reciba informacion de productividad en tiempo real.</span>
</div>
</td></tr>
</table>
</td><td width="25%" height="100" align="center">				<table width="80%">
<tr>
<td width="25%">
<a class="class_nombre" style="text-decoration:none" href="../contenido/estadistica/Graficos.php" target="popup" onClick="window.open(this.href, this.target, width=1000,height=1000); return false;">
<img src="../images/Volume Manager.png" width="72" height="72" id="Image2" border="0"></a>
</td><td width="75%" valign="middle">
<div style="margin-left:4px">
<span style="">
<a class="class_login" style="text-decoration:none;font-size:16px" href="../contenido/estadistica/Graficos.php" target="popup" onClick="window.open(this.href, this.target, width=1000,height=1000); return false;">
Estadisticas</a></span><br />
<span class="class_tr03" style="font-weight:normal;">Visualice graficos estadisticos.</span>
</div>
</td></tr>
</table>
</td></tr><tr><td colspan=4 background="" height="8" align="center"><div style="border-bottom: #FFFFFF 4px dotted"></div></td></tr></table><table width="99%"  border="0" cellpadding="0" cellspacing="0" bordercolor="#E6E9EC" bgcolor="#DEDEDE">
  <tr>
    <td height="100" align="center"><table width="80%">
      <tr>
        <td width="25%"><a class="class_nombre" style="text-decoration:none" href="../contenido/GestionUsuarios/mainMenuGestion.php?Mod=9&amp;User=<?php echo $CurrentUser?>"> <img src="../images/Login Manager.png" alt="" width="72" height="72" border="0" id="Image6" /></a></td>
        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="../contenido/GestionUsuarios/mainMenuGestion.php?Mod=9&amp;User=<?php echo $CurrentUser?>"> Gestion de Usuarios.</a></span><br />
          <span class="class_tr03" style="font-weight:normal;">Administre los usuarios y permisos de acceso.</span></div></td>
      </tr>
    </table></td>
    <td height="100" align="center"><table width="80%">
      <tr>
        <td width="25%"><a class="class_nombre" style="text-decoration:none" href="#"> <img src="../images/advancedsettings.png" alt="" width="72" height="72" border="0" id="Image16" /></a></td>
        <td width="75%" valign="middle"><div style="margin-left:4px"> <span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="#"> Configuraci&oacute;n del sistema.</a></span><br />
        </div></td>
      </tr>
    </table></td>
    <td height="100" align="center"><table width="80%">
      <tr>
        <td width="25%"><a class="class_nombre" style="text-decoration:none" href="../contenido/encuestas/index.php?User=<?php echo base64_encode($CurrentUser) ?>" target="_blank"> <img src="../images/lists.png" alt="" width="72" height="72" border="0" id="Image7" /></a></td>
        <td width="75%" valign="middle"><div style="margin-left:4px"> 
          <p><span style=""> <a class="class_login" style="text-decoration:none;font-size:16px" href="../contenido/encuestas/index.php?User=<?php echo base64_encode($CurrentUser) ?>" target="_blank">Encuestas<br />
          </a></span><span class="class_tr03" style="font-weight:normal;">Realice encuestas de los usuarios y auditoria de estas.</span><br />
          </p>
</div></td>
      </tr>
    </table></td>
    <td height="100" align="center">&nbsp;</td>
  </tr>
  <tr><td width="25%" height="100" align="center">&nbsp;</td><td width="25%" height="100" align="center">&nbsp;</td><td width="25%" height="100" align="center">&nbsp;</td><td width="25%" height="100" align="center">&nbsp;</td></tr><tr><td colspan=4 background="" height="8" align="center"><!--<div style="border-bottom: #FFFFFF 4px dotted"></div>--></td></tr></table></td>
</tr>
</table>
<br>
</div>
</td></tr>
</table>
</div>
</div>
<?php
}
?>
</body>
</html>