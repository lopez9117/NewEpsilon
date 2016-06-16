<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
	session_start();
	$CurrentUser = $_SESSION['currentuser'] ;
	//Conexion a la base de datos
	include('../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	//declaracon de variables post
	$grupoEmpleado = $_POST['grupoEmpleado'];
	$sede = $_POST['sede'];
	$mes = $_POST['mes'];
	$anio = $_POST['anio'];
	$ciudad = $_POST['ciudad'];
	//$servicio = $_POST[servicio];
//Validar campos obligatorios dentro del formulario
if($grupoEmpleado=="" || $sede=="" || $mes=="" || $anio=="" || $CurrentUser=="" || $ciudad=="")
{
	echo '<table width="100%" border="0" align="center">
    <tr align="left" style="height:20px;">
      <td><font color="#FF0000" size="2">Los campos señalados con * son obligatorios</font></td>
    </tr>
    </table>';
}
else
{
	//consulta
$sqlFuncionario = mysql_query("SELECT idfuncionario, nombres, apellidos FROM funcionario WHERE idgrupo_empleado = '$grupoEmpleado' AND idestado_actividad = '1' AND cod_mun = '$ciudad' ORDER BY apellidos ASC", $cn);

	$mesActual = date('m')-1;
	$anioActual = date('Y');
	$diaActual = date('d');
	//comparar si el mes y el año actual coinciden con los seleccionados
	if($anio==$anioActual && $mes=$mesActual)
	{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script language="javascript">
	function EnviarFormulario()
	{
		document.SeleccionFuncionario.submit();
	}
</script>
<style type="text/css">
	#celda:hover
	{
		background-color:#0FF;
	}
</style>
</head>
<body>
<div class="listado"><br>
<form id="SeleccionFuncionario" name="SeleccionFuncionario" method="post" action="CrearCuadroPersonalSeleccionado.php" target="_new" >
  <table width="100%" border="0" align="left" rules="all">
    <tr id="table" align="center" style="height:20px;">
      <td>N° Documento</td>
      <td>Nombres</td>
      <td>Seleccionar</td>
    </tr>
    <?php
    	while($rowFuncionario =  mysql_fetch_array($sqlFuncionario))
		{
			echo
			'<tr id="celda">
      			<td align="center">'.$rowFuncionario['idfuncionario'].'</td>
      			<td align="center">'.utf8_decode($rowFuncionario['apellidos'].'&nbsp;'.$rowFuncionario['nombres']).'</td>
				<td align="center"><input type="checkbox" name="id['.$rowFuncionario['idfuncionario'].']" value="'.$rowFuncionario['idfuncionario'].'"></td>
   			</tr>';
		}
	?>
  </table>
  <input type="hidden" name="sede" value="<?php echo $sede ?>" />
  <input type="hidden" name="mes" value="<?php echo $mes ?>" />
  <input type="hidden" name="anio" value="<?php echo $anio ?>" />
  <input type="hidden" name="grupoEmpleado" value="<?php echo $grupoEmpleado ?>" />
  <input type="hidden" name="servicio" value="<?php echo $servicio ?>" />
  <input type="hidden" name="Currentuser" value="<?php echo $CurrentUser ?>" />
</form>
</div><br>
<table width="80%" border="0" align="center">
    <tr align="right" style="height:20px;">
      <td><input type="button" value="Comenzar" id="table" onclick="EnviarFormulario()"/>
<input type="button" value="Restablecer" id="table" onclick="document.SeleccionFuncionario.reset()"/></td>
    </tr>
    </table>
</body>
</html>
<?php
}
	elseif($anio<$anioActual && $mes!=$mesActual)
	{
		function getMonthDays($Month, $Year)
		{
		   if( is_callable("cal_days_in_month"))
		   {
			  return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
		   }
		   else
		   {
			  return date("d",mktime(0,0,0,$Month +1,0,$Year));
		   }
		}
		//Obtenemos la cantidad de días
		$dias = getMonthDays($mes, $anio);
		//calcular la cantidad de dias que hay entre las fechas
		$fechaOld = $anio.'-'.$mes.'-'.$dias;
		$fechaAct = $anioActual.'-'.$mesActual.'-'.$diaActual;
		function dateDiff($start, $end) 
		{ 
			$start_ts = strtotime($start); 
			$end_ts = strtotime($end); 
			$diff = $end_ts - $start_ts; 
			return round($diff / 86400);
		}
		$difDias = dateDiff($fechaOld, $fechaAct);
		//si la cantidad de dias es menor o igual a 5
		if($difDias>=6)
		{
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#FF0000" size="2">No es posible registrar turnos en este momento</font></td>
			</tr>
			</table>';
		}
		else
		{?>
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>Documento sin título</title>
			<script language="javascript">
				function EnviarFormulario()
				{
					document.SeleccionFuncionario.submit();
				}
			</script>
			<style type="text/css">
				#celda:hover
				{
					background-color:#0FF;
				}
			</style>
			</head>
			<body>
			<div class="listado"><br>
			<form id="SeleccionFuncionario" name="SeleccionFuncionario" method="post" action="CrearCuadroPersonalSeleccionado.php" target="_new" >
			  <table width="100%" border="0" align="left" rules="all">
				<tr id="table" align="center" style="height:20px;">
				  <td>N° Documento</td>
				  <td>Nombres</td>
				  <td>Seleccionar</td>
				</tr>
				<?php
					while($rowFuncionario =  mysql_fetch_array($sqlFuncionario))
					{
						echo
						'<tr id="celda">
							<td align="left">'.$rowFuncionario['idfuncionario'].'</td>
							<td align="center">'.$rowFuncionario['apellidos'].'&nbsp;'.$rowFuncionario['nombres'].'</td>
							<td align="center"><input type="checkbox" name="id['.$rowFuncionario['idfuncionario'].']" value="'.$rowFuncionario['idfuncionario'].'"></td>
						</tr>';
					}
				?>
			  </table>
			  <input type="hidden" name="sede" value="<?php echo $sede ?>" />
			  <input type="hidden" name="mes" value="<?php echo $mes ?>" />
			  <input type="hidden" name="anio" value="<?php echo $anio ?>" />
			  <input type="hidden" name="grupoEmpleado" value="<?php echo $grupoEmpleado ?>" />
			  <input type="hidden" name="servicio" value="<?php echo $servicio ?>" />
			  <input type="hidden" name="Currentuser" value="<?php echo $CurrentUser ?>" />
			</form>
			</div><br>
			<table width="80%" border="0" align="center">
				<tr align="right" style="height:20px;">
				  <td><input type="button" value="Comenzar" id="table" onclick="EnviarFormulario()"/>
			<input type="button" value="Restablecer" id="table" onclick="document.SeleccionFuncionario.reset()"/></td>
				</tr>
				</table>
			</body>
			</html>		
			<?php
        }
	}
	elseif($anio==$anioActual && $mes>$mesActual)
	{?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin título</title>
		<script language="javascript">
			function EnviarFormulario()
			{
				document.SeleccionFuncionario.submit();
			}
		</script>
		<style type="text/css">
			#celda:hover
			{
				background-color:#0FF;
			}
		</style>
		</head>
		<body>
		<div class="listado"><br>
		<form id="SeleccionFuncionario" name="SeleccionFuncionario" method="post" action="CrearCuadroPersonalSeleccionado.php" target="_new" >
		  <table width="100%" border="0" align="left" rules="all">
			<tr id="table" align="center" style="height:20px;">
			  <td>N° Documento</td>
			  <td>Nombres</td>
			  <td>Seleccionar</td>
			</tr>
			<?php
				while($rowFuncionario =  mysql_fetch_array($sqlFuncionario))
				{
					echo
					'<tr id="celda">
						<td align="left">'.$rowFuncionario['idfuncionario'].'</td>
						<td align="center">'.utf8_decode($rowFuncionario['apellidos'].'&nbsp;'.$rowFuncionario['nombres']).'</td>
						<td align="center"><input type="checkbox" name="id['.$rowFuncionario['idfuncionario'].']" value="'.$rowFuncionario['idfuncionario'].'"></td>
					</tr>';
				}
			?>
		  </table>
		  <input type="hidden" name="sede" value="<?php echo $sede ?>" />
		  <input type="hidden" name="mes" value="<?php echo $mes ?>" />
		  <input type="hidden" name="anio" value="<?php echo $anio ?>" />
		  <input type="hidden" name="grupoEmpleado" value="<?php echo $grupoEmpleado ?>" />
		  <input type="hidden" name="servicio" value="<?php echo $servicio ?>" />
		  <input type="hidden" name="Currentuser" value="<?php echo $CurrentUser ?>" />
		</form>
		</div><br>
		<table width="80%" border="0" align="center">
			<tr align="right" style="height:20px;">
			  <td><input type="button" value="Comenzar" id="table" onclick="EnviarFormulario()"/>
		<input type="button" value="Restablecer" id="table" onclick="document.SeleccionFuncionario.reset()"/></td>
			</tr>
			</table>
		</body>
		</html>	
	<?php
    }
	elseif($anio>=$anioActual && $mes<$mesActual)
	{
		//calcular la cantidad de dias que hay entre la ultima fecha del mes anterior y la fecha actual
		function getMonthDays($Month, $Year)
		{
		   if( is_callable("cal_days_in_month"))
		   {
			  return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
		   }
		   else
		   {
			  return date("d",mktime(0,0,0,$Month+1,0,$Year));
		   }
		}
		//Obtenemos la cantidad de días
		$dias = getMonthDays($mes, $anio);
		//calcular la cantidad de dias que hay entre las fechas
		$fechaOld = $anio.'-'.$mes.'-'.$dias;
		$fechaAct = $anioActual.'-'.$mesActual.'-'.$diaActual;
		function dateDiff($start, $end) 
		{ 
			$start_ts = strtotime($start); 
			$end_ts = strtotime($end); 
			$diff = $end_ts - $start_ts; 
			return round($diff / 86400);
		}
		$difDias = dateDiff($fechaOld, $fechaAct);
		if($difDias>=6)
		{
			echo '<table width="100%" border="0" align="center">
			<tr align="left" style="height:20px;">
			  <td><font color="#FF0000" size="2">No es posible registrar turnos en este momento</font></td>
			</tr>
			</table>';
		}
		else
		{?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Documento sin título</title>
		<script language="javascript">
			function EnviarFormulario()
			{
				document.SeleccionFuncionario.submit();
			}
		</script>
		<style type="text/css">
			#celda:hover
			{
				background-color:#0FF;
			}
		</style>
		</head>
		<body>
		<div class="listado"><br>
		<form id="SeleccionFuncionario" name="SeleccionFuncionario" method="post" action="CrearCuadroPersonalSeleccionado.php" target="_new" >
		  <table width="100%" border="0" align="left" rules="all">
			<tr id="table" align="center" style="height:20px;">
			  <td>N° Documento</td>
			  <td>Nombres</td>
			  <td>Seleccionar</td>
			</tr>
			<?php
				while($rowFuncionario =  mysql_fetch_array($sqlFuncionario))
				{
					echo
					'<tr id="celda">
						<td align="center">'.$rowFuncionario['idfuncionario'].'</td>
						<td align="center">'.$rowFuncionario['apellidos'].'&nbsp;'.$rowFuncionario['nombres'].'</td>
						<td align="center"><input type="checkbox" name="id['.$rowFuncionario['idfuncionario'].']" value="'.$rowFuncionario['idfuncionario'].'"></td>
					</tr>';
				}
			?>
		  </table>
		  <input type="hidden" name="sede" value="<?php echo $sede ?>" />
		  <input type="hidden" name="mes" value="<?php echo $mes ?>" />
		  <input type="hidden" name="anio" value="<?php echo $anio ?>" />
		  <input type="hidden" name="grupoEmpleado" value="<?php echo $grupoEmpleado ?>" />
		  <input type="hidden" name="servicio" value="<?php echo $servicio ?>" />
		  <input type="hidden" name="Currentuser" value="<?php echo $CurrentUser ?>" />
		</form>
		</div><br>
		<table width="80%" border="0" align="center">
			<tr align="right" style="height:20px;">
			  <td><input type="button" value="Comenzar" id="table" onclick="EnviarFormulario()"/>
		<input type="button" value="Restablecer" id="table" onclick="document.SeleccionFuncionario.reset()"/></td>
			</tr>
			</table>
		</body>
		</html>	
		<?php
        }
	}
}
?>