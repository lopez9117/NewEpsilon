<?php
ini_set('max_execution_time', 0);
//Conexion a la base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables con el metodo GET
$Especialista = base64_decode($_GET['Especialista']);
$fechaDesde = base64_decode($_GET['FechaInicio']);
$fechaHasta = base64_decode($_GET['FechaFinal']);
$NomEspecialista = base64_decode($_GET['NomEspecialista']);
//consulta para obtener los estudios leidos por el especialista
$sql = mysql_query("SELECT DISTINCT(l.id_informe) AS id_informe FROM r_log_informe l LEFT JOIN r_informe_header h ON l.id_informe = h.id_informe
WHERE l.idfuncionario = '$Especialista' AND l.fecha BETWEEN '$fechaDesde' AND '$fechaHasta' AND l.id_estadoinforme = '5' AND h.id_estadoinforme = '8' GROUP BY l.id_informe", $cn);
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=ProduccionEspecialista" . $NomEspecialista . '-' . $fechaDesde . '-' . $fechaHasta . ".xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>.: Reporte Especialista :.</title>
    <style type="text/css">
        body {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        .header {
            background: #0CF;
            color: #FFF
        }
    </style>
</head>
<body>
<table width="100%" border="1" rules="all">
    <tr class="header" style="background:#0CF;
color:#FFF;">
        <td>N° Documento</td>
        <td>Paciente</td>
        <td>Tipo de paciente</td>
        <td>EPS</td>
        <td>Ubicación</td>
        <td>Servicio</td>
        <td>Estudio</td>
        <td>Tecnica</td>
        <td>Adicional</td>
        <td>Portatil</td>
        <td>Gu&iacute;a</td>
        <td>Sede</td>
        <td>Fecha de lectura</td>
        <td>Hora de lectura</td>
        <td>Fecha de realización</td>
        <td>Hora de realización</td>
        <td>Fecha de aprobación</td>
        <td>Hora de aprobación</td>
        <td>Fecha de Publicación</td>
        <td>Hora de Publicación</td>
        <td>Observaciones</td>
    </tr>
    <?php
    while ($row = mysql_fetch_array($sql)) {
        $idInforme = $row['id_informe'];
        //consulta detalles del informe
        $sqlDetalles = mysql_query("SELECT i.id_paciente, i.portatil, i.ubicacion, se.descsede, ser.descservicio,
CONCAT(p.nom1,' ' ,p.nom2,' ',p.ape1,' ',p.ape2) AS paciente, est.nom_estudio, tec.desc_tecnica, d.adicional,
 desctipo_paciente, e.desc_eps,rif.guia FROM r_informe_header i
	INNER JOIN sede se ON i.idsede = se.idsede
	INNER JOIN servicio ser ON ser.idservicio = i.idservicio
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio est ON est.idestudio = i.idestudio
	INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
	INNER JOIN r_detalle_informe d ON d.id_informe = i.id_informe
	INNER JOIN r_tipo_paciente tp ON tp.idtipo_paciente = i.idtipo_paciente
	INNER JOIN eps e ON e.ideps = p.ideps
    INNER JOIN r_informe_facturacion rif ON rif.id_informe=i.id_informe
	WHERE i.id_informe = '$idInforme'", $cn);
        $regDetalles = mysql_fetch_array($sqlDetalles);
        //consulta fecha y hora de aprobacion - publicacion
        $cons = mysql_query("SELECT fecha, hora FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme
 BETWEEN '4' AND '8' AND id_informe = '$idInforme'", $cn);
        //consulta fecha y hora de realizacion del estudio
        $consRealizacion = mysql_query("SELECT fecha, hora FROM r_log_informe WHERE id_informe = '$idInforme'
 AND id_estadoinforme = '2' AND id_informe = '$idInforme'", $cn);
        //consultar observaciones realizadas en el proceso
        $consObservacion = mysql_query("SELECT * FROM r_observacion_informe o
INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario WHERE o.id_informe = '$idInforme'", $cn);
        echo
            '<tr align="center">
	   <td>' . $regDetalles['id_paciente'] . '</td>
		<td>' . $regDetalles['paciente'] . '</td>
		<td>' . $regDetalles['desctipo_paciente'] . '</td>
		<td>' . $regDetalles['desc_eps'] . '</td>
		<td>' . $regDetalles['ubicacion'] . '</td>
		<td>' . $regDetalles['descservicio'] . '</td>
		<td>' . $regDetalles['nom_estudio'] . '</td>
		<td>' . $regDetalles['desc_tecnica'] . '</td>
		<td>' . $regDetalles['adicional'] . '</td>';
        ?>
        <?php
        //comparar para obtener si es portatil o no
        $portatil = $regDetalles['portatil'];
        if ($portatil == 0) {
            $descPortatil = 'No';
        } else {
            $descPortatil = 'Si';
        }
        echo '
		<td>' . $descPortatil . '</td>';
        $Guia = '';
        if ($regDetalles['guia'] == '166') {
            $Guia = 'Gu&iacute;a Tomografica';
        } elseif ($regDetalles['guia'] == '1048') {
            $Guia = 'Gu&iacute;a Ecografica';
        } else{
            $Guia = 'Sin Gu&iacute;a';
        }
        echo '<td>' . $Guia . '</td>
              <td>' . $regDetalles['descsede'] . '</td>';
        //imprimir la fecha y hora de realizacion del estudio
        $regsRealizacion = mysql_fetch_array($consRealizacion);
        echo '
		<td>' . $regsRealizacion['fecha'] . '</td>
		<td>' . $regsRealizacion['hora'] . '</td>';
        //imprimir fecha y hora de aprobacion - publicacion
        while ($regs = mysql_fetch_array($cons)) {
            echo
                '<td>' . $regs['fecha'] . '</td>
			<td>' . $regs['hora'] . '</td>';
        }
        echo '<td>';
        while ($rowObservaciones = mysql_fetch_array($consObservacion)) {
            echo $rowObservaciones['nombres'] . ' ' . $rowObservaciones['apellidos'] . ' a las: ' . $rowObservaciones['hora'] . ' el ' . $rowObservaciones['fecha'] . '<strong>/</strong>';
            echo $rowObservaciones['observacion'];
        }
        echo '<td>';
        echo '</tr>';
    }
    ?>
</table>
</body>
</html>