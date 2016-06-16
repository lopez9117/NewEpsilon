<?php
//Conexion a la base de datos
require_once('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$desde = $_GET['FechaDesde'];
$hasta = $_GET['FechaHasta'];
$erp = $_GET['erp'];
session_start();
$CurrentUser = $_SESSION['currentuser'];
$conERP = mysql_query("SELECT DISTINCT idsede, descsede FROM sede WHERE idsede IN($erp)", $cn);

if ($erp == 46) {

    $erpb = '(18, 24, 42, 21, 19, 23, 22, 20)';
} elseif ($erp == 51) {
    $erpb = '(17,33)';
} else {
    $erpb = '(' . $erp . ')';
} ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#ListadoSedes').dataTable({ //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        });
    })
</script>
<title>.: Sedes Prodiagnostico S.A :.</title>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListadoSedes">
    <thead>
    <tr>
        <th align="center" width="20%">Entidad Responsable de Pago</th>
        <th align="center" width="20%">Procedimientos Realizados</th>
        <?php if ($CurrentUser!='43987494'){ ?>
		<th align="center" width="20%">Reporte de Facturacion</th>
        <th align="center" width="20%">Reporte de Insumos</th><?php } ?>
        <th align="center" width="20%">Reporte de PACS</th>
    </tr>
    </thead>
    <tbody>
    <?php
    //consultar la cantidad de estudios realizados en cada sede con lectura Y SIN LECTURA
    $conCantidad1 = mysql_query("SELECT COUNT(DISTINCT i.id_informe) AS cantidad FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
    WHERE i.erp IN $erpb  AND l.fecha BETWEEN '$desde' AND '$hasta' AND (l.id_estadoinforme = '8' OR l.id_estadoinforme = '10')", $cn);

    //mostrar la cantidad de estudios realizados en cada sede
    $regCantidad1 = mysql_fetch_array($conCantidad1);
    $regSede = mysql_fetch_array($conERP);
    $total = $regCantidad1['cantidad'];
    echo '<tr>';
    echo '<td align="center">' . mb_convert_encoding($regSede['descsede'], "UTF-8") . '</td>';
    echo '<td align="center">' . $total . '</td>';
   if ($CurrentUser!='43987494'){ echo '<td align="center">
	<a href="ReporteProduccionSedeFact.php?erp=' . base64_encode($erp) . '&FchDesde=' . base64_encode($desde) .
        '&FchHasta=' . base64_encode($hasta) . '">
	<img src="../../images/excel.png" width="20" height="20" alt="Descargar Facturacion" title="Descargar Facturacion" /></a></td>';
    echo '<td align="center">
<a href="ReporteInsumosSede.php?erp=' . base64_encode($erp) . '&FchDesde=' . base64_encode($desde) .
        '&FchHasta=' . base64_encode($hasta) . '">
   <img src="../../images/excel.png" width="20" height="20" alt="Descargar Insumos" title="Descargar Insumos" /></a></td>';}
    echo '<td align="center">
<a href="ReportePACS.php?erp=' . base64_encode($erp) . '&FchDesde=' . base64_encode($desde) .
        '&FchHasta=' . base64_encode($hasta) . '">
    	<img src="../../images/excel.png" width="20" height="20" alt="Descargar Reporte PACS" title="Descargar Reporte PACS" /></a></td>';
    echo '</tr>';
    ?>
    <tbody>
</table>

<!--<a href="ReporteFacturacionSede.php?erp='.base64_encode($erp).'&FchDesde='.base64_encode($desde).'&FchHasta='.base64_encode($hasta).'">-->
