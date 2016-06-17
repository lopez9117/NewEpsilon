<?php
	//archivo de conexion a la base de datos
	require_once ("../../../dbconexion/conexion.php");
	$cn = Conectarse();
	//declaracion de variables con POST
	$funcionario = $_POST[ndocumento];
	$desde = $_POST[desde];
	$cantDias = ($_POST[cantDias]-1);
	$tipoDias = $_POST[tipo];
	$grupo_empleado = $_POST[grupo_empleado];
	$horas = 0;
	$currentUser = 0;
	list($year, $month, $day) = explode("-",$desde);
	$fechaInicio = $year.'-'.$month.'-'.$day;
	mysql_query("DELETE FROM turno_funcionario WHERE fecha = '$fechaInicio' AND idfuncionario = '$funcionario'", $cn);
	//Consulta para registrar vacaciones en la fecha arrojada
	mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo)
	VALUES('$funcionario','0','0','$fechaInicio','$currentUser','100','$horas','0','0','0','0','0','$grupo_empleado','0','0')", $cn);
	//validar Campos obligatorios
	if($desde=="" || $cantDias=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">Los campos señalados con * son obligatorios</font></td>
		</tr>
		</table>';
	}
	else
	{	
		list($year, $month, $day) = explode("-",$desde);
		//funcion para sumar la cantidad de dias habiles*/
		//Esta pequeña funcion me crea una fecha de entrega sin sabados ni domingos  
		$fechaInicial = $year.'-'.$month.'-'.$day;
		$MaxDias = ($cantDias); //Cantidad de dias maximo para el prestamo, este sera util para crear el for        
		 //Creamos un for desde 0 hasta 3  
		 for ($i=0; $i<$MaxDias; $i++)  
		 {  
			$dia = $dia + 1;
			$nuevafecha = strtotime ( '+'.$dia.' day' , strtotime ( $fechaInicial ) ) ; 
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
			list($anio, $mes, $d) = explode("-",$nuevafecha);
			$wkdy = (((mktime ( 0, 0, 0, $mes, $d, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;
			//Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...  
			if($wkdy==6 )  
			{  
				$i--;  
			}  
			else 
			{  
				$fecha = $anio.'-'.$mes.'-'.$d;
				$sql = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$fecha'",$cn);
				$res = mysql_num_rows($sql);
				
				if ($res>=1)
				{
					$i--;
				}
				else
				{
					//Registrar vacaciones para personal administrativo
					//consulta para eliminar turnos que esten dentro de las fechas asignadas
					mysql_query("DELETE FROM turno_funcionario WHERE fecha = '$fecha' AND idfuncionario = '$funcionario'", $cn);
					//Consulta para registrar vacaciones en la fecha arrojada
					mysql_query("INSERT INTO turno_funcionario (idfuncionario, hr_inicio, hr_fin, fecha, currentuser, idtipo_turno, diurna, diurnafest, nocturna, nocturnafest, idConvencion, idsede, idgrupo_empleado, idservicio, hralmuerzo)
					VALUES('$funcionario','0','0','$fecha','$currentUser','100','$horas','0','0','0','0','0','$grupo_empleado','0','0')", $cn);
				} 
			}  
		}
echo '<table width="100%" border="0" align="center">
<tr align="left" style="height:20px;">
  <td><font color="#00FF00" size="2">Registrado exitosamente!</font></td>
</tr>
</table>';
}
?>