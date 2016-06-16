<?php 
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$desde = '2014-01-01';
$hasta = '2014-12-31';
//validar las sedes donde se realizaron encuestas
$conSede = mysql_query("SELECT DISTINCT(e.idsede), se.descsede FROM e_encuesta e
INNER JOIN sede se ON se.idsede = e.idsede
WHERE fecha BETWEEN '$desde' AND '$hasta'", $cn);
//crear array asociativo con los valores de los meses
$meses = array('01','02','03','04','05','06','07','08','09','10','11','12');
//ciclo 
while($rowSede = mysql_fetch_array($conSede))
{
	echo $rowSede['descsede'].'<br>';
	$idSede = $rowSede['idsede'];
	//construir rangos de fecha a partir del array
	foreach($meses as $mes)
	{
		$fechaInicio = '2014-'.$mes.'-01';
		$fechaFinal = '2014-'.$mes.'-31';
		//hacer consulta especifica por sede
		$consCantidades = mysql_query("SELECT COUNT(idencuesta) AS cantidad FROM e_encuesta WHERE idsede = '$idSede' AND fecha between '$fechaInicio' AND '$fechaFinal'", $cn);
		$RegsCantidades = mysql_fetch_array($consCantidades);
		echo $total = $RegsCantidades['cantidad'].'<br>'; 
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>