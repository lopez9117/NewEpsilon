<?php
include("../../../dbconexion/conexion.php");
$id = $_GET[id];
$variable = $id;
?>
<script type="text/javascript" src="../../../js/jquery.js"></script>    
<script type="text/javascript" src="../../../js/barcode.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#bcTarget").barcode("<?php echo $variable ?>", "code128"); 
});
</script>
<table width="5%" border="0">
  <tr>
  </tr>
  <tr>
    <td><img src="../../../images/prodiagnostico.png" width="87" height="18"/><div id="bcTarget"></div></td>
  </tr>
</table>
