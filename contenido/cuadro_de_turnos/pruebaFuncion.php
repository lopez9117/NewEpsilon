<?php
//variables de referencia
$InicioDiurnas = '06:00';
$InicioNocturnas = '22:00';
$CambioDia = '00:00';
//Declaracion de variables
$inicio = '22:00';
$fin = '06:00';
//calcular horario cuando todas las horas son diurnas
if($inicio>=$InicioDiurnas && $fin<=$InicioNocturnas && $fin>$InicioDiurnas && $fin>$inicio)
{
	echo $contHoras;
	//realizar insersion validando si el dia es ordinario o feriado
}
//calcular horario si todas las horas son nocturnas
elseif($inicio>=$InicioNocturnas && $fin<=$InicioDiurnas || $inicio>=$CambioDia && $fin<=$InicioDiurnas)
{
	
	echo $contHoras;	
	//realizar insersion validando si el dia es ordinario o feriado
}
?>