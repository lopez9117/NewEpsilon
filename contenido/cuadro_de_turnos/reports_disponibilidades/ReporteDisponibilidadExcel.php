<?php 
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$fecha_limite = base64_decode($_GET['fecha_limite']);
$fechaInicial = base64_decode($_GET['fechaInicial']);
$anio = base64_decode($_GET['anio']);
$mes = base64_decode($_GET['mes']);
//Verificar si existen registros asociados con la busqueda
$sqlDisponibilidad = mysql_query("SELECT DISTINCT(d.idfuncionario) AS idfuncionario, CONCAT(f.nombres,' ',f.apellidos) AS nombre
FROM ct_disponibilidad_funcionario d
INNER JOIN funcionario f ON f.idfuncionario = d.idfuncionario WHERE fecha BETWEEN '$fechaInicial' AND '$fecha_limite'", $cn);

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=ReportDisponibilidadesEmpleados.xls");

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta http-equiv=Content-Type content="text/html; charset=ISO-8859-1">
<title>Prodiagnostico S.A</title>
</head>
<style type="text/css">
body{font-family:Verdana, Geneva, sans-serif;
font-size:10px;
}
</style>
<body>
<table border="1" rules="all">
<thead>
    <tr style="background-color:#09F; color:#FFF">
        <th align="center" width="5%">Documento</th>
        <th align="center" width="20%">Funcionario</th>
        <th align="center" width="10%">Dias disponible</th>
        <th align="center" width="6%">Cantidad de disponibilidades</th>
    </tr>
</thead>
  <tbody>
    <?php
  		while($rowDisponibilidad = mysql_fetch_array($sqlDisponibilidad))
		{
			$funcionario = $rowDisponibilidad['idfuncionario'];
			$nombre = $rowDisponibilidad['nombre'];
			//consultar los detalles de cada funcionario
			$cons = mysql_query("SELECT COUNT(fecha) AS cantidadDisponibilidad FROM ct_disponibilidad_funcionario
			WHERE idfuncionario = '$funcionario' AND fecha BETWEEN '$fechaInicial' AND '$fecha_limite'", $cn);
			$regs = mysql_fetch_array($cons);
			echo 
			'<tr>
				<td>'.$funcionario.'</td>
				<td>'.$nombre.'</td>
				<td>'.$regs['cantidadDisponibilidad'].'</td>
				<td>'.round(($regs['cantidadDisponibilidad']/7), 1).'</td>
			</tr>';
		}
    ?>
<tbody>
</table>
</body>
</html>