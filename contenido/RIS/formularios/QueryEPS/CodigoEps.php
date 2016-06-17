<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$VarEps = trim($_POST['VistaEps']);
//consultar datos de la IPS
$QueryEps = mysql_query("SELECT ideps FROM eps WHERE desc_eps LIKE '%$VarEps%'", $cn);
$RegsEps = mysql_fetch_array($QueryEps);
echo '<input type="hidden" readonly="readonly" name="ideps" id="ideps" value="'.$RegsEps['ideps'].'">';
?>