<?php
session_start();
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$sede = $_GET['sede'];
$mes = $_GET['mes'];
$anio = $_GET['anio'];
$grupo_empleado = $_GET['grupoEmpleado'];
$servicio = $_GET['servicio'];
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=CuadrodeTurnos.xls");
header("Pragma: no-cache");
header("Expires: 0");
//Conexion a la base de datos
$fechaInicial = $anio.'-'.$mes.'-'.'01';
$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
//dia finalizacion del mes
$fecha_limite = $anio."-".$mes."-".$dias;
//consulta
$sqlDesc = mysql_query("SELECT desc_grupoempleado FROM grupo_empleado WHERE idgrupo_empleado = '$grupoEmpleado'", $cn);
$regDesc = mysql_fetch_array($sqlDesc);

$sqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede = '$sede'", $cn);
$regSede = mysql_fetch_array($sqlSede);

$sqlServicio = mysql_query("SELECT descservicio FROM servicio WHERE idservicio = '$servicio'", $cn);
$regServicio = mysql_fetch_array($sqlServicio);

//validar que se elija por lo menos un funcionario
$fecha_inicio = $anio."-".$mes."-".'01';
//consultar si hay funcionarios con turnos en los datos ingresados en la consulta
$consFuncionarios = mysql_query("SELECT DISTINCT idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_limite' AND idsede = '$sede' AND idgrupo_empleado = '$grupoEmpleado' AND idservicio = '$servicio'", $cn);
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>.: Cuadro Novedades :. - Prodiagnostico S.A</title>
	<script type="text/javascript" src="http://gettopup.com/releases/latest/top_up-min.js"></script>
	<link type='text/css' href='../../css/cuadroTurnos.css' rel='stylesheet' media='screen' />
	<script src="../../js/ajax.js" type="text/javascript"></script>
	</head>
	<body>
	<table width="100%" id="table">
	  <tr>
		<td colspan="32"><strong>Cuadro de turnos para :</strong> <?php echo $regDesc['desc_grupoempleado'] ?> <strong>en la sede :</strong> <?php echo $regSede['descsede'] ?> <strong>y servicio de</strong> <?php echo $regServicio['descservicio'] ?> <strong>Desde :</strong> <?php echo $anio.'-'.$mes.'-'.'01' ?> <strong>Hasta :</strong> <?php echo $fecha_limite;?></td>
	  </tr>
	</table>
	<br><div id="respuesta"></div>
	<!-- Tabla donde se van a mostrar los funcionarios y los turnos -->
	<div id="cuadro">
	<table border="1" rules="all" width="100%" cellpadding="3">
		<tr>
			<td colspan="3" bgcolor="#E0F8F7" width="6%" id="table" align="center">FUNCIONARIO</td>
	<?php
	//ciclo para incrementar los dias del mes
	for($d=1;$d<=$dias; $d=$d+1)
	{
		//funcion para conocer a que dia de la semana corresponde la fecha generada
		$wkdy = (((mktime ( 0, 0, 0, $mes, $d, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
		if($wkdy == 0)
		{
			$dia_semana = 'L';
		}
		elseif ($wkdy == 1)
		{
			$dia_semana = 'M';
		}
		elseif ($wkdy == 2)
		{
			$dia_semana = 'W';
		}
		elseif ($wkdy == 3)
		{
			$dia_semana = 'J';
		}
		elseif ($wkdy == 4)
		{
			$dia_semana = 'V';
		}
		elseif ($wkdy == 5)
		{
			$dia_semana = 'S';
		}
		elseif ($wkdy == 6)
		{
			$dia_semana = 'D';
		}
		//a los dias menores o iguales a 9 los concateno con 0 para obtener una fecha valida y comparable
		if($d>=1 && $d<=9)
		{
			echo '<td bgcolor="#E0F8F7" width="2%" align="center" id="table">'.$dia_semana."<br>"."0".$d.'</td>';
		}
		//sino los dias obtienen el valor arrojado por el ciclo
		else
		{
			echo '<td bgcolor="#E0F8F7" width="2%" align="center" id="table">'.$dia_semana."<br>".$d.'</td>';
		}
	}
	?>
	</tr>
	<?php
	//foreach($_POST[id] as $idFuncionario)
	while($rowFuncionario = mysql_fetch_array($consFuncionarios))
	{		
		$idFuncionario = $rowFuncionario['idfuncionario'];
	//consultar listado de funcionarios relacionadoe en el grupo de empleados.
	$ListaFuncionarios = mysql_query("SELECT idfuncionario, nombres, apellidos FROM funcionario WHERE idfuncionario = '$idFuncionario'", $cn);
	$row = mysql_fetch_array($ListaFuncionarios);
	$documento = $row['idfuncionario'];
	echo '<tr>
		<td colspan="3" align="left" id="table">'.ucwords($row['apellidos']).ucwords($row['nombres']).'</td>';
		for($d=1;$d<=$dias; $d=$d+1)
		{
			//funcion para conocer a que dia de la semana corresponde la fecha generada
			$wkdy = (((mktime ( 0, 0, 0, $mes, $d, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
			//si los dias son menores o iguales a 9 los concateno con cero para obtener una fecha valida y comparable
			if($d>=1 && $d<=9 )
			{
				$fecha = ($anio.$mes.$d);
				$fechaCons = ($anio.'-'.$mes.'-'.'0'.$d);
				//si la vaiable $wkdy es igual a 6 equivale a domingo y se pintara la casilla de otro color
				if($wkdy==6)
				{
					$tipo = 2;
					//consultar si hay un turno registrado en la fecha
					$consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede' AND t.idservicio = '$servicio'", $cn);
					$respTurno = mysql_num_rows($consTurno);
					$regsTurno = mysql_fetch_array($consTurno);
					if($respTurno>=1)
					{
						echo '<td align="center" id="table"> '.$regsTurno['alias'].'</td>';
					}
					else
					{
						echo '<td align="center" id="table">&nbsp;</td>';
					}
				}
				else
				{
					//consultar si la variable equivale a un dia festivo
					$sqlFecha = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$fechaCons'", $cn);
					$conFecha = mysql_num_rows($sqlFecha);
					//si la fecha equivale a festivo aparecera de otro color
					if($conFecha>=1)
					{
						$tipo = 2;
						//consultar si hay un turno registrado en la fecha
						$consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede' AND t.idservicio = '$servicio'", $cn);
						$respTurno = mysql_num_rows($consTurno);
						$regsTurno = mysql_fetch_array($consTurno);
						if($respTurno>=1)
						{
							echo '<td align="center" id="table">'.$regsTurno['alias'].'</td>';
						}
						else
						{
						echo '<td align="center" id="table">&nbsp;</td>';
						}
					}
					else
					{
						$tipo = 1;
						//consultar si hay un turno registrado en la fecha
						$consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede' AND t.idservicio = '$servicio'", $cn);
						$respTurno = mysql_num_rows($consTurno);
						$regsTurno = mysql_fetch_array($consTurno);
						if($respTurno>=1)
						{
							echo '<td align="center">'.$regsTurno['alias'].'</td>';	
						}
						else
						{
							echo '<td align="center">&nbsp;</td>';
						}
					}
				}
			}
			//si los dias arrojados por el ciclo son mayores a 9 obtienen el valor que les asigna el ciclo
			else
			{
				$fecha = $anio.$mes.$d;
				$fechaCons = ($anio.'-'.$mes.'-'.$d);
				//si la variable $wkdy es igual a 6 equivale a domingo y se pintara la casilla de otro color
				if($wkdy==6)
				{
					$tipo = 2;
					//consultar si hay un turno registrado en la fecha
					$consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede' AND t.idservicio = '$servicio'", $cn);
					$respTurno = mysql_num_rows($consTurno);
					$regsTurno = mysql_fetch_array($consTurno);
					if($respTurno>=1)
					{
						echo '<td align="center" id="table">'.$regsTurno['alias'].'</td>';
					}
					else
					{
						echo '<td align="center" id="table">&nbsp;</td>';
					}
				}
				//sino el color de fondo sera blanco
				else
				{
					//consultar si la variable equivale a un dia festivo
					$sqlFecha = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$fechaCons'", $cn);
					$conFecha = mysql_num_rows($sqlFecha);
					//si la fecha equivale a festivo aparecera de otro color
					if($conFecha>=1)
					{
						$tipo = 2;
						//consultar si hay un turno registrado en la fecha
						$consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede' AND t.idservicio = '$servicio'", $cn);
						$respTurno = mysql_num_rows($consTurno);
						$regsTurno = mysql_fetch_array($consTurno);
						if($respTurno>=1)
						{
							echo '<td align="center" id="table">'.$regsTurno['alias'].'</td>';	
						}
						else
						{
							echo '<td align="center" id="table">&nbsp;</td>';
						}
					}
					else
					{
						$tipo = 1;
						//consultar si hay un turno registrado en la fecha
						$consTurno = mysql_query("SELECT c.alias, t.idturno FROM convencion_cuadro c
INNER JOIN turno_funcionario t ON t.idConvencion = c.id WHERE t.fecha = '$fechaCons' AND t.idfuncionario = '$documento' AND t.idsede = '$sede' AND t.idservicio = '$servicio'", $cn);
						$respTurno = mysql_num_rows($consTurno);
						$regsTurno = mysql_fetch_array($consTurno);
						if($respTurno>=1)
						{
							echo '<td align="center">'.$regsTurno['alias'].'</td>';
						}
						else
						{
							echo '<td align="center"></td>';
						}
					}
				}
			}
		}
	}
?>
</table>
<br>
<table width="100%" border="1" rules="all">
  <tr>
	<td style="background-color:#66C; color:#FFF;" align="center">Convencion</td>
	<td style="background-color:#66C; color:#FFF;" align="center">Hr.Inicio / Hr.Final</td>
  </tr>
  <?php
	//Consultar las convenciones disponibles para un funcionario
	$sqlConvenciones = mysql_query("SELECT DISTINCT idConvencion FROM turno_funcionario WHERE idgrupo_empleado = '$grupo_empleado' AND fecha BETWEEN '$fechaInicial' AND '$fecha_limite' AND idConvencion != 0 AND idservicio = '$servicio'", $cn);
	while($rowConvencion = mysql_fetch_array($sqlConvenciones))
	{
		$idConvencion = $rowConvencion['idConvencion'];
		//consultar datos de la convencion
		$consConvencion = mysql_query("SELECT alias, hr_inicio, hr_fin FROM convencion_cuadro WHERE id = '$idConvencion'", $cn);
		$regConvencion = mysql_fetch_array($consConvencion);
		echo 
		'<tr>
			<td align="center">'.$regConvencion['alias'].'</td>
			<td align="center">'.$regConvencion['hr_inicio'].'&nbsp;/&nbsp;'.$regConvencion['hr_fin'].'</td>
		 </tr>';
	}
  ?>
</table>
</div>
</body>
</html>