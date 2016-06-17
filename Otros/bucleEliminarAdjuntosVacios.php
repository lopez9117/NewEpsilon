<?php
ini_set('max_execution_time', 0);
require_once('dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$sql = mysql_query("SELECT id_informe,adjunto FROM r_adjuntos", $cn);
while ($row = mysql_fetch_array($sql))
{
$id_informe=$row['id_informe'];
$adjunto=$row['adjunto'];
if($adjunto=='uploads/'.$id_informe.'.')
	{
	echo $adjunto.'<br>';;
	//$sql2 = mysql_query("DELETE FROM r_adjuntos where adjunto='$adjunto'", $cn);
	}
}
?>