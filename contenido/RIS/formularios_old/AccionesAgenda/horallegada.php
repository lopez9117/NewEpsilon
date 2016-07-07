<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	echo $idInforme = $_POST['idforme'];
	$usuario = $_POST['usuario'];
	$horallegada=$_POST['horallegada'];
	$fecha = date("Y-m-d");
	$hora = date("G:i:s");
	$consulta = mysql_query("SELECT * FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '11'", $cn);
			$registro = mysql_num_rows($consulta);
			//validar contando los registros
			if($registro=="" || $registro==0)
			{
				//realizar una insersion en el log
				mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario ','11','$fecha','$hora')", $cn);	
			}
?>