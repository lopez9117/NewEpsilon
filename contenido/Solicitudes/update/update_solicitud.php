<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$Fecha=date("Y/m/d");
$time = date("G:i:s");
$estado = $_POST[estado];
$Diagnostico = $_POST[Diagnostico];
$id = $_POST[Id];
$session=$_POST[Session];
if($estado == "" )
	{
		echo '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
	}

		else
		{
         $sql = mysql_query("UPDATE solicitud SET fechahora_visita='$Fecha', horavisita='$time',idestado_solicitud='$estado',Diagnostico='$Diagnostico',idfuncionarioresponde='$session' WHERE idsolicitud='$id'", $cn);
echo '<font size="2" color="#009900">Su Respuesta se ha enviado satisfactoriamente</font>';

		}
?>


