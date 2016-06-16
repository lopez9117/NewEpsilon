<?php
//conexion a la BD
include("../../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
//$informe = $_POST['informe'];
$especialista = $_POST['especialista']; 
$id = $_POST['id'];
$sede = $_POST['sede']; 
$servicio = $_POST['servicio'];
foreach($id as $informe)
{
	$cons = mysql_query("UPDATE r_informe_header SET idfuncionario_esp = '$especialista' WHERE id_informe = '$informe'", $cn);
}
echo
'<script language="javascript">
	document.location.href="../AsignacionEstudios.php?sede='.$sede.'&servicio='.$servicio.'&especialista='.$especialista.'";
</script>';
?>