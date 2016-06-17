<?php
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables con POST
$horaInicio = $_POST['horaInicio'];
$horaFinalizacion = $_POST['horaFinalizacion'];
$alias = $_POST['alias'];
//validar campos vacios
if($horaInicio=="" || $horaFinalizacion=="" || $alias=="")
{
	echo '<font color="#FF0000">Los campos son obligatorios</font>';	
}
else
{
	//consultar si las horas asignadas existen dentro de la convencion
	$cons = mysql_query("SELECT * FROM convencion_cuadro WHERE idgrupo_empleado = '0' AND hr_inicio = '$horaInicio' AND hr_fin = '$horaFinalizacion'", $cn);
	$regs = mysql_num_rows($cons);
	if($regs>=1)
	{
		echo '<font color="#FF0000">Ya existe una convención con el horario ingresado</font>';
	}
	else
	{
		//registrar en la base de datos
		mysql_query("INSERT INTO convencion_cuadro(`idgrupo_empleado`,`alias`,`hr_inicio`,`hr_fin`,`descripcion`,`idestado_actividad`,`idservicio`) VALUES('0','$alias','$horaInicio','$horaFinalizacion','','1','0')", $cn);
		echo '<font color="#006600">Registrado exitosamente!</font>';
	}
}	
?>