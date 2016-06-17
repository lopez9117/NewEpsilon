<?php
//Conexion a la base de datos
	require_once('../../../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	//variables
	$usuario = $_POST['usuario'];
	$informe = $_POST['informe'];
	$sdate = date("Y")."-".date("m")."-".date("d");
	$stime = date("G:i:s");
	//validar que no se haga mas de una vez el registro
	$sql = mysql_query("SELECT l.id_estadoinforme, i.id_estadoinforme FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe = l.id_informe WHERE
	i.id_estadoinforme = '4' AND l.id_estadoinforme = '4' AND l.id_informe = '$informe' AND i.id_informe = '$informe'", $cn);
	$con = mysql_num_rows($sql);
	
	if($con=="" || $con==0)
	{
		//modificar el estado del informe
		mysql_query("UPDATE r_informe_header SET id_estadoinforme = '4', idfuncionario_trans = '$usuario' WHERE id_informe = '$informe'", $cn);
		//insersion en el log del informe
		mysql_query("INSERT INTO r_log_informe VALUES('$informe','$usuario','4','$sdate','$stime')", $cn);
		//cerrar conexion
		mysql_close();
	}
?>