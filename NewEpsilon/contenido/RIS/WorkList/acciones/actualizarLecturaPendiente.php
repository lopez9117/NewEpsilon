<?php
$user = $_POST['usuario'];
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$informe = $_POST['informe'];
$sdate = date("Y")."-".date("m")."-".date("d");
$stime = date("G:i:s");
//validar si existe un registro para el informe
$sqlInforme = mysql_query("SELECT id_informe FROM r_detalle_informe WHERE id_informe = '$informe'", $cn);
$ConInforme = mysql_num_rows($sqlInforme);
if($ConInforme=='0' || $ConInforme=="")
{
	//insertar registro en la base de datos
	mysql_query("INSERT INTO r_detalle_informe (id_informe, detalle_informe, adicional, id_tipo_resultado) VALUES ('$informe', '&nbsp;','&nbsp;','0')", $cn);
}
else
{
	//validar que la lectura no se selecciona mas de una vez
	$con = mysql_query("SELECT l.id_estadoinforme, i.id_estadoinforme FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe = l.id_informe WHERE
	i.id_estadoinforme = '3' AND l.id_estadoinforme = '3' AND l.id_informe = '$informe' AND i.id_informe = '$informe'", $cn);
	$reg = mysql_num_rows($con);
	
	if($reg=="" || $reg==0)
	{
		mysql_query("UPDATE r_informe_header SET id_estadoinforme = '3', idfuncionario_esp = '$user' WHERE id_informe='$informe'", $cn);
		//insersion en el log del informe
		mysql_query("INSERT INTO r_log_informe VALUES('$informe','$user','3','$sdate','$stime')", $cn);
		//cerrar conexion
		mysql_close();
	}
}
?>