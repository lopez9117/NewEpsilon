<?php
//conexion a la BD
include("../../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$informe = $_POST['informe'];
$especialista = $_POST['especialista'];
foreach($id as $informe)
{
	$var = count($informe);
	$sql = mysql_query("UPDATE r_informe_header SET idfuncionario_esp = '$especialista' WHERE id_informe = '$informe'", $cn);
}
$var = ($var*1000/2);
echo
'<script language="javascript">
	setTimeout(document.location.href="../AsignacionEstudios.php?sede='.$sede.'&servicio='.$servicio.'&especialista='.$especialista.'", $var);
</script>';
?>