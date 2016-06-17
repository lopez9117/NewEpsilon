<?php
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables
$convencion = $_POST['convencion'];
//consulta
$con = mysql_query("SELECT hr_fin FROM convencion_cuadro WHERE id = '$convencion'", $cn);
$reg = mysql_fetch_array($con);
?>
<input type="text" class="textsmall" readonly="readonly" value="<?php echo $reg['hr_fin'] ?>" name="fin"/>