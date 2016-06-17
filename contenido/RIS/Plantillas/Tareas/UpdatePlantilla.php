<?php
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con POST
	$Plantilla = $_POST['contenido'];
	$servicio = $_POST['servicio'];
	$idPlantilla = $_POST['idPlantilla'];
	$estudio = $_POST['estudio'];
	$tecnica = $_POST['tecnica'];
	//consulta
	mysql_query("UPDATE r_plantilla SET idestudio = '$estudio', id_tecnica = '$tecnica', idservicio = '$servicio', contenido = '$Plantilla' WHERE idplantilla = '$idPlantilla'", $cn);
	echo '<script language="javascript">
		location.href = "EditarPlantilla.php?idPlantilla='.base64_encode($idPlantilla).'";
	</script>';
?>