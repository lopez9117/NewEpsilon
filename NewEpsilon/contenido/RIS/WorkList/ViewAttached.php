<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include("../../../dbconexion/conexion.php");
$cn = conectarse();
$Attached = base64_decode($_GET['Attached']);
$sql = mysql_query("SELECT adjunto FROM r_adjuntos WHERE id_adjunto = '$Attached'", $cn);
$reg = mysql_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10" />
<head>
<title>.: Adjunto :.</title>
</head>
<body>
<embed src="../formularios/Inserts/<?php echo $reg['adjunto']?>" width="100%" height="1000px" align="middle"></embed>
</body>
</html>