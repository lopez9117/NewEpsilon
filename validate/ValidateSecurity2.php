<?php
//sesion del usuario, validacion de la sesion para que no se pueda ingresar por url
session_start();
$CurrentUser = $_SESSION['currentuser'] ;
//conexion a la base de datos
$cn = conectarse();
if($CurrentUser == "")
{
	echo 
	'<script language="JavaScript">
		parent.parent.location.href="../";
	</script>';
}
else
{
	//consultar datos del usuario en curso
	$sql = mysql_query("SELECT CONCAT(f.nombres,' ',f.apellidos) AS funcionario, a.idarea FROM funcionario f LEFT JOIN funcionario_area a
ON a.idfuncionario = f.idfuncionario WHERE f.idfuncionario = '$CurrentUser'", $cn);
	$res = mysql_fetch_array($sql);
	//registro en variables
	$nombreUsuario = strtoupper($res['funcionario']);
	//declaracion de las variables de sesion	
	$_SESSION['area'] = $res['idarea'];
	$_SESSION['user_id'] = $CurrentUser;
	$_SESSION['username'] = $nombreUsuario;
}
?>