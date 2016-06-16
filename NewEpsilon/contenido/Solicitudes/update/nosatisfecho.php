<body onBeforeUnload="return window.opener.cargardiv()">
<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();

$idSolicitud = $_POST['idsolicitud'];
$porque = $_POST['porque'];
$sql = mysql_query("UPDATE solicitud SET idsatisfaccion ='2' WHERE idsolicitud='$idSolicitud'", $cn);
$sql = mysql_query("UPDATE solicitud SET porque ='$porque' WHERE idsolicitud='$idSolicitud'", $cn);

echo '<script type="text/javascript">
					window.close();
					</script>';
?>
</body>