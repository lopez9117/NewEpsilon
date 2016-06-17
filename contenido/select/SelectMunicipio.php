<?php
	//archivo de conexion
	include("../../dbconexion/conexion.php");
	$cn = conectarse();
	//variables con POST
	$dep = $_POST[coddpto];
	//listar municipios de un departamento
	$sql = mysql_query("SELECT * FROM r_municipio WHERE cod_dpto = '$dep'", $cn);
?>
<option value="">.: Seleccione :.</option>
<?php
	while($rowMunicipio = mysql_fetch_array($sql))
	{
		echo '<option value="'.$rowMunicipio[cod_mun].'">'.$rowMunicipio[nombre_mun].'</option>';
	}
?>