<?php
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables con el metodo POST
$id = $_POST['id'];
$sede  = $_POST['sede'];
$estado = $_POST['estado'];
//consultar si el registro existe
$con = mysql_query("SELECT * FROM r_conf_lista_lectura WHERE idsede='$sede' AND idservicio='$id'", $cn);
$cont = mysql_num_rows($con);
//si el registro existe modificar su estado
if($cont>=1)
{
	//actualizar estado
	mysql_query("UPDATE r_conf_lista_lectura SET idestado_actividad='$estado' WHERE idsede='$sede' AND idservicio='$id'", $cn);
}
else
{
	//realizar insersion en la base de datos
	mysql_query("INSERT INTO r_conf_lista_lectura (idsede, idservicio, idestado_actividad) VALUES('$sede','$id','$estado')", $cn);
}
mysql_close($cn);
?>