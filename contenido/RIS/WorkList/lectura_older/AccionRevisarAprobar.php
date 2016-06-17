<?php 
//archivo de conexion
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$informe = $_POST['ResultadoInforme'];
$idInforme = $_POST['idInforme'];
$adicional = $_POST['adicional'];
$observacion = $_POST['observacionTranscripcion'];
$usuario = $_POST['especialista'];
$opcion = $_POST['opcion'];
$tipoResultado = $_POST['tipoResultado'];
$sdate = date("Y-m-d");
$stime = date("G:i:s");
$tipo = $_POST['tipo'];
//validar ingreso de observacion
if($observacion!="")
{
	mysql_query("INSERT INTO r_observacion_informe VALUES('$idInforme','$usuario','$observacion','$sdate', '$stime')", $cn);
}
if($opcion=="aprobar")
{
//modificar el contenido del informe
mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$ResultadoInforme', adicional = '$adicional', id_tipo_resultado = '$tipoResultado' WHERE id_informe = '$idInforme'", $cn);
//validar que no se haga mas de una vez el registro
$con = mysql_query("SELECT l.id_estadoinforme, i.id_estadoinforme FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe WHERE
i.id_estadoinforme = '5' AND l.id_estadoinforme = '5' AND l.id_informe = '$idInforme' AND i.id_informe = '$idInforme'", $cn);
$reg = mysql_num_rows($con);
if($reg==0)
	{
		mysql_query("UPDATE r_informe_header SET id_estadoinforme = '5' WHERE id_informe = '$idInforme'", $cn);
		//insersion en el log del informe
		mysql_query("INSERT INTO r_log_informe (id_informe, idfuncionario, id_estadoinforme, fecha, hora) VALUES('$idInforme','$usuario','5','$sdate','$stime')", $cn);
		echo '<font color="#006600"><strong>Se realizo el Estudio Correctamente, por favor espere que se cierre la ventana</strong></font>';
		echo '<script language="javascript">setTimeout(window.close, 2000)</script>';
	}
}

elseif($opcion=="parcial")
{
	//modificar el contenido del informe
	mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$ResultadoInforme', adicional = '$adicional', id_tipo_resultado = '$tipoResultado' WHERE id_informe = '$idInforme'", $cn);
	//redireccionar al informe
	echo '<script language="javascript">window.location.href="RevisarAprobar?informe='.base64_encode($idInforme).'&especialista='.base64_encode($usuario).'"</script>';
}
mysql_close($cn);
?>