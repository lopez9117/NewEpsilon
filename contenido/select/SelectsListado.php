<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//instrucciones de consulta
//Listado de los tipos de documentos validos y registrados en el sistema
$listaestado_solicitud = mysql_query("SELECT * FROM estado_solicitud WHERE idestado_solicitud NOT IN ('5','6','1','7')", $cn);
$listaestado_solicitud1 = mysql_query("SELECT * FROM estado_solicitud WHERE idestado_solicitud NOT IN ('1','2','3','4')", $cn);
$Listapresupuesto = mysql_query("SELECT * FROM presupuestado", $cn);
?>