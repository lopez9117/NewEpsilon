<?php
include("../../../dbconexion/conexion.php");
$cn = conectarse();
//variables post
$equipo = $_POST['selectEquipo'];
$Equipos = mysql_query("SELECT * FROM equipos_biomedicos WHERE id_referencia='$equipo'", $cn);
$rowEquipos = mysql_fetch_array($Equipos)
?>
            <div class="col-lg-4 col-sm-3 col-xs-12 form-group">
            <label for="marca">Marca:</label>
            <input type="text" name="marca" id="marca" class="form-control" value="<?php echo $rowEquipos['marca']?>"/>
            </div>   
            <div class="col-lg-4 col-sm-3 col-xs-12 form-group">
             <label for="modelo">Modelo:</label>
                <input type="text" name="modelo" id="modelo" class="form-control" value="<?php echo $rowEquipos['modelo'] ?>"/>
                </div>
                <div class="col-lg-4 col-sm-3 col-xs-12 form-group">
<label for="serie">Serie:</label>
                <input type="text" name="serie" id="serie" class="form-control" value="<?php echo $rowEquipos['serie'] ?>"/>
            </div>
