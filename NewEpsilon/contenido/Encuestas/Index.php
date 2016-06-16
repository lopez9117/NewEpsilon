<?php
//registrar las variables para la sesion del usuario
session_start();
$_SESSION['usuario_encuestas'] = $_GET['User'];
if($_SESSION['usuario_encuestas']=="")
{
	echo 
	'<script language="javascript">
		window.location = "../../";
	</script>';
}
else
{
	$user = $_SESSION['usuario_encuestas'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Encuestas de Satisfacción :. - &epsilon;psilon - Prodiagnostico S.A</title>
</head>
<frameset rows="35,*" frameborder="0" border="0" framespacing="0">
<frame name="topNav" src="includes/MenuTop.php">
<frameset cols="190,*" frameborder="0" border="0" framespacing="0">
<frame name="menu" src="includes/MenuLat.php" marginheight="0" marginwidth="0" scrolling="auto" noresize>
<frame name="content" src="Bienvenida.php" marginheight="0" marginwidth="0" scrolling="auto" noresize>
</frameset>
</frameset><noframes></noframes>
</html>
<?php
}
?>