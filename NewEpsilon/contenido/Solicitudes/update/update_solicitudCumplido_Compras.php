<?php
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$porque = $_POST[porque];
$id = $_POST[Id];


if($porque == "" )
	{
		echo '<font size="2" color="#FF0000">Los campos señalados con * son obligatorios</font>';
	}

		else
		{
         $sql = mysql_query("UPDATE solicitud SET porque='$porque',idsatisfaccion ='5' WHERE idsolicitud='$id'", $cn);
echo '<font size="2" color="009900">Se ha enviado con satisfaccion la respuesta</font>';

		}
?>


