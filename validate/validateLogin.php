<?php
//conexion al a base de datos
include("../dbconexion/conexion.php");
$cn = conectarse();
$username = $_POST['username'];
$password = md5($_POST['password']);
//validar si el usuario esta activo
 $sqlUser = mysql_query("SELECT idusuario FROM usuario u
INNER JOIN funcionario f ON f.idfuncionario = u.idusuario WHERE idusuario = '$username' AND pass = '$password' AND idestado_actividad = '1'", $cn);
$ConUser =  mysql_num_rows($sqlUser);
if($ConUser>=1)
{
	$regUser = mysql_fetch_array($sqlUser);
	session_start();
	$_SESSION['currentuser'] = $regUser['idusuario'];
	header('Location: ../contenido/home.php');
}
else
{
	header('Location: ../index.php?error='.base64_encode('1').'&username='.base64_encode($username).'');
}
?>