<body onBeforeUnload="return window.opener.CargarAgenda()">
<?php
//conexion a la base de datos
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
//variables con POST
$especialista = $_POST['especialista'];
$idInforme = $_POST['idInforme'];
$ResultadoInforme = $_POST['ResultadoInforme'];
$adicional = $_POST['adicional'];
$observacionTranscripcion = $_POST['observacionTranscripcion'];
$opcion = $_POST['opcion'];
$tipoResultado = $_POST['tipoResultado'];
//variables del sistema
$fecha = date("Y-m-d");
$hora = date("G:i:s");
//******************************************************************************************************************//
if($opcion=="parcial")
{
	//valida si el registro existe en la tabla de BD
	$cont = mysql_query("SELECT id_informe FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn)or echoerror(mysql_error(),1);
	$resp = mysql_num_rows($cont);
	if($resp>=1)
	{
		//actualizar contenido
		mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$ResultadoInforme', adicional = '$adicional', id_tipo_resultado = '$tipoResultado' WHERE id_informe = '$idInforme'", $cn)or echoerror(mysql_error(),2);
	}
	else
	{
		//insertar en base de datos
		mysql_query("INSERT INTO r_detalle_informe(id_informe, detalle_informe, adicional, id_tipo_resultado) VALUES ('$idInforme','$ResultadoInforme','$adicional','$tipoResultado')", $cn)or echoerror(mysql_error(),3);
	}
	//vector que contiene los valores a registrar
	$valores = array('3','4');
	$cont = 0;
	foreach($valores as $value)
	{
		//consultar para evitar hacer una insersion doble
		$consulta = mysql_query("SELECT id_informe,id_estadoinforme FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '$value'", $cn)or echoerror(mysql_error(),4);
		$registro = mysql_num_rows($consulta);
		//validar contando los registros
		if($registro=="" || $registro==0)
		{
			//realizar una insersion en el log
			mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$especialista','$value','$fecha','$hora')", $cn)or echoerror(mysql_error(),5);	
		}
	}
	//actualizar los datos en el header del informe
	mysql_query("UPDATE r_informe_header SET idfuncionario_esp = '$especialista', idfuncionario_trans = '$especialista', id_estadoinforme = '4' WHERE id_informe = '$idInforme'", $cn)or echoerror(mysql_error(),6);
	echo '<script language="javascript">
		location.href = "../lectura/TranscribirAprobar.php?informe='.base64_encode($idInforme).'&especialista='.base64_encode($especialista).'";
		</script>';
}
elseif($opcion=="aprobar")
{
	//valida si el registro existe en la tabla de BD
	$cont = mysql_query("SELECT id_informe FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn)or echoerror(mysql_error(),7);
	$resp = mysql_num_rows($cont);
	if($resp>=1)
	{
		//actualizar contenido
		mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$ResultadoInforme', adicional = '$adicional', id_tipo_resultado = '$tipoResultado' WHERE id_informe = '$idInforme'", $cn)or echoerror(mysql_error(),8);
	}
	else
	{
		//insertar en base de datos
		mysql_query("INSERT INTO r_detalle_informe(id_informe, detalle_informe, adicional, id_tipo_resultado) VALUES ('$idInforme','$ResultadoInforme','$adicional','$tipoResultado')", $cn)or echoerror(mysql_error(),9);
	}
	//vector que contiene los valores a registrar
	$valores = array('3','4','5');
	$cont = 0;
	foreach($valores as $value)
	{
		//consultar para evitar hacer una insersion doble
		$consulta = mysql_query("SELECT id_informe,id_estadoinforme FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '$value'", $cn)or echoerror(mysql_error(),10);
		$registro = mysql_num_rows($consulta);
		//validar contando los registros
		if($registro=="" || $registro==0)
		{
			//realizar una insersion en el log
			mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$especialista','$value','$fecha','$hora')", $cn)or echoerror(mysql_error(),11);	
		}
	}
	//actualizar los datos en el header del informe
	mysql_query("UPDATE r_informe_header SET idfuncionario_esp = '$especialista', idfuncionario_trans = '$especialista', id_estadoinforme = '5' WHERE id_informe = '$idInforme'", $cn)or echoerror(mysql_error(),12);

	echo '<script language="javascript">
				setTimeout(window.close, 2000)
			</script>';
	}
//borrar el estado de la ventana
mysql_query("DELETE FROM r_estadoventana WHERE id_informe = '$idInforme'", $cn)or echoerror(mysql_error(),13);
		
	function echoerror($er,$line)
	{
		echo $er.' '.$line;
		}
?>
</body>