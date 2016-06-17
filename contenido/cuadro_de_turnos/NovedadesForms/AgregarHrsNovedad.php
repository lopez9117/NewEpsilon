<script src="../../../js/jquery.js"></script>
<script>
$(function() {
$('.hora').timepicker({ 'timeFormat': 'H:i' });
});
$(document).ready(function() {
// Interceptamos el evento submit
$('#form, #fat, #AgregateForm').submit(function() {
// Enviamos el formulario usando AJAX
$.ajax({
type: 'POST',
url: $(this).attr('action'),
data: $(this).serialize(),
// Mostramos un mensaje con la respuesta de PHP
success: function(data) {
$('#AgregateNotificacion').html(data);
}
})        
return false;
}); 
}) 
</script>
 <form id="AgregateForm" name="AgregateForm" method="post" action="NovedadesForms/InsertAgregarHoras.php">
  <table width="80%" border="0" align="center">
    <tr>
      <td width="20%">Desde:</td>
      <td width="20%"><label for="desde"></label>
      <input type="text" name="desde" id="desde" value="<?php echo $regTurno[hr_fin]?>"/></td>
      <td width="20%">Hasta:</td>
      <td width="20%"><label for="hasta"></label>
      <input type="text" name="hasta" id="hasta" class="hora" /></td>
      <input type="hidden" name="idTurno" value="<?php echo $idTurno?>" />
      <input type="hidden" name="fecha" value="<?php echo  $regTurno['fecha']?>" />
    </tr>
    <tr>
      <td colspan="2">Observaciones:</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><label for="nota"></label>
      <textarea name="nota" id="nota" cols="60" rows="3"></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="actualizar" id="agregar" value="Agregar">
      <input type="reset" name="Restablecer" id="cerrar" value="Restablecer"></td>
      <td colspan="2"><div id="AgregateNotificacion"></div>
 </td></td>
    </tr>
  </table>
</form>