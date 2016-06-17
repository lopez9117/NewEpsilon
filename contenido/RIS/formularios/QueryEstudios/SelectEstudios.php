<?php
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
//variables post
$sede = $_POST['sede'];
$servicio = $_POST['servicio'];
$id = $_POST['id'];
$idestudio = $_POST['idestudio'];
if ($servicio != "") {

    if ($sede == 1 AND $servicio == 2) {
        $listaEstudios = mysql_query("SELECT idestudio,CONCAT (cups_iss,' - ',TRIM(nom_estudio)) AS nom_estudio FROM r_estudio where idservicio='$servicio' AND idestado='1' OR idestudio = '879' ORDER BY nom_estudio ASC", $cn);
    } else {
        $listaEstudios = mysql_query("SELECT idestudio,CONCAT (cups_iss,' - ',TRIM(nom_estudio)) AS nom_estudio FROM r_estudio where idservicio='$servicio' AND idestado='1' ORDER BY nom_estudio ASC", $cn);
    }
    ?>
    <div class="ui-widget">
        <select id="estudio<?php echo $id; ?>" name="estudio<?php echo $id; ?>" class="text">
            <option value="">Seleccionar Estudio</option>
            <?php
            while ($RegEstudio = mysql_fetch_array($listaEstudios)) {
                ?>
                <option value="<?php echo $RegEstudio['idestudio'] ?>"
                    <?php if ($RegEstudio['idestudio'] == $idestudio) {
                        echo 'selected';
                    } ?>
                    ><?php echo $RegEstudio['nom_estudio']
                    ?></option>
            <?php
            }
            ?>
        </select>
    </div>
<?php
}
else{
    echo '<strong>Estudio</strong><br><input list="listaEstudio" name="estudio" id="estudio" style="width:72%; font-family:Arial, Helvetica, sans-serif; font-size:11px;" placeholder="Ingresar nombre del estudio o procedimiento" disabled="disabled"><font color="#FF0000"> Por favor seleccionar un servicio.</font>';
}
/*if ($servicio == "") {
    echo '<strong>Estudio</strong><br><input list="listaEstudio" name="estudio" id="estudio" style="width:72%; font-family:Arial, Helvetica, sans-serif; font-size:11px;" placeholder="Ingresar nombre del estudio o procedimiento" disabled="disabled"><font color="#FF0000"> Por favor seleccionar un servicio.</font>';
} else {
    if ($sede == 1 AND $servicio==2) {
        $listaEstudios = mysql_query("SELECT * FROM r_estudio where idservicio='$servicio' AND idestado='1' OR idestudio = '879' ORDER BY nom_estudio ASC", $cn);
    } else {
        $listaEstudios = mysql_query("SELECT * FROM r_estudio where idservicio='$servicio' AND idestado='1' ORDER BY nom_estudio ASC", $cn);
    }
    ?>

    <strong>Estudio</strong><br>
    <?php if ($id != '') { ?>
        <input type="text" name="Vistaestudio<?php echo $id; ?>" id="Vistaestudio<?php echo $id; ?>"
               onkeyup="this.value=this.value.toUpperCase()"
               onfocus="buscarCups(<?php echo $servicio ?>,<?php echo $sede ?>,<?php echo $id ?>)"
               onblur="ValEstudio(<?php echo $servicio ?>,<?php echo $sede ?>,<?php echo $id ?>);"
               style="width:90%; font-family:Arial, Helvetica, sans-serif; font-size:11px;"
               placeholder="Ingresar nombre del estudio o procedimiento"/><span class="asterisk">*</span>
    <?php } else { ?>
        <input type="text" name="Vistaestudio" id="Vistaestudio"
               onkeyup="this.value=this.value.toUpperCase()"
               onfocus="buscarCups(<?php echo $servicio ?>,<?php echo $sede ?>);"
               onblur="ValEstudio(<?php echo $servicio ?>,<?php echo $sede ?>);"
               style="width:90%; font-family:Arial, Helvetica, sans-serif; font-size:11px;"
               placeholder="Ingresar nombre del estudio o procedimiento"/><span class="asterisk">*</span>

    <?php
    }
}*/
?>