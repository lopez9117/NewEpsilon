<?php
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con post
	$informe = $_POST['idInforme'];
	$user = $_POST['usuario'];
	//variables del sistema
	$sdate = date("Y")."-".date("m")."-".date("d");
	$stime = date("G:i:s");
	//validar que no se haga mas de una vez el registro
	$sql = mysql_query("SELECT l.id_estadoinforme, i.id_estadoinforme FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe = l.id_informe WHERE
	i.id_estadoinforme = '5' AND l.id_estadoinforme = '5' AND l.id_informe = '$informe' AND i.id_informe = '$informe'", $cn);
	$con = mysql_num_rows($sql);
	
	if($con=="" || $con==0)
	{
	//acciones en la bd
		mysql_query("UPDATE r_informe_header SET id_estadoinforme = '5', idfuncionario_esp = '$user' WHERE id_informe = '$informe'", $cn);
		//insersion en el log del informe
		mysql_query("INSERT INTO r_log_informe VALUES('$informe','$user','5','$sdate','$stime')", $cn);
		//cerrar conexion
		mysql_close();
	}
?>