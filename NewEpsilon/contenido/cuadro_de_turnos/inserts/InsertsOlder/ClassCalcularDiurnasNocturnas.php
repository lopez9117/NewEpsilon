<?php
//Funcion restar horas
function resta($inicio, $fin)
{
  $dif = date("H:i", strtotime("00:00") + strtotime($fin) - strtotime($inicio) );
  return $dif;
}
$diferencia = resta($inicio, $fin);
//Funcion convertir valores en enteros con un decimal
function decimal($hora)
{
	$desglose = split(":", $hora);
	$dec = $desglose[0]+$desglose[1]/60;
	return $dec;
}
$contHoras = decimal($diferencia);
?>