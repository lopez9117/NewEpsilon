<?php
//archivo de conexion
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//variables GET
$idInforme = base64_decode($_GET['informe']);
$usuario = base64_decode($_GET['usuario']);
//obtener los datos del encabezado para el informe
$sqlHeader = mysql_query("SELECT i.id_informe, i.ubicacion, i.id_paciente, i.idestudio, i.orden, i.id_extremidad, i.idfuncionario_esp, CONCAT(p.nom1,' ', p.nom2,'',
p.ape1,' ', p.ape2) AS nombre, p.fecha_nacimiento, p.edad, e.nom_estudio,t.id_tecnica,
sex.desc_sexo, l.fecha, l.hora, t.desc_tecnica, ex.desc_extremidad,CONCAT(f.nombres,' ', f.apellidos) AS nombres FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN r_extremidad ex ON ex.id_extremidad = i.id_extremidad
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
WHERE i.id_informe = '$idInforme'", $cn);
$regHeader = mysql_fetch_array($sqlHeader);
$especialista = $regHeader['idfuncionario_esp'];
//obtener contenido del informe
$consInforme = mysql_query("SELECT * FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
$regsInforme = mysql_fetch_array($consInforme);
//validar si el especialista requiere de firma de respaldo
$conFirma = mysql_query("SELECT * FROM r_especialista WHERE idfuncionario_esp = '$especialista' AND firma_respaldo = '1' ", $cn);
$regFirma = mysql_num_rows($conFirma);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Informe Preliminar :.</title>
<script type="text/javascript" src="../../../../js/ajax.js"></script>
<script type="text/javascript" src="../../../../js/jquery.js"></script>
<script src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.config.height = 450;
</script>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
background: -moz-linear-gradient(top, rgba(232,232,232,1) 0%, rgba(232,232,232,0.99) 1%, rgba(229,229,229,0.55) 45%, rgba(229,229,229,0) 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(232,232,232,1)), color-stop(1%,rgba(232,232,232,0.99)), color-stop(45%,rgba(229,229,229,0.55)), color-stop(100%,rgba(229,229,229,0))); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* IE10+ */
background: linear-gradient(to bottom, rgba(232,232,232,1) 0%,rgba(232,232,232,0.99) 1%,rgba(229,229,229,0.55) 45%,rgba(229,229,229,0) 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e8e8e8', endColorstr='#00e5e5e5',GradientType=0 ); /* IE6-9 */
}
fieldset
{width:98%;
border-color:#FFF;}
table
{width:100%;
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
}
input.text
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;
width:88%;
}
textarea
{
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
	width:100%;
	height:55px;
	resize:none;
	}
	#lectura{
	height: 350px;
	width: 100%;
	border: 1px solid #ddd;
	background:#FFF;
	overflow-y: scroll;}
	#tecnica{
	height: 70px;
	width: 100%;
	border: 1px solid #ddd;
	background:#FFF;
	overflow-y: scroll;}
</style>
</head>
<body onBeforeUnload="return window.opener.cargarResultados()" class="body">
<form name="Informe" id="Informe" method="post" action="GuardarCambiosPreliminares.php">
<fieldset>
<legend><strong>Informe de Lectura:</strong></legend>
  <table width="100%" border="0">
	  <tr>
		<td width="20%"><strong>Paciente:</strong></td>
		<td width="20%"><strong>N° de documento: </strong><?php echo $regHeader['id_paciente']?></td>
		<td width="20%"><strong>N° de Ingreso: </strong><?php echo $regHeader['orden']?></td>
		<td width="20%"><strong>Edad: </strong><?php echo $regHeader['edad'] ?>(S)</td>
		<td width="20%"><strong>Genero: </strong><?php echo $regHeader['desc_sexo']?></td>
	  </tr>
	  <tr>
		<td><?php echo $regHeader['nombre']?></td>
		<td><strong>Ubicación: </strong> <?php echo $regHeader['ubicacion']?></td>
		<td><strong>Fecha de la cita: </strong><?php echo $regHeader['fecha']?></td>
		<td><strong>Hora de la cita: </strong><?php echo $regHeader['hora']?></td>
		<td><strong>EPS: </strong><?php echo $regHeader['desc_eps']?></td>
	  </tr>
	  <tr>
		<td colspan="2"><strong>Estudio: </strong><?php echo $regHeader['nom_estudio']?></td>
		<td><strong>Tecnica: </strong><?php echo $regHeader['desc_tecnica']?></td>
		<td><strong>Extremidad: </strong><?php echo $regHeader['desc_extremidad']?></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
	    <td colspan="3"><strong>Adicional: </strong>
        <input class="text" type="text" name="adicional" id="adicional" value="<?php echo $regsInforme['adicional']?>" placeholder="Registre aqui las adiciones al estudio" /></td>
	    <td colspan="2"><input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>" />
          <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" />
      </td>
      </tr>
	  <tr>
	    <td colspan="5"><strong>Informe:</strong></td>
      </tr>
	  <tr>
		<td colspan="5"><textarea class="ckeditor" id="informe" name="informe"><?php echo $regsInforme['detalle_informe'] ?></textarea></td>
	  </tr>
	  <tr>
		<td colspan="2"><strong>Leido por</strong> :<?php echo $regHeader['nombres']?></td>
		<td>
			<?php 
			if($regFirma==1)
			{
				$consEspecialista = mysql_query("SELECT e.idfuncionario_esp, e.reg_medico, u.nom_universidad, f.nombres, f.apellidos FROM r_especialista e
				INNER JOIN r_universidad u ON u.iduniversidad = e.iduniversidad
				INNER JOIN funcionario f ON f.idfuncionario = e.idfuncionario_esp
				WHERE e.reg_medico != '' AND e.reg_medico != 2 AND e.firma_respaldo = 2 ORDER BY f.nombres ASC", $cn);
				
				echo '<select name="firmaRespaldo">';
				echo '<option value="">.: Seleccione firma de respaldo :.</option>';
				while($regEspecialista = mysql_fetch_array($consEspecialista))
				{
					echo '<option value="'.$regEspecialista['idfuncionario_esp'].'">'.$regEspecialista['nombres'].'&nbsp;'.$regEspecialista['apellidos'].'</option>';
				}
				echo '</select>';
			}
			?>
		</td>
		<td colspan="2" align="right"><input type="submit" name="button" id="button" value="Guardar Cambios"/></td>
	  </tr>
</table>
</fieldset>
</form>
</body>
</html>