<?php
	//archivo de conexion
	//include("../../../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con POST
	//echo 'servicio'.$servicio = $_POST[servicio];
	$sqlEstudio = mysql_query("SELECT idestudio, nom_estudio FROM r_estudio WHERE idservicio = '$servicio' ORDER BY nom_estudio ASC", $cn);
?>
<select name="estudio" id="estudio">
<option value="">.: Seleccione :.</option>
<?php
	while($rowEstudio = mysql_fetch_array($sqlEstudio))
	{
		echo '<option value="'.$rowEstudio['idestudio'].'">'.$rowEstudio['nom_estudio'].'</option>';
	}
?>
</select>