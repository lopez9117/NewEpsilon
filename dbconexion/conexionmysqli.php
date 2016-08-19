<?php
//funcion para invocar conexion a la BD
function Conectarse(){
//variables que contienen los datos necesarios para la conexion
    $servidor = '10.8.8.30';
    $basededatos = 'epsilon';
    $usuario = 'root';
    $clave = 'root';
//validar si hay conexion o no con la base de datos
    $cn = mysqli_connect($servidor,$usuario,$clave,$basededatos) or die("Error " . mysqli_error());
    mysqli_query ($cn,"SET NAMES 'utf8'");
    return $cn;
}
?>