<?php
//conexion a la BD
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
$Nota = $_POST['NotaAclaratoria'];
$usuario = $_POST['usuario'];
$idinforme = $_POST['idInforme'];
if($Nota!="")
{
//insersion en la bd
mysql_query("INSERT INTO r_nota_aclaratoria VALUES('$idinforme','$Nota','$usuario', NOW())", $cn);
//redireccionas al mismo informe anexando la nota aclaratoria
echo '<script language="javascript">
	location.href="CrearNuevaNotaAclaratoria.php?informe='.base64_encode($idinforme).'&usuario='.base64_encode($usuario).'"
</script>';
}
else
{
	//redireccionas al mismo informe anexando la nota aclaratoria
	echo '<script language="javascript">
		location.href="CrearNuevaNotaAclaratoria.php?informe='.base64_encode($idinforme).'&usuario='.base64_encode($usuario).'"
	</script>';
}
?>