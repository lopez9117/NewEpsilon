<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
session_start();
$CurrentUser = $_SESSION['currentuser'] ;
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracon de variables post
$grupoEmpleado = $_POST['grupoEmpleado'];
$sede = $_POST['sede'];
$mes = $_POST['mes'];
$anio = $_POST['anio'];
$servicio = $_POST['servicio'];
//Validar campos obligatorios dentro del formulario
if($grupoEmpleado=="" || $sede=="" || $mes=="" || $anio=="" || $CurrentUser=="" || $servicio=="")
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
	$fecha_inicio = $anio."-".$mes."-".'01';
	$fecha_limite = $anio."-".$mes."-".$dias;
	//consultar si hay funcionarios con turnos en los datos ingresados en la consulta
	$consFuncionarios = mysql_query("SELECT DISTINCT idfuncionario FROM turno_funcionario WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_limite' AND idsede = '$sede' AND idgrupo_empleado = '$grupoEmpleado' AND idservicio = '$servicio'", $cn);
	$regsFuncionarios = mysql_num_rows($consFuncionarios);
	
	if($regsFuncionarios==0 || $regsFuncionarios=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">No se encontraron datos asociados con la consulta</font></td>
		</tr>
		</table>';
	}
	else
	{
		echo '<script>window.open("CrearCuadroNovedades.php?grupoEmpleado='.base64_encode($grupoEmpleado).'&sede='.base64_encode($sede).'&mes='.base64_encode($mes).'&anio='.base64_encode($anio).'&servicio='.base64_encode($servicio).'")</script>';
	}
}
?>