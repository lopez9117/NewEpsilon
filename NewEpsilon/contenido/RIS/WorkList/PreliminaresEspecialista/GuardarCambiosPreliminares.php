<title>.: Guardando Cambios :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.cargarResultados()">
<table width="50%" border="0" align="center" style="margin-top:20%;">
  <tr>
    <td><img src="../../styles/images/MnyxU.gif" width="64" height="64" />
    </td>
    <td>
    	<strong><h3>Guardando los cambios, por favor espere...</h3></strong>
    </td>
  </tr>
</table>
</body>
<?php 
//archivo de conexion
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//declaracion de variables
$informe = $_POST['informe'];
$idInforme = $_POST['idInforme']; 
$usuario = $_POST['usuario']; 
$adicional = $_POST['adicional']; 
$firma_respaldo = $_POST['firmaRespaldo'];

//modificar contenido del estudio
mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$informe', adicional = '$adicional' WHERE id_informe = '$idInforme'", $cn);
echo '<script language="javascript">
setTimeout(location.href = "InformePreliminar.php?informe='.base64_encode($idInforme).'&usuario='.base64_encode($usuario).'", 2000);
	</script>';
?>
</body>