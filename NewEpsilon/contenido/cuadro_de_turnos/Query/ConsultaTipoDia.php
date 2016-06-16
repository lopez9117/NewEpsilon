<?php
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$fecha = $_POST['fecha'];
//consultar si la fecha corresponde a un dia ordinario y o festivo
$cons = mysql_query("SELECT * FROM dia_festivo WHERE fecha_festivo = '$fecha'", $cn);
$regs = mysql_num_rows($cons);
if($regs>=1)
{
	$tipoDia = 2;
}
else
{
	list($anio, $mes, $d) = explode("-" , $fecha);
	$wkdy = (((mktime ( 0, 0, 0, $mes, $d, $anio) - mktime ( 0, 0, 0, 7, 17, 2006))/(60*60*24))+700000) % 7;	
	if($wkdy==6)
	{
		$tipoDia = 2;
	}
	else
	{
		$tipoDia = 1;
	}
}
?>
<input type="hidden" name="tipo" value="<?php echo $tipoDia ?>" readonly="readonly"/>