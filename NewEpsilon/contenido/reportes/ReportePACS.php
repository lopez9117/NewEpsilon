<?php
ini_set('max_execution_time', 0);
//realizar conexion con SqlServer para consultar los pacientes del PACS
require_once("../../dbconexion/conexionSqlServer.php");
//Conexion a la base de datos
require_once('../../dbconexion/conexion.php');
$cn = conectarse();
//variables con POST
$desde = base64_decode($_GET['FchDesde']);
list($ano, $mes, $dia) = explode("-", $desde);
$hasta = base64_decode($_GET['FchHasta']);
list($ano2, $mes2, $dia2) = explode("-", $hasta);
//lineas para exportar a excel
header("Expires: 0");
header('Content-type: application/vnd.ms-excel');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=PACS " . $desde . '-' . $hasta . ".xls");
$FchDesde = $ano . '' . $mes . '' . $dia;
$FchHasta = $ano2 . '' . $mes2 . '' . $dia2;
$erp = base64_decode($_GET['erp']);
$sqlSede = mysql_query("SELECT AE_TITLE FROM sede WHERE idsede='$erp'", $cn);
$rowSede = mysql_fetch_array($sqlSede);
$AE_TITLE = $rowSede['AE_TITLE'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>.: Reporte de PACS:.</title>
</head>
<style type="text/css">
    body {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-size: 10px;
    }
</style>
<body>
<table width="100%" border="1" rules="all">
    <tr style="background:#0000AA;color: #FFF;">
        <td><b>IDENTIFICADOR DEL ESTUDIO</b></td>
        <td><b>NOMBRE DEL PACIENTE</b></td>
        <td><b>APELLIDOS DEL PACIENTE</b></td>
        <td><b>CEDULA DEL PACIENTE</b></td>
        <td><b>NUMERO DE ACCESO</b></td>
        <td><b>FECHA DE ESTUDIO</b></td>
        <td><b>HORA ESTUDIO</b></td>
        <td><b>DESCRIPCION</b></td>
        <td><b>SERIES</b></td>
        <td><b>INSTANCIAS</b></td>
        <td><b>MODALIDAD</b></td>
        <td><b>TECNICO</b></td>
    </tr>
    <?php
    // Consultar estudios enviados al PACS
    $sql = "SELECT DISTINCT(s.StudyInstanceUid),s.PatientsName,s.PatientId,s.AccessionNumber,s.StudyDate,s.StudyTime,s.StudyDescription,s.NumberOfStudyRelatedSeries,s.NumberOfStudyRelatedInstances,se.Modality,s.ReferringPhysiciansName FROM Study s
    INNER JOIN Series se ON s.GUID = se.StudyGUID
    INNER JOIN ServerPartition ser ON s.ServerPartitionGUID=ser.GUID
	WHERE StudyDate between '$FchDesde' AND '$FchHasta' AND ser.AeTitle='$AE_TITLE' ORDER BY Modality ASC ";
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);

    //imprimir filas de archivos con lectura
    if ($row_count >= 1) {
        while ($rowimages = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $fecha = date("Y-m-d", strtotime($rowimages['StudyDate']));
            list($HoraReal) = explode(".", $rowimages['StudyTime']);
            list($apellido, $nombre) = explode("^", $rowimages['PatientsName']);
            $Hora = date("H:i:s", strtotime($HoraReal));
            echo '<tr>
                    <td>' . $rowimages['StudyInstanceUid'] . '</td>
                    <td>' . $nombre . '</td>
					<td>' . $apellido . '</td>
                    <td>' . $rowimages['PatientId'] . '</td>
		            <td>' . $rowimages['AccessionNumber'] . '</td>
		            <td>' . $fecha . '</td>
		            <td>' . $Hora . '</td>
		            <td>' . $rowimages['StudyDescription'] . '</td>
		            <td>' . $rowimages['NumberOfStudyRelatedSeries'] . '</td>
		            <td>' . $rowimages['NumberOfStudyRelatedInstances'] . '</td>
	                <td>' . $rowimages['Modality'] . '</td>
	                <td>' . $rowimages['ReferringPhysiciansName'] . '</td>
            </tr>';
        }
        sqlsrv_free_stmt($stmt);
    }
    ?>
</table>
</body>
</html>