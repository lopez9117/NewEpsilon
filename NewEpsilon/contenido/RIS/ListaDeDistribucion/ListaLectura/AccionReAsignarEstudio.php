<?php
//conexion a la BD
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$informe = $_POST['informe'];
$especialista = $_POST['especialista'];
$observacion = $_POST['observacion'];
$usuario = $_POST['usuario'];
$fecha = date("Y-m-d");
$hora = date("G:i:s");
//asignar estudio a un especialista especifico
$cons = mysql_query("UPDATE r_informe_header SET idfuncionario_esp = '$especialista' WHERE id_informe = '$informe'", $cn);
//registrar la observacion
if($observacion!="")
{
	mysql_query("INSERT INTO r_observacion_informe (id_informe, idfuncionario, observacion, fecha, hora, id_tipocomentario) VALUES('$informe','$usuario','$observacion','$fecha','$hora','1')", $cn);
}
mysql_close($cn);
?>
<script language="javascript">window.close()</script>