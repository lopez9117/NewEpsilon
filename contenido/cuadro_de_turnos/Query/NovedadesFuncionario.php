<?php
	//Conexion a la base de datos
	include('../../../dbconexion/conexion.php');
	//funcion para abrir conexion
	$cn = Conectarse();
	//variables con GET
	$idturno = $_GET['idturno'];
	//consultar si existen o no disponibilidades
	$conNovedad = mysql_query("SELECT * FROM novedad_turno WHERE idturno = '$idturno'", $cn);
	$canNovedad = mysql_num_rows($conNovedad);
	
	if($canNovedad==0 || $canNovedad=="")
	{
		echo 
		'<table width="100%" border="0">
		  <tr>
			<td align="center">No se han registrado novedades en el turno</td>
		  </tr>
		 </table>';
		  
	}
	else
	{
?>
<table width="100%" border="1" rules="all">
  <tr>
    <td width="20%" align="center">Horario</td>
    <td width="60%" align="center">Observaciones</td>
    <td width="20%" align="center">Tareas</td>
  </tr>
<?php
	while($rowNovedad = mysql_fetch_array($conNovedad))
	{
		echo '
		<tr>
			<td align="center">'.$rowNovedad['hr_inicio'].' - '.$rowNovedad['hr_fin'].'</td>
			<td >'.$rowNovedad['nota'].'</td>
			<td align="center"><a href="#" onClick="EliminarNovedad('.$rowNovedad['idturno'].')" alt="Eliminar" title="Eliminar Turno"><img src="../../images/button_cancel.png" width="10" height="10" /></a></td>
		  </tr>';
	}
?>  
</table>
<?php
	}
?>
