<?php
//conexion a la bd
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$consEncuestas = mysql_query("SELECT * FROM e_nombencuesta WHERE idestado_actividad = '1' ORDER BY nomencuesta ASC", $cn);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
	<link href="../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
	<script src="../../../js/jquery-1.9.1.js"></script>
	<script src="../../../js/jquery-ui-1.10.3.custom.js"></script>
	<script type="text/javascript">
	jQuery.noConflict();
	jQuery(function() {
	jQuery( "#accordion" ).accordion();
	});
	</script>
	<style>
	body{
	font: 62.5% "Trebuchet MS", sans-serif;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	}
	img
	{
		border:none;
		width:16px;
		height:16px;
		}
		
	.menuHeader
	{position:inherit;
	}
	</style>
</head>
<body>
<table width="95%" align="center">
<tr>
	<td>
    <div id="accordion">
		<h3>Encuestas</h3>
		<div>
        	<?php
            	while($rowEncuestas = mysql_fetch_array($consEncuestas))
				{
					echo '<p><a href="../Poll.php?idEncuesta='.base64_encode($rowEncuestas['idnombencuesta']).'" target="content" style="cursor:pointer;">'.$rowEncuestas['nomencuesta'].'</a></p>';
				}
			?>
		</div>
        <h3>Estadisticas</h3>
		<div>
	  		<p><a href="../Graphics/SatisfaccionGlobal.php" target="content" style="cursor:pointer;">Satisfacción global</a></p>
            <p><a href="../Graphics/SatisfaccionSedePregunta.php" target="content" style="cursor:pointer;">Satisfacción por sede y servicio</a></p>
            <p><a href="../Graphics/VerComentarios.php" target="content" style="cursor:pointer;">Comentarios</a></p>
             <p><a href="../Graphics/SatisfaccionUsuarios.php" target="content" style="cursor:pointer;">Usuarios Satisfechos</a></p>
              <p><a href="../Graphics/SatisfaccionUsuariosPeriodico.php" target="content" style="cursor:pointer;">Usuarios Satisfechos Periodos</a></p>
		</div>
        <h3>Resultados</h3>
		<div>
	  		<p><a href="../Contenido/VerEncuestas.php" target="content" style="cursor:pointer;">Ver encuestas</a></p>
		</div>
    </div>
    </td>
</table>
</body>
</html>