<?php
//instrucciones de consulta
$listaSedeActiva = mysql_query("SELECT * FROM sede WHERE idestado_actividad = 1 ORDER BY descsede ASC", $cn);
//Listado de Servicios para el cuadro de turnos
$listaServicios = mysql_query("SELECT * FROM servicio WHERE idestado_actividad = 1 ORDER BY descservicio ASC", $cn);
//listado de encuestas regitradas
$listaEncuesta = mysql_query("SELECT * FROM e_nombencuesta WHERE idestado_actividad = 1 ORDER BY nomencuesta ASC", $cn);
//arreglo con los meses del año
$meses = array( '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre', );
//consultar los años con encuestas registradas
$anios = mysql_query("SELECT DISTINCT YEAR(fecha) AS anio FROM e_encuesta ORDER BY anio ASC", $cn);

?>