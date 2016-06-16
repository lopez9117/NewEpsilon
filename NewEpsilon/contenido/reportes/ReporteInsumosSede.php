<?php

ini_set('max_execution_time', 0);
//conexion a la base de datos
include("../../dbconexion/conexion.php");
//include("validateinvoicepayment.php");
$cn = conectarse();
//variables con POST
$desde = base64_decode($_GET['FchDesde']);
$hasta = base64_decode($_GET['FchHasta']);
$erp = base64_decode($_GET['erp']);
//lineas para exportar a excel
header("Expires: 0");
header('Content-type: application/vnd.ms-excel');
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Insumos " . $desde . '-' . $hasta . ' ' . $codigo . ".xls");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>.: Reporte de Insumos:.</title>
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
        <td><b>SERVICIO</b></td>
        <td><b>FECHA</b></td>
        <td><b>CODIGO</b></td>
        <td><b>NOMBRE</b></td>
        <td><b>CANTIDAD</b></td>
        <td><b>VALOR UNITARIO</b></td>
        <td><b>VALOR TOTAL</b></td>
        <td><b>NOMBRE PACIENTE</b></td>
        <td><b>CEDULA</b></td>
        <td><b>INGRESO</b></td>
    </tr>
    <?php
    if ($erp == 46) {
        $erpb = '(18, 24, 42, 21, 19, 23, 22, 20)';
    } elseif ($erp == 51) {
        $erpb = '(17,33)';
    } else {
        $erpb = '(' . $erp . ')';
    }

    //consultar la cantidad de estudios realizados en cada sede con lectura
    $ConTotal = mysql_query("SELECT DISTINCT(i.id_informe),i.id_estadoinforme FROM r_informe_header i
                              LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
                              WHERE i.erp IN $erpb AND l.fecha BETWEEN '$desde' AND '$hasta' AND
                              l.id_estadoinforme = '8'", $cn) or showerrorsql(mysql_error(), 1);
    //validar cantidades de informes con y sin lectura
    $contConTotal = mysql_num_rows($ConTotal);
    //    $contSinLectura = mysql_num_rows($SinLectura);
    //imprimir filas de archivos con lectura
    if ($contConTotal >= 1) {
        while ($row = mysql_fetch_array($ConTotal)) {
            $idInforme = $row['id_informe'];
            $SqlInforme = mysql_query("SELECT ser.descservicio,p.id_paciente,CONCAT(p.nom1,' ',p.nom2,' ', p.ape1,' ', p.ape2) AS nombre,
		                               i.erp,rif.insumos,rif.cantidadinsumos,i.orden
		                                FROM r_informe_header i
		                                INNER JOIN servicio ser ON ser.idservicio = i.idservicio
		                                INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
		                                LEFT JOIN r_informe_facturacion rif ON i.id_informe=rif.id_informe
		                                WHERE i.id_informe = '$idInforme'", $cn) or showerrorsql(mysql_error(), 2);
            $RegInforme = mysql_fetch_array($SqlInforme);

            $strinsumos = $RegInforme['insumos'];
            $strcantidades = $RegInforme['cantidadinsumos'];
            $VecInsumos = explode('-', $strinsumos);
            $VecCantidades = explode('-', $strcantidades);
            if ($VecInsumos[0] != 0) {
                echo recorrerinsumos($RegInforme, $VecInsumos, $VecCantidades, $cn);
            }
        }
    }
    function recorrerinsumos($RegInforme, $VecInsumos, $VecCantidades, $cn)
    {
        $stringprint = '';
        $con = count($VecInsumos);
        for ($i = 0; $i < $con; $i++) {
            $idinsumo = $VecInsumos[$i];
            $iderp = $RegInforme['erp'];
            $Coninsumos = mysql_query("SELECT * FROM r_insumos ri INNER JOIN r_sede_insumos si
                                      ON ri.id=si.idinsumo WHERE si.idinsumo='$idinsumo'  AND idsede='$iderp'", $cn) or showerrorsql(mysql_error($cn), 3);
            $RegInsumos = mysql_fetch_array($Coninsumos);
            $NombreInsumo = $RegInsumos['desc_insumo'];
            $ValorInsumo = $RegInsumos['valorinsumo'];
            $cantidadinsumo = $VecCantidades[$i];
            $Total = $ValorInsumo * $cantidadinsumo;

            $stringprint .= '<tr>
                    <td>' . $RegInforme['descservicio'] . '</td>
                    <td>' . $RegInforme['descservicio'] . '</td>
                    <td>' . $RegInsumos['codigo'] . '</td>
		            <td>' . $NombreInsumo . '</td>
		            <td>' . $cantidadinsumo . '</td>
		            <td>' . $ValorInsumo . '</td>
		            <td>' . $Total . '</td>
		            <td>' . $RegInforme['nombre'] . '</td>
		            <td>' . $RegInforme['id_paciente'] . '</td>
	                <td>' . $RegInforme['orden'] . '</td>
            </tr>';
        }
        return $stringprint;
    }

    function showerrorsql($e, $line)
    {
        echo 'Se ha producido un error: ' . $e . 'En la linea: ' . $line . '<br/>';
    }

    ?>
</table>
</body>
</html>