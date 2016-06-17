<?php
////conexion a la BD
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
////Declaracion de variables
$est_actual = $_POST['est_actual'];
$est_devolulcion = $_POST['est_devolulcion'];
$idInforme = $_POST['idInforme'];
$usuario = $_POST['usuario'];
$observacion = trim($_POST['observacion']);
$fecha = date("Y-m-d");
$hora = date("G:i:s");
//registrar el comentario
mysql_query("INSERT INTO r_observacion_informe VALUES ('$idInforme', '$usuario', '$observacion', '$fecha', '$hora', '6')", $cn);
//validar el estado a donde sera devuelto el estudio
if($est_devolulcion<3)
{
	//dejar vacia la lectura si ya se ha registrado
	mysql_query("UPDATE r_detalle_informe SET detalle_informe = '' WHERE id_informe = '$idInforme'", $cn);
	//modificar el encabezado para que conicida con el estado del log
	mysql_query("UPDATE r_informe_header SET id_estadoinforme = '$est_devolulcion', idfuncionario_esp = '' WHERE id_informe = '$idInforme'", $cn);
	//eliminar estado del log
	for($var = $est_devolulcion+1; $var <= $est_actual; $var = $var+1)
	{
		//eliminar del log los estados arrojados por el ciclo
		mysql_query("DELETE FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '$var'", $cn);
	}
	echo 
		'<script language="javascript">
			setTimeout(window.close, 3000);
		</script>';
}
else
{
	//modificar el encabezado para que conicida con el estado del log
	mysql_query("UPDATE r_informe_header SET id_estadoinforme = '$est_devolulcion' WHERE id_informe = '$idInforme'", $cn);
	//eliminar estado del log
	for($var = $est_devolulcion+1; $var <= $est_actual; $var = $var+1)
	{
		//eliminar del log los estados arrojados por el ciclo
		mysql_query("DELETE FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '$var'", $cn);
	}
	echo 
		'<script language="javascript">
			setTimeout(window.close, 3000);
		</script>';
}
mysql_close($cn);
?>
<title>.: Guardando Cambios :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.consultar();">
<table width="50%" border="0" align="center" style="margin-top:20%;">
  <tr>
    <td><img src="../styles/images/MnyxU.gif" width="64" height="64" />
    </td>
    <td>
    	<strong><h3>Guardando los cambios, por favor espere...</h3></strong>
    </td>
  </tr>
</table>
</body>