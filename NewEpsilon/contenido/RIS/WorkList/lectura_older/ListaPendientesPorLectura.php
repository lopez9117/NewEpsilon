<?php
//Conexion a la base de datos
require_once('../../../../dbconexion/conexion.php');
require_once('../../../../dbconexion/conexionSqlServer.php');
//funcion para abrir conexion
$cn = Conectarse();
$fechaDesde = $_GET['fechaDesde'];
$fechaHasta = $_GET['fechaHasta'];
$sede = $_GET['sede'];
$servicio = $_GET['servicio'];
$usuario = $_GET['usuario'];
$fechaDesde = date("Y-m-d", strtotime($fechaDesde));
$fechaHasta = date("Y-m-d", strtotime($fechaHasta));
//obtener url actual
list($url,$port)=explode(":",$_SERVER['HTTP_HOST']);
if ($url=="www.portalprodiagnostico.com.co" || $url=="pruebas.portalprodiagnostico.com.co" || $url=="portalprodiagnostico.com.co")
{$url="pacs.portalprodiagnostico.com.co";
}else if ($url=="192.168.200.101")
{$url="192.168.200.100";
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tabla_listado_pacientes').dataTable({ //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers",
            "aaSorting": [[7, "asc"]], "aoColumns": [null, null, null, null, null, null, null, null,null]
        });
    });
</script>
<table width="100%">
    <tr bgcolor="#E1DFE3">
        <td><strong>Estudios pendientes por lectura</strong></td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_pacientes">
    <thead>
    <tr>
        <th align="left" width="8%">Id</th>
        <th align="left" width="15%">Paciente</th>
        <th align="left" width="30%">Estudio</th>
        <th align="left" width="10%">Tecnica</th>
        <th align="left" width="10%">T.Paciente</th>
		<th align="left" width="10%">Ubicacion</th>
        <th align="center" width="5%">Prioridad</th>
        <th align="center" width="5%">Fecha/Hora Estudio Tomado</th>
        <th align="center" width="12%">Tareas</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </tfoot>
    <tbody>
    <?php
    //validar el tipo de lista que se debe de mostrar
    $consLista = mysql_query("SELECT * FROM r_conf_lista_lectura WHERE idsede = '$sede' AND idservicio = '$servicio' AND idestado_actividad = '2'", $cn);
    $regsLista = mysql_num_rows($consLista);
    //si la lista es restringida
    if ($regsLista >= 1)
    {
    //consultar todos los estudios disponibles para el usuario especificado
    $sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente,CONCAT(p.nom1,' ', p.nom2,' ',
p.ape1,' ', p.ape2) AS nombre ,e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad, tp.desctipo_paciente,i.idtipo_paciente, tec.desc_tecnica,i.ubicacion,se.AE_TITLE
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad 
INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN sede se ON se.idsede=i.idsede
WHERE i.id_estadoinforme = '2' AND i.idfuncionario_esp = '$usuario' AND i.idsede = '$sede' AND i.idservicio = '$servicio' 
AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY i.id_informe", $cn);
    while ($reg = mysql_fetch_array($sqlagenda))
    {
    //Codificar variables para pasar por URL
    $idInforme = base64_encode($reg['id_informe']);
    $idtipopaciente = $reg['idtipo_paciente'];
    $informeid=$reg['id_informe'];
    $constyle = mysql_query("SELECT IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) < '06:00:00' ,'style=\"background:#F78181\"',
                                IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) BETWEEN '06:00:00' AND '12:00:00','style=\"background:#F3F781\"',
                                IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) > '12:00:00','',''))) AS style", $cn) or mysql_error();

    $regstyle = mysql_fetch_array($constyle);
    $style = $regstyle['style'];
    $user = base64_encode($usuario);
    $Fecha = $reg['fecha'];
    $aetitle = $reg['AE_TITLE'];
    $sql = "SELECT DISTINCT(s.StudyInstanceUid),s.PatientId,s.StudyDate,s.StudyTime,se.Modality,s.StudyDescription,ser.AeTitle FROM Study s
    INNER JOIN Series se ON s.GUID = se.StudyGUID
    INNER JOIN ServerPartition ser ON s.ServerPartitionGUID=ser.GUID
    WHERE s.StudyInstanceUid='$reg[id_informe]' AND ser.AeTitle='$aetitle'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql , $params, $options );
    $row_count = sqlsrv_num_rows( $stmt );
    echo '<tr>';
    echo '<td align="left" ' . $style . '>' . $reg['id_paciente'] . '</td>';
    echo '<td align="left" ' . $style . '>' . ucwords(strtolower($reg['nombre'])) . '</td>';
    echo '<td align="left">' . ucwords(strtolower($reg['nom_estudio'])) . '</td>';
    echo '<td align="left">' . ucwords(strtolower($reg['desc_tecnica'])) . '</td>';
    echo '<td align="left">' . ucwords(strtolower($reg['desctipo_paciente'])) . '</td>';
	echo '<td align="left">' . ucwords(strtolower($reg['ubicacion'])) . '</td>';
    echo '<td align="center">' . ucwords(strtolower($reg['desc_prioridad'])) . '</td>';
    echo '<td align="center">' . $Fecha . '<br>' . $reg['hora'] . '</td>';
    echo '<td align="center">';
    echo '<table>
	<tr>';
    $sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
	INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$reg[id_informe]'", $cn);
    $count = mysql_num_rows($sqlAdjunto);
    //Validar si se tienen archivos adjuntos.
    if ($count >= 1) {
        echo '<td>';
        while ($regAdjunto = mysql_fetch_array($sqlAdjunto)) {
            ?>
            <a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto']) ?>" target="orden"
               onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img
                    src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto"
                    alt="Ver adjunto"/></a>
        <?php
        }
        echo '</td>';
    } else {
        echo '<td>&nbsp;</td>';
    }?>
    <td>
        <a href="TranscribirAprobar.php?informe=<?php echo $idInforme?>&especialista=<?php echo $user ?>"
           target="transcripcion"
           onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img
                src="../../../../images/kate.png" width="15" height="15" title="Transcribir/Aprobar Estudios"
                alt="Transcribir/Aprobar Estudios"/></a>
    </td>
    <td><a href="DevolverEstudio.php?idInforme=<?php echo $idInforme?>&usuario=<?php echo $user ?>" target="pop-up"
           onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img
                src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio"
                alt="Regresar Estudio"/></a></td>
    <td><a href="../notes/NotaMedica.php?idInforme=<?php echo $idInforme?>&usuario=<?php echo $user ?>" target="pop-up"
           onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img
                src="../../../../images/dokter.png" width="15" height="15" title="Nota Medica" alt="Nota Medica"/></a>
    </td>
    <td>
        <a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe'])?>&amp;usuario=<?php echo base64_encode($_GET['usuario'])?>"
           target="pop-up"
           onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img
                src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso"
                alt="Registrar Evento Adverso"/></a>
    </td>
	
    <?php
    if ($row_count==1)
    {
    $stmt = sqlsrv_query( $conn, $sql );
    $row = sqlsrv_fetch_array($stmt);
    $UI = $row['StudyInstanceUid'];
    ?>
    <td align="center"><a href="http://<?php echo $url?>/ImageServer/Pages/Login/Default.aspx?origen='RIS'&user='PRODIAGNOSTICO'&pass='clearcanvas'&ReturnUrl=%2fImageServer%2fPages%2fStudies%2fView%2fDefault.aspx%3faetitle%3d<?php echo $aetitle?>%2cstudy%3d<?php echo $UI?>&aetitle=<?php echo $aetitle?>,study=<?php echo $UI?>" target="imagen" onClick="window.open(this.href, this.target, width=600,height=800); return false;"><img src="../../../../images/x-ray.png" width="15" height="15" title="Ver Imagen" alt="Ver Imagen" /></a></td>
    <?php } ?>
    </tr>
</table>

<?php
}
}
else {
    //consultar todos los estudios disponibles para el usuario especificado
    $sqlagenda = mysql_query("SELECT i.id_informe, i.id_paciente,CONCAT(p.nom1,' ', p.nom2,' ',
p.ape1,' ', p.ape2) AS nombre ,e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad, tp.desctipo_paciente,i.idtipo_paciente, tec.desc_tecnica,i.ubicacion,se.AE_TITLE
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN sede se ON se.idsede=i.idsede
	WHERE i.id_estadoinforme = '2' AND i.idfuncionario_esp = '' AND i.idsede = '$sede' AND i.idservicio = '$servicio' 
	AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY i.id_informe", $cn);
    while ($reg = mysql_fetch_array($sqlagenda)) {
        //Codificar variables para pasar por URL
        $idInforme = base64_encode($reg['id_informe']);
        $idtipopaciente = $reg['idtipo_paciente'];
        $informeid=$reg['id_informe'];
        $constyle = mysql_query("SELECT IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) < '06:00:00' ,'style=\"background:#F78181\"',
                                IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) BETWEEN '06:00:00' AND '12:00:00','style=\"background:#F3F781\"',
                                IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) > '12:00:00','',''))) AS style", $cn) or mysql_error();

        $regstyle = mysql_fetch_array($constyle);
        $style = $regstyle['style'];
        $user = base64_encode($usuario);
        $Fecha = $reg['fecha'];
        $aetitle = $reg['AE_TITLE'];
		$sql = "SELECT DISTINCT(s.StudyInstanceUid),s.PatientId,s.StudyDate,s.StudyTime,se.Modality,s.StudyDescription,ser.AeTitle FROM Study s
		INNER JOIN Series se ON s.GUID = se.StudyGUID
		INNER JOIN ServerPartition ser ON s.ServerPartitionGUID=ser.GUID
		WHERE s.StudyInstanceUid='$reg[id_informe]' AND ser.AeTitle='$aetitle'";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt = sqlsrv_query( $conn, $sql , $params, $options );
		$row_count = sqlsrv_num_rows( $stmt );
        echo '<tr>';
        echo '<td align="left" ' . $style . '>' . $reg['id_paciente'] . '</td>';
        echo '<td align="left" ' . $style . '>' . ucwords(strtolower($reg['nombre'])) . '</td>';
        echo '<td align="left">' . ucwords(strtolower($reg['nom_estudio'])) . '</td>';
        echo '<td align="left">' . ucwords(strtolower($reg['desc_tecnica'])) . '</td>';
        echo '<td align="left">' . ucwords(strtolower($reg['desctipo_paciente'])) . '</td>';
		echo '<td align="left">' . ucwords(strtolower($reg['ubicacion'])) . '</td>';
        echo '<td align="center">' . ucwords(strtolower($reg['desc_prioridad'])) . '</td>';
        echo '<td align="center">' . $Fecha . '<br>' . $reg['hora'] . '</td>';
        echo '<td align="center">';
        echo '<table>
		<tr>';
        $sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
		INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$reg[id_informe]'", $cn);
        $count = mysql_num_rows($sqlAdjunto);
        //Validar si se tienen archivos adjuntos.
        if ($count >= 1) {
            echo '<td>';
            while ($regAdjunto = mysql_fetch_array($sqlAdjunto)) {
                ?>
                <a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto']) ?>"
                   target="orden"
                   onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img
                        src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto"
                        alt="Ver adjunto"/></a>
            <?php
            }
            echo '</td>';
        } else {
            echo '<td>&nbsp;</td>';
        } ?>
		<td '.$style.'>
		<a href="TranscribirAprobar.php?informe=<?php echo $idInforme ?>&especialista=<?php echo $user ?>" target="transcripcion" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Transcribir/Aprobar Estudios" alt="Transcribir/Aprobar Estudios" /></a>
		</td>
		<td '.$style.'><a href="DevolverEstudio.php?idInforme=<?php echo $idInforme ?>&usuario=<?php echo $user ?>"  target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></a></td>
		<td '.$style.'><a href="../notes/NotaMedica.php?idInforme=<?php echo $idInforme ?>&usuario=<?php echo $user ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/dokter.png" width="15" height="15" title="Nota Medica" alt="Nota Medica" /></a></td>
		<td '.$style.'>
			<a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe']) ?>&amp;usuario=<?php echo base64_encode($_GET['usuario']) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a>
		</td>
		<?php
        if ($row_count==1)
        {
        $stmt = sqlsrv_query( $conn, $sql );
        $row = sqlsrv_fetch_array($stmt);
        $UI = $row['StudyInstanceUid'];
        ?>
        <td align="center"><a href="http://<?php echo $url?>/ImageServer/Pages/Login/Default.aspx?origen='RIS'&user='PRODIAGNOSTICO'&pass='clearcanvas'&ReturnUrl=%2fImageServer%2fPages%2fStudies%2fView%2fDefault.aspx%3faetitle%3d<?php echo $aetitle?>%2cstudy%3d<?php echo $UI?>&aetitle=<?php echo $aetitle?>,study=<?php echo $UI?>" target="imagen" onClick="window.open(this.href, this.target, width=600,height=800); return false;"><img src="../../../../images/x-ray.png" width="15" height="15" title="Ver Imagen" alt="Ver Imagen" /></a></td>
        <?php } ?>
	</tr>
	</table>
	</tr>
	<?php
    }
    //consultar todos los estudios disponibles para el usuario especificado
    $sqlagendaEspecialista = mysql_query("SELECT i.id_informe, i.id_paciente,CONCAT(p.nom1,' ', p.nom2,' ',
p.ape1,' ', p.ape2) AS nombre ,e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad, tp.desctipo_paciente,i.idtipo_paciente, tec.desc_tecnica,i.ubicacion,se.AE_TITLE
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN sede se ON se.idsede=i.idsede
	WHERE i.id_estadoinforme = '2' AND i.idfuncionario_esp = '$usuario' AND i.idsede = '$sede' AND i.idservicio = '$servicio' 
	AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' GROUP BY i.id_informe", $cn);
    $ContAgendaEspecialista = mysql_num_rows($sqlagendaEspecialista);
    if ($ContAgendaEspecialista >= 1) {
        while ($reg = mysql_fetch_array($sqlagendaEspecialista)) {
            //Codificar variables para pasar por URL
            $idInforme = base64_encode($reg['id_informe']);
            $idtipopaciente = $reg['idtipo_paciente'];
            $informeid=$reg['id_informe'];
            $constyle = mysql_query("SELECT IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) < '06:00:00' ,'style=\"background:#F78181\"',
                                IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) BETWEEN '06:00:00' AND '12:00:00','style=\"background:#F3F781\"',
                                IF((SELECT timediff(tiempo_oportunidad,(SELECT timediff(now(),fecha_preparacion) AS diferencia FROM r_informe_header WHERE id_informe=$informeid))
                                FROM r_oportunidad_sede WHERE idservicio=$servicio AND idtipo_paciente=$idtipopaciente AND idsede=$sede) > '12:00:00','',''))) AS style", $cn) or mysql_error();

            $regstyle = mysql_fetch_array($constyle);
            $style = $regstyle['style'];
            $user = base64_encode($usuario);
            $Fecha = $reg['fecha'];
            $sql = "SELECT DISTINCT(s.StudyInstanceUid),s.PatientId,s.StudyDate,s.StudyTime,se.Modality,s.StudyDescription,ser.AeTitle FROM Study s
			INNER JOIN Series se ON s.GUID = se.StudyGUID
			INNER JOIN ServerPartition ser ON s.ServerPartitionGUID=ser.GUID
			WHERE s.StudyInstanceUid='$reg[id_informe]' AND ser.AeTitle='$aetitle'";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
			$stmt = sqlsrv_query( $conn, $sql , $params, $options );
			$row_count = sqlsrv_num_rows( $stmt );
            echo '<tr>';
            echo '<td align="left" ' . $style . '>' . $reg['id_paciente'] . '</td>';
            echo '<td align="left" ' . $style . '>' . ucwords(strtolower($reg['nombre'])) . '</td>';
            echo '<td align="left">' . ucwords(strtolower($reg['nom_estudio'])) . '</td>';
            echo '<td align="left">' . ucwords(strtolower($reg['desc_tecnica'])) . '</td>';
            echo '<td align="left">' . ucwords(strtolower($reg['desctipo_paciente'])) . '</td>';
			echo '<td align="left">' . ucwords(strtolower($reg['ubicacion'])) . '</td>';
            echo '<td align="center">' . ucwords(strtolower($reg['desc_prioridad'])) . '</td>';
            echo '<td align="center">' . $Fecha . '<br>' . $reg['hora'] . '</td>';
            echo '<td align="center">';
            echo '<table>
			<tr>';
            $sqlAdjunto = mysql_query("SELECT ad.id_informe,ad.adjunto,ad.id_adjunto,i.id_informe FROM r_adjuntos ad
			INNER JOIN r_informe_header i ON i.id_informe = ad.id_informe where i.id_informe='$reg[id_informe]'", $cn);
            $count = mysql_num_rows($sqlAdjunto);
            //Validar si se tienen archivos adjuntos.
            if ($count >= 1) {
                echo '<td>';
                while ($regAdjunto = mysql_fetch_array($sqlAdjunto)) {
                    ?>
                    <a href="../ViewAttached.php?Attached=<?php echo base64_encode($regAdjunto['id_adjunto']) ?>"
                       target="orden"
                       onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img
                            src="../../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto"
                            alt="Ver adjunto"/></a>
                <?php
                }
                echo '</td>';
            } else {
                echo '<td>&nbsp;</td>';
            } ?>
			<td '.$style.'>
			<a href="TranscribirAprobar.php?informe=<?php echo $idInforme ?>&especialista=<?php echo $user ?>" target="transcripcion" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img src="../../../../images/kate.png" width="15" height="15" title="Transcribir/Aprobar Estudios" alt="Transcribir/Aprobar Estudios" /></a>
			</td>
			<td '.$style.'><a href="DevolverEstudio.php?idInforme=<?php echo $idInforme ?>&usuario=<?php echo $user ?>"  target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/reload.png" width="15" height="15" title="Regresar Estudio" alt="Regresar Estudio" /></a></td>
			<td '.$style.'><a href="../notes/NotaMedica.php?idInforme=<?php echo $idInforme ?>&usuario=<?php echo $user ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/dokter.png" width="15" height="15" title="Nota Medica" alt="Nota Medica" /></a></td>
			<td '.$style.'>
				<a href="../notes/EventosAdversos.php?idInforme=<?php echo base64_encode($reg['id_informe']) ?>&amp;usuario=<?php echo base64_encode($_GET['usuario']) ?>" target="pop-up" onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=800, height=450, top=85, left=140'); return false;"><img src="../../../../images/adblock.png" width="15" height="15" title="Registrar Evento Adverso" alt="Registrar Evento Adverso" /></a>
			</td>
			<?php
            if ($row_count==1)
            {
            $stmt = sqlsrv_query( $conn, $sql );
            $row = sqlsrv_fetch_array($stmt);
            $UI = $row['StudyInstanceUid'];
            ?>
            <td align="center"><a href="http://<?php echo $url?>/ImageServer/Pages/Login/Default.aspx?origen='RIS'&user='PRODIAGNOSTICO'&pass='clearcanvas'&ReturnUrl=%2fImageServer%2fPages%2fStudies%2fView%2fDefault.aspx%3faetitle%3d<?php echo $aetitle?>%2cstudy%3d<?php echo $UI?>&aetitle=<?php echo $aetitle?>,study=<?php echo $UI?>" target="imagen" onClick="window.open(this.href, this.target, width=600,height=800); return false;"><img src="../../../../images/x-ray.png" width="15" height="15" title="Ver Imagen" alt="Ver Imagen" /></a></td>
            <?php } ?>
		</tr>
		</table>
		</tr>
		<?php
        }
    }
}
mysql_close($cn);
?>
</tbody>