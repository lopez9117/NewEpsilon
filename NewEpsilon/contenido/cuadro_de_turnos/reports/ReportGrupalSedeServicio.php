<?php
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	//traer las variables con POST
	$grupoEmpleado = $_POST['GrupoEmpleado'];
	$mes = $_POST['mes'];
	$anio = $_POST['anio'];
	//$servicio = $_POST[servicio];
	$sede = $_POST['sede'];
	//Validar los campos requeridos del formulario
	if($sede=="" || $grupoEmpleado=="" || $mes == "" || $anio=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">Los campos señalados con * son obligatorios</font></td>
		</tr>
		</table>';
	}	
	else
	{
		//desglosar fecha para obtener la cantidad de dias que tiene el mes
		$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
		//dia finalizacion del mes
		$fecha_limite = $anio."-".$mes."-".$dias;
		//variable para iniciar la fecha
		$fechaInicial = ($anio.'-'.$mes.'-'.'01');
		//Verificar si existen registros asociados con la busqueda
		$sqlValidacion =  mysql_query("SELECT DISTINCT idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicial' AND '$fecha_limite' AND idgrupo_empleado = '$grupoEmpleado' AND idsede = '$sede'", $cn);
		$resValidacion = mysql_num_rows($sqlValidacion);
		
		if($resValidacion == 0 || $resValidacion =="")
		{
			echo 
			'<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			<td><font color="#FF0000" size="2">No se encontraron registros asociados con la busqueda</font></td>
			</tr>
			</table>';
		}
		else
		{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reporte de funcionarios :.</title>
</head>
<body>
<br>
<table width="100%">
  <tr>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>N° Documento</strong></td>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>Nombres</strong></td>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>Diurna Ordinaria</strong></td>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>Nocturna Ordinaria</strong></td>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>Diurna Festiva</strong></td>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>Nocturna Festiva</strong></td>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>Total</strong></td>
    <td style="background-color:#66C; color:#FFF;" align="center"><strong>Ver detalles</strong></td>
  </tr>
  <?php
  	while($rowFuncionario = mysql_fetch_array($sqlValidacion))
	{
		$idFuncionario = $rowFuncionario['idfuncionario'];
		
		$sql = mysql_query("SELECT nombres, apellidos FROM funcionario WHERE idfuncionario = '$idFuncionario'", $cn);
		$res = mysql_fetch_array($sql);
		
		$sqlHora = mysql_query("SELECT SUM(diurna) AS diurna, SUM(diurnafest) AS diurnafest, SUM(nocturna) AS nocturna, SUM(nocturnafest) AS nocturnafest, SUM(diurna+diurnafest+nocturna+nocturnafest) AS total FROM turno_funcionario WHERE idfuncionario = '$idFuncionario' AND fecha BETWEEN '$fechaInicial' AND '$fecha_limite'", $cn);
		$resHora = mysql_fetch_array($sqlHora);
		
		$nombre = $res['nombres'].'&nbsp;'.$res['apellidos'];
		
		echo '<tr>
				<td align="center">'.$idFuncionario.'</td>
				<td align="center">'.$res['nombres'].'&nbsp;'.$res['apellidos'].'</td>
				<td align="center">'.$resHora['diurna'].'</td>
				<td align="center">'.$resHora['nocturna'].'</td>
				<td align="center">'.$resHora['diurnafest'].'</td>
				<td align="center">'.$resHora['nocturnafest'].'</td>
				<td align="center">'.$resHora['total'].'</td>
				<td align="center"><a target="_blank" href="reports/ReporteIndividual.php?document='.$idFuncionario.'&fchstart='.$fechaInicial.'&fchstop='.$fecha_limite.'&nomb='.$nombre.'"><img src="../../images/viewmag+.png" width="20" height="20" alt="'.$res['nombres'].'&nbsp;'.$res['apellidos'].'" title="'.$res['nombres'].'&nbsp;'.$res['apellidos'].'" /></a></td>
			  </tr>';
	}
  ?>
  </table>
</body>
</html>
<?php
		}
	}
?>