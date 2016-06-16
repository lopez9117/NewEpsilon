<?php
//funcion para invocar conexion a la BD
function Conectarsepacsdb(){
	//variables que contienen los datos necesarios para la conexion
$servidor="localhost";
$basededatos="pacsdb";
$usuario="root";
$clave="root";
	//validar si hay conexion o no con la base de datos
$conpacsdb = mysql_connect($servidor,$usuario,$clave) or die ("Error conectando a la base de datos");
mysql_select_db($basededatos ,$conpacsdb) or die("Error seleccionando la Base de datos");
mysql_query ("SET NAMES 'utf8'");
return $conpacsdb;}
?>