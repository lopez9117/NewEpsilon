<body onBeforeUnload="return window.opener.cargarResultados()">
<?php 
	//archivo de conexion
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//declaracion de variables
	$informe = $_POST['informe'];
	$idInforme = $_POST['idInforme'];
	$observacion = $_POST['observacionTranscripcion'];
	$usuario = $_POST['usuario'];
	$opcion = $_POST['opcion'];
	$firma_respaldo=$_POST['firmaRespaldo'];
	$fecha = date("Y")."-".date("m")."-".date("d");
	$hora = date("G:i:s");
	//validar que no se haga mas de una vez el registro
	$sql = mysql_query("SELECT * FROM r_log_informe WHERE id_estadoinforme = '8' AND id_informe ='$idInforme'", $cn);
	$con = mysql_num_rows($sql);
	if($con=="" || $con==0)
	{
		//registrar detalles del informe (transcripcion)
		mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe' WHERE id_informe = '$idInforme'", $cn);
		//realizar una insersion en el log
		mysql_query("UPDATE r_informe_header SET id_estadoinforme = '8' WHERE id_informe = '$idInforme'", $cn);
		mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','8','$fecha','$hora')", $cn);
		if ($firma_respaldo!="")
		{
			mysql_query("INSERT INTO r_firma_respaldo VALUES('$idInforme','$firma_respaldo')", $cn);
		}
		if($observacionTranscripcion!="")
		{
			mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacion','$fecha', '$hora')", $cn);
		}
		echo '<script language="javascript">window.close();</script>';
	}
	else
	{
	mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe' WHERE id_informe = '$idInforme'", $cn);
		//realizar una insersion en el log
		mysql_query("UPDATE r_informe_header SET id_estadoinforme = '8' WHERE id_informe = '$idInforme'", $cn);
		if ($firma_respaldo!="")
		{
			mysql_query("INSERT INTO r_firma_respaldo VALUES('$idInforme','$firma_respaldo')", $cn);
		}
		if($observacionTranscripcion!="")
		{
			mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacion','$fecha', '$hora')", $cn);
		}
		echo '<script language="javascript">window.close();</script>';
	}
?>
</body>