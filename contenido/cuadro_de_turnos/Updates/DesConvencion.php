<?php

	//Conexion a la base de datos
	include("../../../dbconexion/conexion.php");
	$cn = Conectarse();;
	//Declaracion de variables con post
	$id = $_POST['id'];
	
	$sql = mysql_query("UPDATE convencion_cuadro SET idestado_actividad = 2  WHERE id = '$id'", $cn);
?>