<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
//variables post
$estudio = $_POST['Vistaestudio'];
$servicio = $_POST['servicio'];
$id= $_POST['id'];
//consultar el servicio al que corresponde el estudio
list($issEstudio, $nomEstudio) = explode(" - ", $estudio);
$consEstudio = mysql_query("SELECT * FROM r_estudio where nom_estudio LIKE '%$nomEstudio%' AND idestado='1' AND idservicio='$servicio'", $cn);
$regsEstudio = mysql_fetch_array($consEstudio);
?>
<input type="hidden" name="estudio<?php echo $id?>" value="<?php echo $regsEstudio['idestudio']?>" id="estudio<?php echo $id?>"/>
