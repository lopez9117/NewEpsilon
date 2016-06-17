<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
//registrar las variables para la sesion del usuario
session_start();
$_SESSION['usuario'];
$_SESSION['sede'];
if($_SESSION['usuario']=="" || $_SESSION['sede']=="")
{
	echo '<script language="javascript">
		window.location = "../../";
	</script>';
}
else
{
	$user = $_SESSION['usuario'];
	$sede = $_SESSION['sede'];
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10" />
    <title>.: RIS :. - &epsilon;psilon - Prodiagnostico S.A</title>
    </head>
    <frameset rows="35,*" frameborder="0" border="0" framespacing="0">
    <frame name="topNav" src="includes/MenuRisTop.php?sede=<?php echo $sede ?>&user=<?php echo $user ?>">
    <frameset cols="190,*" frameborder="0" border="0" framespacing="0">
    <frame name="menu" src="includes/MenuRis.php?sede=<?php echo $sede ?>&user=<?php echo $user ?>" marginheight="0" marginwidth="0" scrolling="auto" noresize>
    <frame name="content" src="Bienvenida.php?user=<?php echo $user ?>"" marginheight="0" marginwidth="0" scrolling="auto" noresize>
    </frameset>
    </frameset><noframes></noframes>
    </html>
<?php
}
?>