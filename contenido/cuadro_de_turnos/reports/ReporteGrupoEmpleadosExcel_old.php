<?php 
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$GrupoEmpleado = base64_decode($_GET['GrupoEmpleado']);
$fecha_limite = base64_decode($_GET['fecha_limite']);
$fechaInicial = base64_decode($_GET['fechaInicial']);
$anio = base64_decode($_GET['anio']);
$mes = base64_decode($_GET['mes']);
//consultar horas laborables mes
$sqlLab = mysql_query("SELECT cant_horas FROM hora_mensual WHERE mes = '$mes' AND anio = '$anio'", $cn);
$resLab = mysql_fetch_array($sqlLab);
//Verificar si existen registros asociados con la busqueda
$sqlValidacion =  mysql_query("SELECT DISTINCT idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicial' AND '$fecha_limite' AND idgrupo_empleado = '$GrupoEmpleado'", $cn);
$resValidacion = mysql_num_rows($sqlValidacion);

header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=ReportGrupoEmpleados.xls");

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
        <th align="center" width="10%">Ciudad</th>
        <th align="center" width="6%">Diurnas Ordinarias</th>
        <th align="center" width="6%">Nocturnas Ordinarias</th>
        <th align="center" width="6%">Diurnas Festivas</th>
        <th align="center" width="6%">Nocturnas Festivas</th>
        <th align="center" width="6%">Laborables Mes</th>
        <th align="center" width="6%">Total por Turnos</th>
        <th align="center" width="6%">Diurna Ordinaria Adicional</th>
        <th align="center" width="6%">Nocturna Ordinaria Adicional</th>
        <th align="center" width="6%">Diurna Festiva Adicional</th>
        <th align="center" width="6%">Nocturna Festiva Adicional</th>
        <th align="center" width="6%">Total por Novedades</th>
    </tr>
</thead>
  <tbody>
    <?php
   while($rowFuncionario = mysql_fetch_array($sqlValidacion))
	{	
		$idFuncionario = $rowFuncionario['idfuncionario'];
		//consultar datos de funcionario
		$sql = mysql_query("SELECT f.nombres, f.apellidos, m.nombre_mun  FROM funcionario f
INNER JOIN r_municipio m ON m.cod_mun = f.cod_mun
WHERE idfuncionario = '$idFuncionario'", $cn);
$res = mysql_fetch_array($sql);
		//consultar cantidad de horas en los turnos
		$sqlHora = mysql_query("SELECT SUM(diurna) AS diurna, SUM(nocturna) AS nocturna, SUM(diurnafest) AS diurnafest, SUM(nocturnafest) AS nocturnafest, SUM(diurna+nocturna+diurnafest+nocturnafest) AS total
		FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicial' AND '$fecha_limite' AND idfuncionario='$idFuncionario'", $cn);
		$resHora = mysql_fetch_array($sqlHora);
		//consultar horas adicionales
		$conAdd = mysql_query("SELECT n.diurnas_adicionales, n.nocturnas_adicionales, n.diurfest_adicionales, n.nocfest_adicionales
FROM novedad_turno n INNER JOIN turno_funcionario t ON t.idturno = n.idturno
WHERE t.idfuncionario = '$idFuncionario' AND t.fecha BETWEEN '$fechaInicial' AND '$fecha_limite'", $cn);
		$rows = mysql_num_rows($conAdd);
		//sumar cantidades dentro de un ciclo
		$diurfest_adicionales = 0;
		$nocfest_adicionales = 0;
		$diurnas_adicionales = 0;
		$nocturnas_adicionales = 0;
	
		for($i=0; $i<$rows; $i++)
		{
			$ver = mysql_fetch_array($conAdd);
			$diurfest_adicionales = $diurfest_adicionales + $ver['diurfest_adicionales'];
			$nocfest_adicionales = $nocfest_adicionales + $ver['nocfest_adicionales'];
			$diurnas_adicionales = $diurnas_adicionales + $ver['diurnas_adicionales'];
			$nocturnas_adicionales = $nocturnas_adicionales + $ver['nocturnas_adicionales'];
		}
		//imprimir resultados
		echo '<tr>
				<td align="left">'.$idFuncionario.'</td>
				<td align="left">'.$res['nombres'].''.$res['apellidos'].'</td>
				<td align="left">'.$res['nombre_mun'].'</td>
				<td align="left">'.round($resHora['diurna'], 2).'</td>
				<td align="left">'.round($resHora['nocturna'], 2).'</td>
				<td align="left">'.round($resHora['diurnafest'], 2).'</td>
				<td align="left">'.round($resHora['nocturnafest'], 2).'</td>
				<td align="left">'.round($resLab['cant_horas'], 2).'</td>
				<td align="left">'.round($resHora['total'], 2).'</td>
				<td>'.round($diurnas_adicionales, 2).'</td>
				<td>'.round($nocturnas_adicionales, 2).'</td>
				<td>'.round($diurfest_adicionales, 2).'</td>
				<td>'.round($nocfest_adicionales, 2).'</td>
				<td>'.round($totalNovedad = $diurfest_adicionales + $nocfest_adicionales + $diurnas_adicionales + $nocturnas_adicionales, 2).'</td>
			  </tr>';
	}
    ?>
<tbody>
</table>
</body>
</html>