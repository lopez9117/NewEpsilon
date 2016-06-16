<?php
	include("../../dbconexion/conexion.php");
	$cn = conectarse();
	$idFuncionario = $_POST[user];
	$email = $_POST[email];
	//validar campos vacios del formulario
	
	if($_POST[pass1]=="" || $_POST[pass2]=="")
	{
		echo '<font color="#FF0000" size="2">Hay campos vacios en el formulario</font>';
	}
	else
	{
		$pass1 = md5($_POST[pass1]);
		$pass2 = md5($_POST[pass2]);
		//comparar que los password sean iguales
		if($pass1 != $pass2)
		{
			echo '<font color="#FF0000" size="2">Las contraseñas no coinciden</font>';
		}
		else
		{
			if($email=="")
			{
				mysql_query("UPDATE usuario SET pass = '$pass1' WHERE idusuario = '$idFuncionario'", $cn);
				echo '<font color="#00FF00" size="2">Actualizado Correctamente</font>';
			}
			else
			{
				mysql_query("UPDATE usuario SET pass = '$pass1', email = '$email' WHERE idusuario = '$idFuncionario'", $cn);
				echo '<font color="#00FF00" size="2">Actualizado Correctamente</font>';
			}
		}
	}
	
?>