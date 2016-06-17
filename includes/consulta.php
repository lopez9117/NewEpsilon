<?php
//inicio de las variables de sesion
session_start();
$area = $_SESSION['area'];
include('../dbconexion/conexion.php');
$cn = Conectarse();
//mostrar contador para el area de sistemas/biomedica
if ($area==1 || $area==2 || $area==8)
{
	//consultar cantidad de solicitudes pendientes para cada area
	$sql = mysql_query("SELECT DISTINCT(COUNT(idsolicitud)) AS pendientes FROM solicitud WHERE idestado_solicitud = '1' AND idarea = '$area'", $cn);
	$reg = mysql_fetch_array($sql);
	$count = $reg['pendientes'];
	if($count>0)
	{
		echo $count;
	}
}
//mostrar contador de solicitudes para el area suministros
elseif($area==5)
{
	$sql = mysql_query("SELECT COUNT(idestado_solicitud) AS pendientes FROM solicitud WHERE id_estadocompra = '4'", $cn);
	$reg = mysql_fetch_array($sql);
	$count = $reg['pendientes'];
	if($count>0)
	{
		echo $count;
	}
}
//mostrar contador de solicitudes para el area costos
elseif($area==7)
{
	$sql = mysql_query("SELECT COUNT(idestado_solicitud) AS pendientes FROM solicitud WHERE id_presupuesto = '0' AND idarea = '3'", $cn);
	$reg = mysql_fetch_array($sql);
	$count = $reg['pendientes'];
	if($count>0)
	{
		echo $count;
	}
}
//mostrar contador de solicitudes para el area subgerencia
elseif($area==3)
{
	$sql = mysql_query("SELECT COUNT(idestado_solicitud) AS pendientes FROM solicitud WHERE idestado_solicitud = '1' AND idarea = '3' AND id_presupuesto != '0'", $cn);
	$reg = mysql_fetch_array($sql);
	$count = $reg['pendientes'];
	if($count>0)
	{
		echo $count;
	}
}
elseif($area==12)
{
	$sql = mysql_query("SELECT COUNT(idestado_solicitud) AS pendientes FROM solicitud WHERE idestado_solicitud = '8' AND idarea = '3' AND id_presupuesto != '0'", $cn);
	$reg = mysql_fetch_array($sql);
	$count = $reg['pendientes'];
	if($count>0)
	{
		echo $count;
	}
}

?>