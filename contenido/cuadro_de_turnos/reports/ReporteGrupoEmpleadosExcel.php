<?php 
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
include('../ClassHoras.php');
include('../ClassFuncionario.php');
header("Cache-Control: no-cache");
header("Pragma: no-cache");
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$GrupoEmpleado = base64_decode($_GET['GrupoEmpleado']);
$FechaFinal = base64_decode($_GET['fecha_limite']);
$FechaInicio = base64_decode($_GET['fechaInicial']);
$anio = base64_decode($_GET['anio']);
$mes = base64_decode($_GET['mes']);
//Verificar si existen registros asociados con la busqueda
$sqlValidacion =  mysql_query("SELECT DISTINCT(idfuncionario) AS idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$FechaInicio' AND '$FechaFinal' AND idgrupo_empleado = '$GrupoEmpleado' ", $cn);
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
	body { font-family: Arial, Helvetica, sans-serif; font-size: small; }
	.table-fill { background: white; width: 100%; font-size: small; margin-top: 1%;}
	tr { border-top: 1px solid #C1C3D1; border-bottom-: 1px solid #C1C3D1; }
	tr:first-child { border-top:none; }
	tr:last-child {border-bottom:none; }
	tr:nth-child(odd)
	td { background:#EBEBEB; }
	td { background:#FFFFFF; }
	.text-center { text-align: center; background-color: #000066; }
</style>
<body>
<table border="1" rules="all" class="table-fill">
<thead>
    <tr>
        <th align="center" width="5%">Documento</th>
        <th align="center" width="20%">Funcionario</th>
        <th align="center" width="10%">Ciudad</th>
        <th align="center" width="6%">Diurnas Ordinarias</th>
        <th align="center" width="6%">Nocturnas Ordinarias</th>
        <th align="center" width="6%">Diurnas Festivas</th>
        <th align="center" width="6%">Nocturnas Festivas</th>
		<th align="center" width="6%">Total por Turnos</th>
        <th align="center" width="6%">Laborables Mes</th>
        <th align="center" width="6%">Diurna Ordinaria Adicional</th>
        <th align="center" width="6%">Nocturna Ordinaria Adicional</th>
        <th align="center" width="6%">Diurna Festiva Adicional</th>
        <th align="center" width="6%">Nocturna Festiva Adicional</th>
        <th align="center" width="6%">Total por Novedades</th>
		<th align="center" width="6%">Disponibilidades</th>
		<th align="center" width="6%">Dias de vacaciones</th>
    </tr>
</thead>
<tbody>
<?php
	while($RowFuncionario = mysql_fetch_array($sqlValidacion))
	{
		$idFuncionario = $RowFuncionario['idfuncionario'];
		$InfFuncionnario = funcionario::GetNombresApellidos($cn, $idFuncionario);
		echo
		'<tr align="center">
			<td>'.$idFuncionario.'</td>
			<td>'.ucwords(strtolower($InfFuncionnario['nombres'])).' '.ucwords(strtolower($InfFuncionnario['apellidos'])).'</td>
			<td>'.ucwords(strtolower($InfFuncionnario['nombre_mun'])).'</td>';
			echo Horas::SumatoriaHoras($cn, $mes, $anio, $idFuncionario);
			echo' <td>'.Horas::GetHorasMes($cn, $mes, $anio).'</td>';
			echo Horas::SumatoriaHorasAdicionales($cn, $mes, $anio, $idFuncionario);
			echo '<td>'.Horas::GetDisponibilidades($idFuncionario, $FechaInicio, $FechaFinal, $cn ).'</td>
			<td>'.Horas::GetVacaciones($idFuncionario, $FechaInicio, $FechaFinal, $cn ).'</td>
		</tr>';
	}
?>
<tbody>
</table>
</body>
</html>