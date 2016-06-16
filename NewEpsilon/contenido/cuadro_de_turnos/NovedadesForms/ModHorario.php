<script>
$(function() {
$('.hora').timepicker({ 'timeFormat': 'H:i' });
});
$(document).ready(function() {
// Interceptamos el evento submit
$('#form, #fat, #UpdateTime').submit(function() {
// Enviamos el formulario usando AJAX
$.ajax({
type: 'POST',
url: $(this).attr('action'),
data: $(this).serialize(),
// Mostramos un mensaje con la respuesta de PHP
success: function(data) {
$('#NotificacionUpdateTime').html(data);
}
})        
return false;
}); 
}) 
</script>
<form id="UpdateTime" name="UpdateTime" method="post" action="NovedadesForms/UpdateHorario.php">
  <table width="80%" border="0" align="center">
    <tr>
      <td width="15%">Desde:</td>
      <td width="25%"><label for="desde"></label>
      <input type="text" name="desde" id="desde" class="hora" />*</td>
      <td width="15%">Hasta:</td>
      <td width="25%"><label for="hasta"></label>
      <input type="text" name="hasta" id="hasta" class="hora" />*</td>
    </tr>
    <tr>
      <td colspan="2">Observaciones:</td>
      <td>&nbsp;</td>
      <td><input type="hidden" name="idTurno" value="<?php echo $idTurno?>" />
     </td>
    </tr>
    <tr>
      <td colspan="4"><label for="nota"></label>
      <textarea name="nota" id="nota" cols="60" rows="3"></textarea></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" name="actualizar" id="actualizar" value="Actualizar">
      <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer"></td>
      <td colspan="2"><div id="NotificacionUpdateTime"></div>
 </td></td>
    </tr>
  </table>
</form>