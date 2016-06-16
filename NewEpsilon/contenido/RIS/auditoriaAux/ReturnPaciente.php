<?php
//conexion a la BD
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
$idInforme = base64_decode($_GET['idInforme']);
$estado = base64_decode($_GET['estadoinforme']);
$user = base64_decode($_GET['user']);
//obtener los datos de la agenda
$sql = mysql_query("SELECT i.id_paciente, i.id_estadoinforme, det.adicional, CONCAT(p.nom1,' ',p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, est.nom_estudio, pri.desc_prioridad, tec.desc_tecnica, es.desc_estado FROM r_informe_header i
INNER JOIN r_detalle_informe det ON det.id_informe = i.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio est ON est.idestudio = i.idestudio
INNER JOIN r_prioridad pri ON pri.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN r_estadoinforme es ON es.id_estadoinforme = i.id_estadoinforme
WHERE i.id_informe = '$idInforme'", $cn);
$reg = mysql_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Regresar estudio :.</title>
<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
</head>
<body>
<script>
function Validar()
{
	var formulario, est_actual, est_devolulcion, idInforme, usuario, observacion;
	formulario = document.devolucion;
	est_actual = formulario.est_actual.value;
	est_devolulcion = formulario.est_devolulcion.value;
	idInforme = formulario.idInforme.value;
	usuario = formulario.usuario.value;
	observacion = formulario.observacion.value;
	//validar campos obligatorios
	if(est_devolulcion=="" || observacion=="" )
	{
		mensaje = "<font color='#FF0000'>Los campos señalados con * son obligatorios</font>";
		document.getElementById('respuesta').innerHTML = mensaje;
	}
	else
	{
		//validar que el estado de devolucion no sea mayor que el actual
		if(est_devolulcion>=est_actual)
		{
			mensaje = "<font color='#FF0000'>Por favor seleccione un estado de devolucion válido</font>";
			document.getElementById('respuesta').innerHTML = mensaje;
		}
		else
		{
			document.devolucion.submit();
		}
	}
}
</script>
<div id="divheader"><strong>Regresar estudio</strong></div>
<fieldset>
<legend><strong>Paciente</strong></legend>
<table width="100%" border="1" rules="all">
<tr class="encabezado">
    <td width="15%"><strong>N° de documento:</strong></td>
    <td width="25%"><strong>Nombres y Apellidos:</strong></td>
    <td width="40%"><strong>Estudio:</strong></td>
    <td width="20%"><strong>Tecnica:</strong></td>
</tr>
<tr>
    <td><?php echo $reg['id_paciente'] ?></td>
    <td><?php echo $reg['paciente'] ?></td>
    <td><?php echo $reg['nom_estudio']?></td>
    <td><?php echo $reg['desc_tecnica']?></td>
</tr>
</table>
</fieldset>
<fieldset>
<legend><strong>Información del proceso</strong></legend>
<table width="100%" border="1" rules="all">
  <tr class="encabezado">
    <td width="40%"><strong>Funcionario:</strong></td>
    <td width="20%"><strong>Tarea:</strong></td>
    <td width="20%"><strong>Fecha:</strong></td>
    <td width="20%"><strong>Hora:</strong></td>
  </tr>
<?php
//consultar los estados en el LOG y los responsables de cada proceso
$sqlDetalles = mysql_query("SELECT DISTINCT(l.id_estadoinforme) AS estado, l.fecha, l.hora,
CONCAT(f.nombres,' ',f.apellidos) AS funcionario, est.desc_estado FROM r_log_informe l
INNER JOIN funcionario f ON l.idfuncionario = f.idfuncionario
INNER JOIN r_estadoinforme est ON est.id_estadoinforme = l.id_estadoinforme
WHERE l.id_informe = '$idInforme'", $cn);
//imprimir los registros encontrados
while($rowDetalles = mysql_fetch_array($sqlDetalles))
{
	echo 
	'<tr>
		<td>'.$rowDetalles['funcionario'].'</td>
		<td>'.$rowDetalles['desc_estado'].'</td>
		<td>'.$rowDetalles['fecha'].'</td>
		<td>'.$rowDetalles['hora'].'</td>
	</tr>';	
}
?>
</table>
</fieldset>
<fieldset>
  <legend><strong>Tareas</strong></legend>
<?php
//crear array asociativo para traer estados de los estudios
$EstadoArray = array( 1 => 'Agendado / Pendiente por realizar', 2 => 'Tomado / Pendiente por Lectura', 3 => 'Leido / Pendiente por transcribir', 4 => 'Transcrito / Pendiente por Aprobar', 5 => 'Aprobado / Pendiente por publicar', 6 => 'Cancelado definitivamente', 7 => 'Pendiente por Reasignar', 8 => 'Publicado', 9 => 'Devuelto por el especialista', 10 => 'Realizado Sin Lectura');
?>
<form name="devolucion" id="devolucion" method="post" action="AccionReturnPaciente.php">
<table width="100%" border="1" rules="all">
  <tr class="encabezado">
    <td width="50%"><strong>Estado actual:</strong></td>
    <td width="50%"><strong>Retornar Hasta:</strong></td>
  </tr>
  <tr>
    <td><select name="est_actual" class="select">
      <?php
        	foreach ($EstadoArray as $valor => $descripcion) 
			{
				if($reg['id_estadoinforme']==$valor)
				{
					echo '<option value="'.$valor.'">'.$descripcion.'</option>';
				}
            }
		?>
    </select><span class="asterisk">*</span></td>
    <td><select name="est_devolulcion" class="select">
    	<option value="">.: Seleccione :.</option>
        <?php
        	foreach ($EstadoArray as $valor => $descripcion) 
			{
				echo '<option value="'.$valor.'">'.$descripcion.'</option>';
			}
			mysql_close($cn);
		?>
    </select><span class="asterisk">*</span>
      <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>" />
      <input type="hidden" name="usuario" id="usuario" value="<?php echo $user ?>" /></td>
  </tr>
  <tr>
    <td colspan="2" class="encabezado"><strong>Observacion:</strong></td>
    </tr>
  <tr>
    <td colspan="2" align="center"><br/><textarea name="observacion" placeholder="Por Favor registre aqui el motivo de la devolucion"></textarea><span class="asterisk">*</span><br/><br/></td>
    </tr>
    <tr>
        <td align="center"><div id="respuesta"></div></td>
        <td align="right"><input type="button" name="button" id="button" value="Enviar" onclick="Validar()"/>
        <input type="reset" name="reset" id="reset" value="Restablecer" /></td>
  	</tr>
</table>
</form>
</fieldset>
</body>
</html>