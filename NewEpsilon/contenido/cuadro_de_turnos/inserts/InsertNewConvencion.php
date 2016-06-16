<?php 

	//conexion a la base de datos
	include('../../../dbconexion/conexion.php');
	$cn = Conectarse();
	
	//declaracion de variables
	$grupoempleado = $_POST[grupoempleado];
	$servicio = $_POST[servicio];
	$hr_inicio = $_POST[hr_inicio];
	$hr_fin = $_POST[hr_fin];
	$descripcion = $_POST[descripcion];
	$alias = strtoupper($_POST[alias]);
	//validar campos obligatorios del formulario
	if($grupoempleado=="" || $servicio=="" || $hr_inicio=="" || $hr_fin=="" || $descripcion=="" || $alias=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">Los campos señalados con * son obligatorios</font></td>
		</tr>
		</table>';
	}
	else
	{
		//consultar que la convencion no este repetida
		$sqlConvencion = mysql_query("SELECT * FROM convencion_cuadro WHERE idgrupo_empleado = '$grupoempleado' AND alias = '$alias'", $cn);
		$regConvencion = mysql_num_rows($sqlConvencion);
		
		if($regConvencion>=1)
		{
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#FF0000" size="2">El alias que intenta ingresar ya esta regsitrado</font></td>
			</tr>
			</table>';
		}
		else
		{
			mysql_query("INSERT INTO convencion_cuadro VALUES('','$grupoempleado','$alias','$hr_inicio','$hr_fin','$descripcion','1','$servicio')", $cn);
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#00FF00" size="2">Registrado Exitosamente!</font></td>
			</tr>
			</table>';
		}	
	}
?>