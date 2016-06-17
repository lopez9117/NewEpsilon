<?php

//declaracion de variables con POST
$fechanacimiento = $_POST['fechanacimiento'];
$fecha = date("Y-m-d",strtotime($fechanacimiento));
//fecha actual
$dia=date('j');
$mes=date('n');
$ano=date('Y');
//fecha de nacimiento
list($Y,$m,$d) = explode("-",$fecha);
$dianaz = $d;
$mesnaz = $m;
$anonaz = $Y;
//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
if (($mesnaz == $mes) && ($dianaz > $dia)) {
$ano=($ano-1); }
//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
if ($mesnaz > $mes) {
$ano=($ano-1);}
//ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
$edad=($ano-$anonaz);
echo '<input type="text" size="8" readonly="readonly" value="'.$edad.'" class="textSmall"/>';
?>