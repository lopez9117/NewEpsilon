<body onBeforeUnload="return window.opener.CargarAgenda();">
<?php 
	//archivo de conexion
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//declaracion de variables
	$informe = $_POST['ResultadoInforme'];
	$idInforme = $_POST['idInforme'];
	$observacion = $_POST['observacionTranscripcion'];
	$adicional = $_POST['adicional'];
	$usuario = $_POST['usuario'];
	$opcion = $_POST['opcion'];
	$fecha = date("Y")."-".date("m")."-".date("d");
	$hora = date("G:i:s");
	
	if($opcion=="parcial")
	{
		//actualizar los datos en el header del informe
		mysql_query("UPDATE r_informe_header SET idfuncionario_trans = '$usuario' WHERE id_informe = '$idInforme'", $cn);
		//insersion en el detalle del informe
		mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe', adicional = '$adicional' WHERE id_informe = '$idInforme'", $cn);
		//regisrar observacion	
		if($observacionTranscripcion!="")
	{
		mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacionTranscripcion','$fecha', '$hora','1')", $cn);
	}
		//codificar las variables para devolver por GET
		echo '<script language="javascript">location.href = "../transcripcion/TranscribirEstudio.php?informe='.base64_encode($idInforme).'&user='.base64_encode($usuario).'"</script>';
	}
	
	elseif($opcion=="finalizar")
	{	
		//actualizar los datos en el header del informe
		mysql_query("UPDATE r_informe_header SET idfuncionario_trans = '$usuario', id_estadoinforme = '4' WHERE id_informe = '$idInforme'", $cn);
		//registrar detalles del informe (transcripcion)
			mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe', adicional = '$adicional' WHERE id_informe = '$idInforme'", $cn);
			//regisrar observacion	
	if($observacionTranscripcion!="")
	{
		mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacionTranscripcion','$fecha', '$hora','1')", $cn);
	}
		//realizar una insersion en el log
		mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','4','$fecha','$hora')", $cn);
		echo '<script language="javascript">window.close();</script>';
	}	
?>
</body>