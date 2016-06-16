<?php
	$user = base64_decode($_GET['user']);
	$sede = base64_decode($_GET['sede']);
	
	session_start();
	$_SESSION['usuario'] = $user;
	$_SESSION['sede'] = $sede;
	
	if($_SESSION['usuario']=="" || $_SESSION['sede']=="")
	{
		unset($_SESSION['usuario']);
		unset($_SESSION['sede']); 
		
		echo '<script language="javascript">
			parent.parent.window.close();
		</script>';
	}
	else
	{
		echo '<script language="javascript">
		window.location = "Home.php";
		</script>';
	}
?>
