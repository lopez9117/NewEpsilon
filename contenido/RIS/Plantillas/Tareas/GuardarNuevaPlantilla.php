<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con POST
	$Plantilla = $_POST['Plantilla'];
	$servicio = $_POST['servicio'];
	$especialista = $_POST['especialista'];
	$estudio = $_POST['estudio'];
	$tecnica = $_POST['tecnica'];
	//consultar que la plantilla no se registre mas de una vez
	$sql = mysql_query("SELECT * FROM r_plantilla WHERE idfuncionario_esp = '$especialista' AND idestudio = '$estudio' AND id_tecnica = '$tecnica' AND idservicio = '$servicio'", $cn);
	$con = mysql_num_rows($sql);
	
	if($con>=1)
	{
		 echo '<table width="100%" align="center" style="margin-top:20%;"><tr><td><font color="#FF0000" size="+6">No se pudo registrar el contenido de la plantilla</font></td></tr></table>';
	}
	else
	{
		mysql_query("INSERT INTO r_plantilla VALUES('','$especialista','$estudio','$tecnica','$servicio','$Plantilla')", $cn);
		echo '<script language="javascript">window.close();</script>';
	}
?>