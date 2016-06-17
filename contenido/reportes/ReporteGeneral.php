<?php
	//conexion a la base de datos
	require_once("../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables POST
	$fechaInicio = '2013-08-01' ;
	$fechaStop = '2013-08-31' ;
	
	$sql = mysql_query("SELECT DISTINCT idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicio' AND '$fechaStop'", $cn);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reporte General :.</title>
</head>
<body>
<table width="90%" border="1" rules="all" align="center">
  <tr>
    <td>Cedula</td>
    <td>Apellidos / Nombres</td>
    <td>Cargo</td>
    <td>Seccion</td>
    <td>Sede</td>
    <td>Salario</td>
  </tr>
  <?php
  	while($row = mysql_fetch_array($sql))
	{
		$docFuncionario = $row[idfuncionario];
		
		$sqlDatos = mysql_query("SELECT f.nombres, f.apellidos, f.salario, g.desc_grupoempleado, t.desctipo_cargo FROM funcionario f
INNER JOIN grupo_empleado g ON g.idgrupo_empleado = f.idgrupo_empleado
INNER JOIN tipo_cargo t ON t.idtipo_cargo = f.idtipo_cargo
WHERE f.idfuncionario = '$docFuncionario'", $cn);
$regDatos = mysql_fetch_array($sqlDatos);
  echo 
  '<tr>
    <td>'.$docFuncionario.'</td>
    <td>'.$regDatos[apellidos].'&nbsp;'.$regDatos[nombres].'</td>
    <td>'.$regDatos[desc_grupoempleado].'</td>
    <td>'.$regDatos[desctipo_cargo].'</td>
    <td>&nbsp;</td>
	<td>'.$regDatos[salario].'</td>
  </tr>';
  	}
  ?>
</table>
</body>
</html>