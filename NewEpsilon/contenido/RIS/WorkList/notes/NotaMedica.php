<?php
//conexion a la BD
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idInforme = base64_decode($_GET['idInforme']);
$usuario = base64_decode($_GET['usuario']);
//obtener los datos de la agenda
$sql = mysql_query("SELECT l.hora, l.id_informe, l.fecha, i.id_paciente, i.idestudio, i.id_prioridad, i.id_extremidad, i.id_tecnica,i.ubicacion, i.idservicio,
CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS nombre, es.nom_estudio, pr.desc_prioridad, t.desc_tecnica FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
WHERE i.id_informe = '$idInforme'", $cn);
$reg = mysql_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Notas Medicas :.</title>
<style type="text/css">
body
{font-family:Arial, Helvetica, sans-serif;
font-size:12px;}
fieldset
{width:95%;
}
</style>
<script language="JavaScript" src="../../../../js/ajax.js"></script>
<script language="javascript">
function enviarObservacion()
{
	//declarar variables
	usuario = document.observacion.usuario.value;
	informe = document.observacion.informe.value;
	observacion = document.observacion.observacion.value;
	//validar campos obligatorios
	if(observacion=="")
	{
		mensaje = "<font color='#FF0000'><strong>Por favor escriba su observación y/o comentario</strong></font>";
		document.getElementById('respuesta').innerHTML = mensaje;			
	}
	else
	{
		mensaje = "";
		document.getElementById('respuesta').innerHTML = mensaje;
		
		document.observacion.submit();
	}
}
</script>
</head>
<body>
<form id="observacion" name="observacion" method="post" action="AccionAddNotaMedica.php">
<fieldset>
<legend><strong>Notas medicas</strong></legend>
<table width="100%" border="0" align="center">
<tr>
  <td colspan="2" bgcolor="#CCCCCC" style="color:#333"><strong>Paciente:</strong></td>
  </tr>
<tr>
  <td>N° de identificacion: <strong><?php echo $reg['id_paciente'] ?></strong></td>
  <td>Nombres y Apellidos: <strong><?php echo $reg['nombre'] ?></strong></td>
</tr>
<tr>
  <td colspan="2" bgcolor="#CCCCCC" style="color:#333"><strong>Información del estudio:</strong>&nbsp;</td>
  </tr>
<tr>
  <td>Estudio: <strong><?php echo $reg['nom_estudio']?></strong></td>
  <td>Tecnica: <strong><?php echo $reg['desc_tecnica']?></strong></td>
</tr>
<tr>
  <td>Fecha y hora: <strong><?php echo $reg['fecha'] ?></strong> / <strong><?php echo $reg[hora]?></strong></td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td colspan="2" bgcolor="#CCCCCC" style="color:#333"><strong>Nota:</strong></td>
</tr>
<tr>
  <td colspan="2"><textarea name="observacion" placeholder="Registre aqui sus notas" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="6" cols="60"></textarea></td>
</tr>
<tr>
  <td width="50%"><input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" />
  <input type="hidden" name="informe" id="informe" value="<?php echo $idInforme ?>" /><div id="respuesta"></div></td>
  <td width="50%" align="right"><input type="button" value="Guardar Nota" onClick="enviarObservacion()" /></td>
</tr>
</table>
</fieldset>
</form>
<!-- Mostrar las notas registradas por el especialista -->
<fieldset>
<legend><strong>Notas:</strong></legend>
<?php
//consultar cantidad de notas
$sqlComentario = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, CONCAT(f.nombres,' ',f.apellidos) AS especialista, e.url_firma
FROM r_observacion_informe o
INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
INNER JOIN r_especialista e ON e.idfuncionario_esp = o.idfuncionario
WHERE o.id_informe = '$idInforme' AND id_tipocomentario = '4'", $cn);
$regComentario = mysql_num_rows($sqlComentario);
echo '<table width="100%" border="0" align="center">';
if($regComentario==0 || $regComentario=="")
{
	echo '<tr><td>No se han registrado notas aun...</td></tr>';
}
else
{
	while($rowComentario = mysql_fetch_array($sqlComentario))
	{
		echo '<tr>
		<td><strong>'.$rowComentario['especialista'].'</strong> Realizó la siguiente nota a las: <strong>'.$rowComentario['hora'].'</strong> del <strong>'.$rowComentario['fecha'].'</strong><div><textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">'.$rowComentario['observacion'].'</textarea><img src="../../images/'.$rowComentario['url_firma'].'" width="150" height="35" align="right"></img></div></td>
		</tr>';
	}	
}
echo '</table>';
?>
</fieldset>
</body>
</html>