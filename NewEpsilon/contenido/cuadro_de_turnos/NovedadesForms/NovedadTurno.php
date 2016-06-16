<?php 
	//conexion a la base de datos
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//declaracion de variables con post
	$idTurno = $_GET['idTurno'];
	
	//consultar datos acerca de la novedad
	$sql = mysql_query("SELECT * FROM novedad_turno WHERE idturno='$idTurno'", $cn);
	$con = mysql_num_rows($sql);
	$res = mysql_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
</br></br>
<?php
	if($con<=0)
	{
		echo '<table width="80%" border="1" align="center" rules="all">
		  <tr>
			<td colspan="3" align="center">Aun no se registrarón novedades en el turno.</td>
		  </tr>
		</table>';
	}
	else
	{
		$hrInicio = $res['hr_inicio'];
		$hrFin = $res['hr_fin'];
		$nota = $res['nota'];
		
		echo '<table width="80%" border="1" align="center" rules="all">
  <tr id="table">
    <td width="10%" align="center">Hr. Inicio</td>
    <td width="10%" align="center">Hr.Final</td>
    <td width="70%">Observaciones</td>
    <td width="10%" align="center">Tareas</td>
  </tr>
  <tr>
    <td align="center">'.$hrInicio.'</td>
    <td align="center">'.$hrFin.'</td>
    <td>'.$nota.'</td>
    <td align="center"><a onclick="EliminarNovedad('.$idTurno.')">Eliminar</a></td>
  </tr>
</table>';
	}
?>

</body>
</html>