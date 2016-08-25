<?php
//funcion para invocar conexion a la BD
function Conectarse(){
	//variables que contienen los datos necesarios para la conexion
		$servidor="190.0.27.100";
		$basededatos="epsilon";
		$usuario="root";
		$clave="root";
			//validar si hay conexion o no con la base de datos
		$cn = mysql_connect($servidor,$usuario,$clave) or die ("Error conectando a la base de datos");
		mysql_select_db($basededatos ,$cn) or die("Error seleccionando la Base de datos");
		mysql_query ("SET NAMES 'utf8'");
		return $cn;
					}
?>