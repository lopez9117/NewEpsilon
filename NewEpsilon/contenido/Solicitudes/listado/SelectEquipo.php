<?php
include("../../../dbconexion/conexion.php");
$cn = conectarse();
//variables post
$idsede = $_POST['Sede'];
$listaEquipos = mysql_query("SELECT * FROM equipos_biomedicos WHERE idsede='$idsede' ORDER BY equipo ASC", $cn);
?>
<option value="">.: Seleccione :.</option>
<?php
while($rowEquipos = mysql_fetch_array($listaEquipos))
{
?>
<option value="<?php echo $rowEquipos['id_referencia']?>">
<?php echo $rowEquipos['equipo']?></option>
<?php
}	
?>
<span class="asterisk">*</span>