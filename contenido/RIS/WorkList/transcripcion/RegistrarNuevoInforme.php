<body onBeforeUnload="return window.opener.CargarAgenda();">
<?php 
	//archivo de conexion
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//declaracion de variables
	$informe = $_POST['informe'];
	$idInforme = $_POST['idInforme'];
	$observacion = $_POST['observacionTranscripcion'];
	$adicional = $_POST['adicional'];
	$usuario = $_POST['usuario'];
	$opcion = $_POST['opcion'];
	$fecha = date("Y")."-".date("m")."-".date("d");
	$hora = date("G:i:s");
	$id = base64_encode($idInforme);
	if($opcion=="parcial")
	{
		//consultar si el informe ya fue transcrito
		$sql = mysql_query("SELECT * FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
		$res = mysql_num_rows($sql);
		if($res=="" || $res==0)	
		{
			//actualizar los datos en el header del informe
			mysql_query("UPDATE r_informe_header SET idfuncionario_trans = '$usuario' WHERE id_informe = '$idInforme'", $cn);
			//insersion en el detalle del informe
			mysql_query("INSERT INTO r_detalle_informe VALUES('$idInforme','$informe','$adicional')", $cn);
			if($observacionTranscripcion!="")
			{
				mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacionTranscripcion','$fecha', '$hora')", $cn);
			}
			//codificar las variables para devolver por GET
			echo '<script language="javascript">location.href = "../transcripcion/TranscribirEstudio.php?informe='.$id.'&user='.$usuario.'"</script>';
		}
		else
		{
			//registrar detalles del informe (transcripcion)
			mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe', adicional = '$adicional' WHERE id_informe = '$idInforme'", $cn);
			if($observacionTranscripcion!="")
			{
				mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacionTranscripcion', '$fecha', '$hora')", $cn);
			}
			//codificar las variables para devolver por GET
			echo '<script language="javascript">location.href = "../transcripcion/TranscribirEstudio.php?informe='.$id.'&user='.$usuario.'"</script>';
		}
	}
	elseif($opcion=="finalizar")
	{
		//consultar si el informe ya fue transcrito
		$sql = mysql_query("SELECT * FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
		$res = mysql_num_rows($sql);
		if($res=="" || $res==0)	
		{
			//actualizar los datos en el header del informe
			mysql_query("UPDATE r_informe_header SET idfuncionario_trans = '$usuario', id_estadoinforme = '4' WHERE id_informe = '$idInforme'", $cn);
			//realizar una insersion en el log
			mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','4','$fecha','$hora')", $cn);
			//insersion en el detalle del informe
			mysql_query("INSERT INTO r_detalle_informe VALUES('$idInforme','$informe','$adicional')", $cn);
			if($observacionTranscripcion!="")
			{
				mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacionTranscripcion','$fecha', '$hora')", $cn);
			}
			//codificar las variables para devolver por GET
			echo '<script language="javascript">window.close();</script>';;
		}
		else
		{
			//actualizar los datos en el header del informe
			mysql_query("UPDATE r_informe_header SET idfuncionario_trans = '$usuario', id_estadoinforme = '4' WHERE id_informe = '$idInforme'", $cn);
			//registrar detalles del informe (transcripcion)
			mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe' WHERE id_informe = '$idInforme'", $cn);
			//realizar una insersion en el log
			mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$usuario','4','$fecha','$hora')", $cn);
			if($observacionTranscripcion!="")
			{
				mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacionTranscripcion','$fecha', '$hora')", $cn);
			}
			echo '<script language="javascript">window.close();</script>';;
		}
	}	
?>
</body>