<?php 
	//conexion a la BD
	require_once("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	
	$servicio = $_POST['servicio'];
	
	//consultar estudios
	$sql = mysql_query("SELECT idestudio, nom_estudio FROM r_estudio WHERE idservicio = '$servicio' ORDER BY nom_estudio ASC", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
Estudio:<br>
<label for="estudio"></label>
<select name="estudio" id="estudio">
<option value="">.: Seleccione un Estudio :.</option>
<?php
	while($row = mysql_fetch_array($sql))
	{
		echo '<option value="'.$row['idestudio'].'">'.$row['nom_estudio'].'</option>';
	}
?>
</select>
</body>
</html>