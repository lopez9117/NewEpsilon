<body onBeforeUnload="return window.opener.CargarAgenda(0);">
<?php
//conexion a la BD
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$observacion = $_POST['observacion'];
$usuario = $_POST['usuario'];
$idinforme = $_POST['informe'];
$motivo= $_POST['motivo'];
$fecha = date("Y-m-d");
$hora = date("G:i:s");
//eliminar en el log el estado 2
mysql_query("DELETE FROM r_log_informe WHERE id_informe = '$idinforme' AND id_estadoinforme = '2'", $cn);
//insertar el estado 9
mysql_query("INSERT INTO r_log_informe VALUES('$idinforme','$usuario','9','$fecha','$hora')", $cn);
//insertar en la tabla de motivo de cancelacion
mysql_query("INSERT INTO r_estudiodevuelto VALUES('$idinforme','$usuario','$fecha $hora','$motivo','$observacion')", $cn);
//modificar el header, estado 9
mysql_query("UPDATE r_informe_header SET id_estadoinforme = '9', idfuncionario_esp = '0' WHERE id_informe = '$idinforme'", $cn);
echo '<script language="javascript">
	window.close();
</script>';
mysql_close($cn);
?>
</body>