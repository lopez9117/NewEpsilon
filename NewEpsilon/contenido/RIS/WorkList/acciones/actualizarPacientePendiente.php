<?php
	$user = $_POST['usuario'];
	//Conexion a la base de datos
	require_once('../../../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	//variables
	$informe = $_POST['informe'];
	$sdate = date("Y")."-".date("m")."-".date("d");
	$stime = date("G:i:s");
	//validar que no se haga mas de una vez el registro
	$sql = mysql_query("SELECT l.id_estadoinforme FROM r_log_informe l WHERE l.id_estadoinforme = '2' AND l.id_informe = '$informe'", $cn);
	$con = mysql_num_rows($sql);
	if($con=="" || $con==0)
	{
	//acciones en la bd
		mysql_query("UPDATE r_informe_header SET id_estadoinforme = '2', idfuncionario_take = '$user' WHERE id_informe = '$informe'", $cn);
		//insersion en el log del informe
		mysql_query("INSERT INTO r_log_informe VALUES('$informe','$user','2','$sdate','$stime')", $cn);
		//cerrar conexion
		mysql_close();
	}
?>