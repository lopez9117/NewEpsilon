<?php
ini_set( 'display_errors', 1 );
include("../../../dbconexion/conexion.php");
include 'tantaqrcode.php';
$id = $_GET[id];

$codigo='http://www.portalprodiagnostico.com.co/epsilon/contenido/ActivoFijos/formularios/Cons_activos.php?var='.$id;
$qr = new tantaQRCode(); 
$qr->url($codigo);
$filename = $qr->draw( 150, 'testurl', 'png' );

$variable = $id;
?>
<table width="5%" border="0">
  <tr>
    <td colspan="2" align="center"><img src="../../../images/prodiagnostico.png" width="140" height="40" align="center"/></td>
  </tr>
  <tr>
    <td><img src="qrs/<?php echo $filename ?>.png"/> </td>
  </tr>
</table>