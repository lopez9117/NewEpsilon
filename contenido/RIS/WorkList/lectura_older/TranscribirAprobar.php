<?php
//archivo de conexion
include("../../../../dbconexion/conexion.php");
$cn = Conectarse();
//variables GET
$idInforme = base64_decode($_GET['informe']);
$especialista = base64_decode($_GET['especialista']);
//validar si el usuario es especialista y puede leer el estudio
$SqlPermisos = mysql_query("SELECT idfuncionario_esp FROM r_especialista WHERE idfuncionario_esp = '$especialista'", $cn);
$ResPermisos = mysql_num_rows($SqlPermisos);
if($ResPermisos==0 || $ResPermisos=="")
{
	echo
	'<style type="text/css">
		body
		{font-family:Arial, Helvetica, sans-serif;
		background-color:#999;
		color:#FFF;
		}
		h1
		{font-family:Arial, Helvetica, sans-serif;
		font-size:24px;
		color:#FFF;
		}
		table{margin-top:25%;
		margin-left:10%}
		{
		</style>
		<body>
		<table width="90%" align="center">
		<tr>
		<td>
		<h1>
			Usted no posee permisos para lectura de estudios, por favor verifique su perfil de usuario o contacte al administrador del sistema
		</h1>
		</td>
		</tr>
		</table>
		</body>';
}
else {
//validar si el informe esta en uso o no
	$sql = mysql_query("SELECT e.id_informe, e.idfuncionario,CONCAT(f.nombres,' ', f.apellidos) AS nombres FROM r_estadoventana e
INNER JOIN funcionario f ON f.idfuncionario = e.idfuncionario 
WHERE e.id_informe = '$idInforme' AND e.idfuncionario != '$especialista'", $cn);
	$reg = mysql_num_rows($sql);
	if ($reg == 1) {
		//consultar los datos de la persona que tiene en uso el informe
		$registro = mysql_fetch_array($sql);
		$consEspecialista = mysql_query("SELECT CONCAT(nombres,' ', apellidos) AS nombres FROM funcionario WHERE idfuncionario = '$especialista'", $cn);
		$nombEspecialista = mysql_fetch_array($consEspecialista);
		echo '<style type="text/css">
	body
	{font-family:Arial, Helvetica, sans-serif;
	background-color:#999;
	color:#FFF;
	}
	h1
	{font-family:Arial, Helvetica, sans-serif;
	font-size:24px;
	color:#FFF;
	}
	table{margin-top:20%;
	margin-left:30%}
	{
	</style>
	<body>
	<table width="60%" align="center">
	<tr>
	<td>
	<h1>El informe que intenta abrir esta actualmente en uso por <br>' . $registro['nombres'] . '</h1>
	</td>
	</tr>
	</table>
	</body>';
	} else {
		//realizar conexion con SqlServer para consultar los pacientes del PACS
		require_once("../../../../dbconexion/conexionSqlServer.php");
		//obtener url actual
list($url,$port)=explode(":",$_SERVER['HTTP_HOST']);
if ($url=="www.portalprodiagnostico.com.co" || $url=="pruebas.portalprodiagnostico.com.co" || $url=="portalprodiagnostico.com.co")
{$url="pacs.portalprodiagnostico.com.co";
}else if ($url=="192.168.200.101")
{$url="192.168.200.100";
}
		//obtener los datos del encabezado para el informe
		$sqlHeader = mysql_query("SELECT i.id_informe, i.ubicacion, i.id_paciente, i.orden,CONCAT(p.nom1,' ', p.nom2,
	'<br>',p.ape1,' ', p.ape2) AS nombres, p.edad, e.nom_estudio, pr.desc_prioridad,
	sex.desc_sexo, l.fecha, l.hora, t.desc_tecnica, ex.desc_extremidad, ep.desc_eps FROM r_informe_header i
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio e ON e.idestudio = i.idestudio
	INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
	INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
	INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
	INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
	INNER JOIN r_extremidad ex ON ex.id_extremidad = i.id_extremidad
	INNER JOIN eps ep ON ep.ideps=p.ideps
	WHERE i.id_informe = '$idInforme' AND l.id_estadoinforme = 1", $cn);
		$regHeader = mysql_fetch_array($sqlHeader);
		//obtener el contenido si existe
		$consContenido = mysql_query("SELECT detalle_informe, id_tipo_resultado,adicional FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
		$regsContenido = mysql_fetch_array($consContenido);
		?>
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
			"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<meta http-equiv="Expires" content="0">
			<meta http-equiv="Last-Modified" content="0">
			<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
			<meta http-equiv="Pragma" content="no-cache">
			<title>.: Transcribir y aprobar Informe :.</title>
			<script type="text/javascript" src="../../../../js/ajax.js"></script>
			<script type="text/javascript" src="../../../../js/jquery.js"></script>
			<script type="text/javascript" src="../../fckeditor/fckeditor.js"></script>
			<script src="../../ckeditor/ckeditor.js"></script>
            <link type="text/css" href="../../formularios/css/TablaCss.css" rel="stylesheet" />
			<link rel="stylesheet" type="text/css" href="css/default.css"/>
			<link href="../../ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
			<script type="text/javascript">
				CKEDITOR.config.height = 450
			</script>
			<script language="javascript">
				function Guardar(opcion) {
					if (opcion == "parcial") {
						document.Informe.opcion.value = "parcial";
						document.Informe.submit();
						return window.opener.CargarAgenda();
					}
					else {
						document.Informe.opcion.value = "aprobar";
						document.Informe.submit();
						return window.opener.CargarAgenda();
					}
				}

				function marcarLeido(informe) {
					var informe, usuario;
					usuario = document.Informe.especialista.value;

					opcion = confirm("Marcar como Leido? (El informe estara disponible para transcripción)")
					if (opcion == true) {
						ajax = nuevoAjax();
						//llamado al archivo que va a ejecutar la consulta ajax
						ajax.open("POST", "../acciones/actualizarLecturaPendiente.php", true);
						ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
						ajax.send("informe=" + informe + "&usuario=" + usuario + "&tiempo=" + new Date().getTime());

						setTimeout(window.close, 2000);
					}

				}
			</script>
			<style type="text/css">
				body {
					font-family: Arial, Helvetica, sans-serif;
					font-size: 12px;
					background-color: #999;
					color: #FFF;
				}

				fieldset {
					width: 98%;
					border-color: #FFF;
				}

				table {
					width: 100%;
					font-family: Arial, Helvetica, sans-serif;
					font-size: 12px;
				}

				input.text {
					font-family: Arial, Helvetica, sans-serif;
					font-size: 12px;
					width: 88%;
				}

				textarea {
					font-family: Verdana, Geneva, sans-serif;
					font-size: 12px;
					width: 100%;
					height: 55px;
					resize: none;
				}
			</style>
			<script language="javascript">
				function Cargar(informe, especialista) {
					var informe, especialista;
//Codigo ajax para enviar datos al servidor y obtener respuesta
//etiqueta donde se va a mostrar la respuesta
					ajax = nuevoAjax();
//llamado al archivo que va a ejecutar la consulta ajax
					ajax.open("POST", "RegistroVentana.php", true);
					ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					ajax.send("informe=" + informe + "&especialista=" + especialista + "&tiempo=" + new Date().getTime());
				}

				document.write('<style type="text/css">div.cp_oculta{display: none;}</style>');
				function MostrarOcultar(capa, enlace) {
					if (document.getElementById) {
						var aux = document.getElementById(capa).style;
						aux.display = aux.display ? "" : "block";
					}

				}
				document.write('<style type="text/css">div.cp_oculta{display: none;}</style>');
				function MostrarOcultar(capa, enlace) {
					if (document.getElementById) {
						var aux = document.getElementById(capa).style;
						aux.display = aux.display ? "" : "block";
					}
				}
			</script>
		</head>
		<body onBeforeUnload="return window.opener.ventanaEmergente('<?php echo $idInforme ?>')"
			  onload="Cargar(<?php echo $idInforme ?>, <?php echo $especialista ?>)">
		<form name="Informe" id="Informe" method="post" action="../acciones/AccionLecturaTranscripcion.php">
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
						<td><?php echo $regHeader['nombres']?></td>
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
						<td colspan="2"><strong>Adicional: </strong>
							<input class="text" type="text" name="adicional" id="adicional"
								   value="<?php echo $regsContenido['adicional']?>"
								   placeholder="Registre aqui las adiciones al estudio"/></td>
						<td>&nbsp;</td>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5"><textarea class="ckeditor" cols="150" id="ResultadoInforme"
												  name="ResultadoInforme"
												  rows="20"><?php echo $regsContenido['detalle_informe']?></textarea>

						</td>
					</tr>
					<tr>
						<td colspan="2"><strong>Este estudio sera leido por</strong>
							: <?php echo $nombEspecialista['nombres']?>
							<input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>"/>
							<input type="hidden" name="especialista" id="especialista"
								   value="<?php echo $especialista ?>"/>
							<input type="hidden" name="opcion"/></td>
						<td>
							<?php
							//consultar tipo de resultado
							$consTipoResultado = mysql_query("SELECT * FROM r_tipo_resultado", $cn);
							?>
							<select name="tipoResultado">
								<option value="0">.: Seleccione :.</option>
								<?php
								while ($rowTipo = mysql_fetch_array($consTipoResultado)) {
									?>
									<option value="<?php echo $rowTipo['id_tipo_resultado']?>"
										<?php
										if ($rowTipo['id_tipo_resultado'] == $regsContenido['id_tipo_resultado']) {
											echo 'selected="selected"';
										}
										?>><?php echo $rowTipo['desc_tipo_resultado'] ?></option>
								<?php
								}
								?>
							</select>
						</td>
						<td colspan="2" align="right">
							<input type="button" name="Marcar como leido" id="Marcar como leido"
								   value="Marcar como Leido" onclick="marcarLeido('<?php echo $idInforme ?>')"/>
							<input type="button" name="button" id="button" value="Guardar Parcial"
								   onclick="Guardar('parcial')"/>
							<input type="button" name="button2" id="button2" value="Guardar y Aprobar"
								   onclick="Guardar('aprobar')"/></td>
					</tr>
				</table>
			</fieldset>
		</form>
			<table width="100%" align="center">
					<tr><td>
							<?php
							//consultar imagenes del paciente
							$sql = "SELECT DISTINCT(s.StudyInstanceUid),s.PatientId,s.StudyDate,s.StudyTime,CONCAT(s.StudyDate,' ',s.StudyTime) AS fecha,se.Modality,s.StudyDescription,ser.AeTitle FROM Study s
    INNER JOIN Series se ON s.GUID = se.StudyGUID
    INNER JOIN ServerPartition ser ON s.ServerPartitionGUID=ser.GUID
    WHERE s.PatientId='$regHeader[id_paciente]' AND AeTitle != 'PACSNORTE' ORDER BY fecha ASC;";
							$params = array();
							$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
							$stmt = sqlsrv_query( $conn, $sql , $params, $options );
							$row_count = sqlsrv_num_rows( $stmt );
							if ($row_count >= 1) {?>
					<center>
    <div class="table">
            <div class="row header blue">
              <div class="cell">
                <strong>Paciente</strong>
              </div>
              <div class="cell">
                <strong>Sede</strong>
              </div>
              <div class="cell">
                <strong>Servicio</strong>
              </div>
              <div class="cell">
                <strong>Descripción</strong>
              </div>
              <div class="cell">
                <strong>Fecha / Hora</strong>
              </div>
              <div class="cell">
                <strong>Imágenes</strong>
              </div>
            </div>
				<?php	while ($rowimages = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
					$UI = $rowimages['StudyInstanceUid'];$fecha = date("Y-m-d", strtotime($rowimages['StudyDate']));list($HoraReal)=explode(".",$rowimages['StudyTime']);$Hora = date("H:i:s", strtotime($HoraReal));
					if ($rowimages['AeTitle']=="PACSNORTE_LL"){$SedeImages="Fundación Clínica del Norte";}else if ($rowimages['AeTitle']=="PACS_MFS"){$SedeImages="Hospital Marco Fidel Suarez";}else if ($rowimages['AeTitle']=="PACS_L13"){$SedeImages="IPS Clínica León XIII";}else if ($rowimages['AeTitle']=="PACS_CQN"){$SedeImages="Clínica Conquistadores";}else if ($rowimages['AeTitle']=="PACS_BLL"){$SedeImages="Barranquilla";}else if ($rowimages['AeTitle']=="PACS_CALDAS"){$SedeImages="Hospital San Vicente de Paul Caldas";}else if ($rowimages['AeTitle']=="PACS_AMB"){$SedeImages="IPS Universitaria Ambulatoria";}
					if ($rowimages['Modality']=="CT"){$modality="Tomografía Axial Computarizada";}else if ($rowimages['Modality']=="CR"){$modality="Rayos X Convencional";}else if ($rowimages['Modality']=="DX"){$modality="Rayos X Convencional";}else if ($rowimages['Modality']=="MG"){$modality="Mamografía";}else if ($rowimages['Modality']=="MR"){$modality="Resonancia Magnética";}else if ($rowimages['Modality']=="RF"){$modality="Estudios Especiales";}else if ($rowimages['Modality']=="US"){$modality="Ecografía";}else if ($rowimages['Modality']=="XA"){$modality="Rayos X Convencional";}

					echo
			'<div class="row" >
              <div class="cell" style="color:black">
                ' . $rowimages['PatientId'] . '
              </div>
              <div class="cell" style="color:black">
                ' . $SedeImages . '
              </div>
              <div class="cell" style="color:black">
                ' . $modality . '
              </div>
			  <div class="cell" style="color:black">
                ' . $rowimages['StudyDescription'] . '
              </div>
			  <div class="cell" style="color:black">
                ' . $fecha . '<br/>' . $Hora . '
              </div>
			  <div class="cell" style="color:black">'; ?>
                <a href="http://<?php echo $url?>/ImageServer/Pages/Login/Default.aspx?origen='RIS'&user='PRODIAGNOSTICO'&pass='clearcanvas'&ReturnUrl=%2fImageServer%2fPages%2fStudies%2fView%2fDefault.aspx%3faetitle%3d<?php echo $aetitle?>%2cstudy%3d<?php echo $UI?>&aetitle=<?php echo $aetitle?>,study=<?php echo $UI?>" target="imagen" onClick="window.open(this.href, this.target, width=600,height=800); return false;"><img src="../../../../images/x-ray.png" width="15" height="15" title="Ver Imagen" alt="Ver Imagen" /></a>
              <?php 
			  echo '</div>
            </div>';
					}
					sqlsrv_free_stmt( $stmt);
					?>
                    </div>
</center>
                    <?php
				}
				?>
				</td>
				<td>
					<?php
					//consultar imagenes del paciente
					$sqlagenda = mysql_query("SELECT DISTINCT(i.id_informe), i.id_paciente,e.nom_estudio, l.fecha, l.hora, se.descsede
FROM r_informe_header i
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN sede se ON se.idsede = i.idsede
WHERE i.id_estadoinforme = '8' AND l.id_estadoinforme = '8' AND i.id_paciente='$regHeader[id_paciente]' ORDER BY fecha ASC", $cn);
$row_contador = mysql_num_rows($sqlagenda);
					if ($row_contador >= 1) {?>
					<div class="table">
            <div class="row header blue">

              <div class="cell">
                <strong>Resultados</strong>
              </div>
            </div>
				<?php	while($reg =  mysql_fetch_array($sqlagenda))
					{
						echo
				'<div class="row" >
			  <div class="cell" style="color:black">'; ?>
						<a href="../../Resultados/Vistaimpresion.php?informe=<?php echo base64_encode($reg['id_informe']) ?>" target="Ventana" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../../images/fileprint.png" width="20" height="20" alt="Imprimir Informe" title="Transcribir Imprimir"></a>
						<?php
			echo '</div>
            </div>';
		}
		?>
                    </div>
</center>
                    <?php
	}
	?>
				</td>
				<tr/>
			</table>
		<table width="100%" align="center">
			<tr>
				<td width="100%"><a class="texto" href="javascript:MostrarOcultar('observaciones');">Ver / Ocultar todas
						las observaciones</a></td>
			</tr>
		</table>
		<div class="cp_oculta" id="observaciones">
			<table width="100%" align="center">
				<?php
				//consultar observaciones realizadas en el informe
				$sqlObservacion = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, CONCAT(f.nombres,' ', f.apellidos) as nombres
FROM r_observacion_informe o
INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
WHERE o.id_informe = '$idInforme'", $cn);
				$conObservacion = mysql_num_rows($sqlObservacion);
				if ($conObservacion == 0 || $conObservacion == "") {
					echo '<tr>
		<td>No se han registrado observaciones</td>
	</tr>';
				} else {
					while ($rowObservacion = mysql_fetch_array($sqlObservacion)) {
						?>
						<tr>
							<td>
								<fieldset>
									<legend><strong> <?php echo $rowObservacion['nombres']?> </strong>hizo la siguiente
										observación, las <?php echo $rowObservacion['hora']?>
										del <?php echo $rowObservacion['fecha']?></legend>
									<label for="area"></label>
									<textarea name="area" id="area" cols="45" rows="5"
											  readonly="readonly"><?php echo $rowObservacion['observacion'] ?></textarea>
								</fieldset>
							</td>
						</tr>
					<?php
					}
				}
				?>
			</table>
		</div>
		<!-- mostrar observaciones por devolucion -->
		<table width="100%" align="center">
			<tr>
				<td width="100%"><a class="texto" href="javascript:MostrarOcultar('devoluciones');">Ver / Ocultar todas
						las observaciones por devolución</a></td>
			</tr>
		</table>
		<div class="cp_oculta" id="devoluciones">
			<table width="100%" align="center">
				<?php
				//consultar observaciones realizadas en el informe
				$sqlObservacionDevolucion = mysql_query("SELECT ed.usuario, ed.fecha, ed.comentario, md.desc_motivo, CONCAT(f.nombres,' ',f.apellidos) AS funcionario
FROM r_estudiodevuelto ed
INNER JOIN r_motivodevolucion md ON md.idmotivo = ed.idmotivo
INNER JOIN funcionario f ON f.idfuncionario = ed.usuario
WHERE ed.id_informe = '$idInforme'", $cn);
				$conObservacionDevolucion = mysql_num_rows($sqlObservacionDevolucion);
				if ($conObservacionDevolucion == 0 || $conObservacionDevolucion == "") {
					echo '<tr>
		<td>No se han registrado observaciones</td>
	</tr>';
				} else {
					while ($rowObservacionDevolucion = mysql_fetch_array($sqlObservacionDevolucion)) {
						?>
						<tr>
							<td>
								<fieldset>
									<legend><strong> <?php echo $rowObservacionDevolucion['funcionario']?> </strong>hizo
										la siguiente observación el s<?php echo $rowObservacionDevolucion['fecha']?>
									</legend>
									<label for="area"></label>
									<textarea name="area" id="area" cols="45" rows="5"
											  readonly="readonly"><?php echo $rowObservacionDevolucion['comentario'] ?></textarea>
								</fieldset>
							</td>
						</tr>
					<?php
					}
				}
				?>
			</table>
		</div>
		</body>
		</html>
	<?php
	}
}
?>