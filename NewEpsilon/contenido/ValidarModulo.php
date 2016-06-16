<?php
session_start();
	include("../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con POST
	$idusuario = $_SESSION[currentuser];
	
	$sql = mysql_query("SELECT idmodulo, idusuario FROM modulo_usuario WHERE idmodulo='$mod' AND idusuario='$idusuario'", $cn);
	$reg = mysql_num_rows($sql);
	
	if($reg==0 || $reg=="")
	{
		echo 
		'<script type="text/javascript">
			alert("Acceso denegado");
			window.location = "../../includes/main_menu.php";
		</script>';
	}
?>