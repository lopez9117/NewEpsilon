<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include("../../../../dbconexion/conexion.php");
$cn = Conectarse();
$observacion = $_POST['observacion'];
$usuario = $_POST['usuario'];
$idinforme = $_POST['informe'];
$motivo = $_POST['motivo'];

mysql_query("DELETE FROM r_log_informe WHERE id_estadoinforme BETWEEN '2' AND '9' AND id_informe = '$idinforme'", $cn);
mysql_query("UPDATE r_informe_header SET id_estadoinforme = '9', idfuncionario_esp = '0' WHERE id_informe = '$idinforme'", $cn);
mysql_query("INSERT INTO r_log_informe VALUES('$idinforme', '$usuario' ,'9', CURDATE(), CURTIME())", $cn);
mysql_query("INSERT INTO r_estudiodevuelto VALUES('$idinforme', '$usuario', NOW(), '$motivo', '$observacion')", $cn);

echo '<script language="javascript">
	setTimeout(window.close, 5000)
</script>';
mysql_close($cn);
?>