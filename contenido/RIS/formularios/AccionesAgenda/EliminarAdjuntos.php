<?php
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$Idinforme = $_POST['id_informe'];
$adjunto = $_POST['adjunto'];
$consultareliminar = mysql_query("SELECT * FROM r_adjuntos WHERE id_adjunto = '$adjunto'",$cn);
$rowconsulteliminar = mysql_fetch_array($consultareliminar);
$ruta = $rowconsulteliminar['adjunto']; //puedes usar dobles comillas si quieres
$vector=explode('/',$ruta);
$tamaño=count($vector);
$dir=$vector[$tamaño-1];
$url='../inserts/uploads/';
$dir=$url.$dir;
//echo $dir;
if(file_exists($dir))
{
    if(unlink($dir))
        print "";
}
mysql_query("DELETE FROM r_adjuntos WHERE id_informe = '$Idinforme' AND id_adjunto = '$adjunto'", $cn);
$sqladjuntos = mysql_query("SELECT * FROM r_adjuntos WHERE id_informe = '$Idinforme'", $cn);
$numsrowadjuntos = mysql_num_rows($sqladjuntos);
if ($numsrowadjuntos >= 1) {
?>
<td id="archivos_adjuntos">
    <div class="table">
        <div class="row header blue">
            <div class="cell">
                <strong>Adjunto</strong>
            </div>
            <div class="cell">
                <strong>Acciones</strong>
            </div>
        </div>
        <?php while ($rowadjuntos = mysql_fetch_array($sqladjuntos)) {
            $idestudio = $row['idestudio'];
            echo
            '<div class="row">
              <div class="cell">'; ?>
            <a href="../WorkList/ViewAttached.php?Attached=<?php echo base64_encode($rowadjuntos['id_adjunto']) ?> "
               target="pop-up-adjunto"
               onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img
                    src="../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto" alt="Ver adjunto"/></a>
            <?php echo '</div>
			  <div class="cell">
                <input type="button" value="Eliminar" onclick="EliminarAdjunto(' . $rowadjuntos['id_adjunto'] . ' , ' . $rowadjuntos['id_informe'] . ')"/>
              </div>
            </div>';
        }
        mysql_free_result($sqladjuntos);
        mysql_close($cn);
        ?>
    </div>
    </div>
    <?php } ?>
</td>
