<?php
//conexion a la bd
include("../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables con post
$funcionario = $_POST['documento'];
$rol = $_POST['rol'];
$email = $_POST['email'];
$pass1 = md5($_POST['pass1']);
$mod = $_POST['modulo'];
//Validar si el usuario esta registrado en la tb usuarios
$consUser = mysql_query("SELECT idusuario AS usuario FROM usuario WHERE idusuario = '$funcionario'", $cn);
$regsUser = mysql_num_rows($consUser);
if($regsUser>=1)
{
	mysql_query("UPDATE usuario SET email = '$email', idrol = '$rol' WHERE idusuario = '$funcionario'", $cn);
	//eliminar todos los accesos a los modulos y reescribirlos
	mysql_query("DELETE FROM modulo_usuario WHERE idusuario = '$funcionario'", $cn);
	foreach($_POST['modulo'] as $modulo)
	{
		mysql_query("INSERT INTO modulo_usuario(idmodulo,idusuario) VALUES('$modulo','$funcionario')", $cn);
	}
}
else
{
	//registrar al usuario y los modulos
	mysql_query("INSERT INTO usuario (idusuario, pass, email, idestado, idrol) VALUES('$funcionario', '$pass1', '$email', '1', '$rol')", $cn);
	foreach($_POST['modulo'] as $modulo)
	{
		mysql_query("INSERT INTO modulo_usuario(idmodulo,idusuario) VALUES('$modulo','$funcionario')", $cn);
	}
}		
?>
<script language="javascript">
	setTimeout(window.close, 2000);
</script>