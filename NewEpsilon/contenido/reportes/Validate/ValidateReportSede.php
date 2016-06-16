<?php
	require_once("../../../dbconexion/conexion.php");
	$cn = conectarse();
	//declaracion de variables con POST
	$sede = $_POST[Sede];
	$mes = $_POST[mes];
	$anio = $_POST[anio];
	//validar campos obligatorios en el formulario
	if($sede=="" || $mes=="" || $anio=="")
	{
		echo '<table width="100%" border="0" align="center">
		<tr align="left" style="height:20px;">
		  <td><font color="#FF0000" size="2">Verifique que no existan campos vacios</font></td>
		</tr>
		</table>';
	}
	else
	{
		$dias = date('t', mktime(0,0,0, $mes, 1, $anio));
	
		$fechaInicio = $anio.'-'.$mes.'-'.'01';
		$fechaStop = $anio.'-'.$mes.'-'.$dias;
	
		$sql = mysql_query("SELECT * FROM turno_funcionario WHERE fecha BETWEEN '$fechaInicio' AND '$fechaStop' AND idsede ='$sede'", $cn);
		$reg = mysql_num_rows($sql);
		
		if($reg==0 || $reg=="")
		{
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#FF0000" size="2">No se encontraron registros asociados con la busqueda</font></td>
			</tr>
			</table>';
		}
		else
		{
			echo '<script language="javascript">  
window.open("ReporteGeneralCostos.php?fechaInicio='.$fechaInicio.'&fechaStop='.$fechaStop.'&sede='.$sede.'");  
</script>';
		}
	}
?>