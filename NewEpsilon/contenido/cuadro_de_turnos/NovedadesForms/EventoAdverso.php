<?php
	//incluir archivo que contiene consultas para llenar selects
	include("../select/selects.php");
?>
<script src="../../../js/ajax.js"></script>
<script>

$(document).ready(function() {
// Interceptamos el evento submit
$('#form, #fat, #uno').submit(function() {
// Enviamos el formulario usando AJAX
$.ajax({
type: 'POST',
url: $(this).attr('action'),
data: $(this).serialize(),
// Mostramos un mensaje con la respuesta de PHP
success: function(data) {
$('#resp').html(data);
}
})        
return false;
}); 
}) 

$(function() {
$('.hora').timepicker({ 'timeFormat': 'H:i' });
});
$(function() {
$('.fecha').datepicker({ 'dateFormat': 'yy-mm-dd' });
});
</script>
<form action="InsertsAusentismo/RegEventualidad.php" method="post" name="Ausentismo" id="Ausentismo">
  <table width="80%" border="0" align="center">
    <tr>
      <td colspan="2">Desde:<br>
        <label for="fechadesde"></label>
      <input type="text" name="fechadesde" id="fechadesde" class="fecha" /></td>
      <td width="25%">Cant dias:<br>
        <label for="cantDias"></label>
      <input type="text" name="cantDias" id="cantDias"></td>
      <td width="25%">Tipo de dias: <br><label for="tipoDias"></label>
        <select name="tipoDias" id="tipoDias">
        <option value="">.: Seleccione :.</option>
        <option value="1">Laborales</option>
        <option value="2">Calendario</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">Tipo:<br>
        <select name="tipo" id="tipo">
          <option>.:Seleccione:.</option>
          <?php
					while($rowausentismo = mysql_fetch_array($listaAusentismo))
					{
						echo '<option value="'.$rowausentismo['idtipo'].'">'.$rowausentismo['desc_ausentismo'].'</option>';
					}
				?>
      </select></td>
      <td><label for="funcionario"></label>
      <input type="hidden" name="funcionario" id="funcionario" value="<?php echo $regTurno['idfuncionario']?>" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">Observaciones:</td>
    </tr>
    <tr>
      <td colspan="4"><label for="observacion"></label>
      <textarea name="observacion" id="observacion" cols="60" rows="3"></textarea></td>
    </tr>
    <tr>
      <td width="20%">Soporte: </td>
      <td colspan="3"><input type="file" name="adjunto" id="adjunto"></td>
    </tr>
    <tr>
      <td colspan="2"><input type="button" name="Registrar" id="Registrar" value="Registrar" onclick="RegEventualidad()" >
      <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer"></td>
      <td colspan="2"><div id="respuesta"></div></td>
    </tr>
  </table>
</form>