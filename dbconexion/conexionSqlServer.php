<?php
$serverName = "10.8.8.2"; //serverName\instanceName
$connectionInfo = array( "Database"=>"ImageServer", "UID"=>"sa", "PWD"=>"Prodx$800250192");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
//echo "conectado a base de datos";
}else{
     die( print_r( sqlsrv_errors(), true));
}
?>
