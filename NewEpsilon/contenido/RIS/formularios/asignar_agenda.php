<?php
  require_once("../../../dbconexion/conexion.php");
  $cn = conectarse();
?>
<script language="javascript" type="text/javascript" src="../javascript/ajax.js"></script>
<script language="javascript" src="../../../js/jquery.js" type="text/javascript"></script>
<script language="javascript" src="../../../js/jquery.maskedinput.js" type="text/javascript"></script>
<script language="javascript" src="../../../js/jquery.form.js"></script>
<script language="javascript" src="../js/jquery-ui-1.10.0.custom.min.js"></script>
<script language='javascript'>
$(document).ready(function() {
   // Interceptamos el evento submit
    $('#form, #fat, #busqueda').submit(function() {
    // Enviamos el formulario usando AJAX
        $.ajax({
    type: 'POST',
    url: $(this).attr('action'),
    data: $(this).serialize(),
    // Mostramos un mensaje con la respuesta de PHP
    success: function(data) {
    $('#formulario').html(data);
            }
        })
        return false;
    }); 
});
</script>
<?php
//validar tipo de documento
$sql_t_documento = "SELECT * FROM tipo_documento ORDER BY desc_tipodocumento ASC";
$res_t_documento = mysql_query($sql_t_documento, $cn);
?>

<table width="100%" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0">
   
    <td width="87%" align="left">
    <form name="busqueda" id="busqueda" method="post" action="RegPaciente.php?servicio=<?php echo $servicio?>&fecha=<?php echo $fecha ?>&sede=<?php echo $sede ?>&usuario=<?php echo $usuario ?>">
     <strong>N° de documento: </strong>
    <input name="documento" id="documento" type="text" style="font-size:12px; width:150px; height:15px;"/>
      <input type="submit" name="continuar" id="continuar" value="Continuar"/>
    </form>      
      </td>

     
    <td width="13%" align="center">
   </td>
  
</table>
</td>

</tr>
</table>



<div id="formulario">
</div>