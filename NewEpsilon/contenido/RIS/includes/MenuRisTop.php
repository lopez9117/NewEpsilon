<?php
//registrar la sede y el usuario seleccionados en una variable de sesion permanente
$user = $_GET['user'];
$sede = $_GET['sede'];
//conexion a la base de datos
include("../../../dbconexion/conexion.php");
$cn = conectarse();
//obtener los datos del funcionario
$sqlUser = mysql_query("SELECT nombres, apellidos FROM funcionario WHERE idfuncionario = '$user'");
$regUser = mysql_fetch_array($sqlUser);
//obtener los datos de la unidad de servicios seleccionada
$sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede = '$sede'",$cn);
$regSede = mysql_fetch_array($sqlSede);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Top Menu :.</title>
<link href="../../../css/default.css" rel="stylesheet" type="text/css">
<script language="javascript">
function salir()
{
	mensaje = confirm("Seguro que desea salir de la plataforma?");
	if(mensaje==true)
	{
		parent.parent.location.href = '../UnsetSession/SessionDestroy.php';
	}
}
</script>
<style>
body{
font-family:Arial, Helvetica, sans-serif;
font-size:10px;
margin-left: 0px;
margin-top: 0px;
margin-right: 0px;
}
</style>
</head>
<body topmargin="0">
<table width="98%" border="0" align="center" style="margin-top:5px;">
  <tr>
    <td width="50%"><span class="class_cargo" style="font-size:14px">Usuario: <?php echo ucwords(strtolower($regUser['nombres'])).'&nbsp;'.ucwords(strtolower($regUser['apellidos'])) ?></span>
    </td>
    <td width="30%">
    	<span class="class_cargo" style="font-size:14px" id="class_cargo">Sede : <?php echo $regSede['descsede'] ?></span>
    </td>
    <td width="20%" align="right">
	    <span class="class_login">
      </span>
	    <a class="botones" href="#" onclick="salir()"><span><span>Salir</span></span></a>
    </td>
  </tr>
</table>
</body>
</html>