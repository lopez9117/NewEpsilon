<?php
	include("dbconexion/conexion.php");
	$cn = conectarse();

$handle = fopen("Listado de Actualizacion2.csv", "r");


// loop content of csv file, using comma as delimiter
while (($data = fgetcsv($handle, 1000, ",")) !== false) {
$Product_ID = $data[0];
$cedula =  $data[1];
$stock = $data[2];
$salario = $data[3];
$query = 'SELECT idfuncionario FROM funcionario';
if (!$result = mysql_query($query)) {
continue;
}
if ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {

// entry exists update
$query = "UPDATE funcionario SET salario ='$salario'
WHERE idfuncionario = '$cedula'";


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