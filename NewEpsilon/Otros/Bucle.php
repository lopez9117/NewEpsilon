<?php
	include("dbconexion/conexion.php");
	$cn = conectarse();
	$array_grupos = array("1","2","3","4","5","6","12");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<body>
<?php
foreach($array_grupos as $IdGrupo)
{	
	//listar todos los miembros de un grupo de empleados
	$conFuncionarios = mysql_query("SELECT idfuncionario FROM funcionario WHERE idgrupo_empleado = '$IdGrupo' ORDER BY idfuncionario ASC", $cn);
	while($rowFuncionarios = mysql_fetch_array($conFuncionarios))
	{
		$idFuncionario = $rowFuncionarios['idfuncionario'];
		if($IdGrupo==1)
		{
			mysql_query("UPDATE usuario SET idrol = '7' WHERE idusuario = 'idFuncionario';", $cn);
		}
		elseif($IdGrupo==2)
		{
			mysql_query("UPDATE usuario SET idrol = '4' WHERE idusuario = 'idFuncionario';", $cn);
		}
		elseif($IdGrupo==3)
		{
			mysql_query("UPDATE usuario SET idrol = '4' WHERE idusuario = 'idFuncionario';", $cn);
		}
		elseif($IdGrupo==4)
		{
			mysql_query("UPDATE usuario SET idrol = '5' WHERE idusuario = 'idFuncionario';", $cn);
		}
		elseif($IdGrupo==5)
		{
			mysql_query("UPDATE usuario SET idrol = '6' WHERE idusuario = 'idFuncionario';", $cn);
		}
		elseif($IdGrupo==6)
		{
			mysql_query("UPDATE usuario SET idrol = '7' WHERE idusuario = 'idFuncionario';", $cn);
		}
		elseif($IdGrupo==12)
		{
			mysql_query("UPDATE usuario SET idrol = '1' WHERE idusuario = 'idFuncionario';", $cn);
		}
	}
}
?>
</body>
</html>