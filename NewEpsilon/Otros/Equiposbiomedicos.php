<?php
	include("dbconexion/conexion.php");
	$cn = conectarse();

$handle = fopen("Equipos2015.csv", "r");


// loop content of csv file, using comma as delimiter
while (($data = fgetcsv($handle, 1000, ",")) !== false) {
$idsede = $data[0];
$equipo =  $data[1];
$marca = $data[2];
$modelo = $data[3];
$serie = $data[4];
$query = 'SELECT idfuncionario FROM funcionario';
if (!$result = mysql_query($query)) {
continue;
}
if ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {

// entry exists update
$query = "INSERT INTO equipos_biomedicos (idsede,equipo,marca,modelo,serie) VALUES ('$idsede','$equipo','$marca','$modelo','$serie')";


mysql_query($query);
if (mysql_affected_rows() <= 0) {

// no rows where affected by update query
}
} else {
// entry doesn't exist continue or insert...
}

mysql_free_result($result);
}

fclose($handle);
mysql_close($cn);
?>