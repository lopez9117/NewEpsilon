<?php
//conexion a la bd
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$listaestado_solicitud = mysql_query("SELECT * FROM estado_solicitud ORDER BY descestado_solicitud", $cn);
$ListaSede = mysql_query("SELECT idsede, descsede FROM sede WHERE idestado_actividad = '1' ORDER BY descsede ASC", $cn);
$ListaPrioridad = mysql_query("SELECT * FROM tipo_prioridad ORDER BY desc_prioridad ASC", $cn);
$ListaSolicitud = mysql_query("SELECT * FROM tipo_solicitud where idarea=3", $cn);
$ListaServicio = mysql_query("SELECT * FROM servicio  ORDER BY descservicio ASC", $cn);
$ListaAdquisicion = mysql_query("SELECT * FROM tipo_adquisicion where estado='2'  ORDER BY tipo ASC", $cn);
$ListaSedeProduccion = mysql_query("SELECT idsede, descsede FROM sede WHERE idestado_actividad != '2' AND idsede NOT IN(17,18,24,42,21,19,23,22,20,33) ORDER BY descsede ASC", $cn);
?>