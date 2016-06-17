<?php
	//especialidades
	$consEspecialidad = mysql_query("SELECT * FROM r_especialidad ORDER BY nom_especialidad ASC", $cn);
	//Universidades
	$consUniversidad = mysql_query("SELECT * FROM r_universidad ORDER BY nom_universidad ASC", $cn);
?>