<?php
ini_set('max_execution_time', 0);
include("../../dbconexion/conexion.php");
$cn = Conectarse();

//variables
$desde = trim(base64_decode($_GET['FchDesde']));
$hasta = trim(base64_decode($_GET['FchHasta'])); 


//convertir el documento en excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=ReportedeContraste ".$desde.'-'.desde.'-'.$hasta.".xls");

//obtener totalidad de estudios
$SqlAgenda2 = mysql_query("SELECT i.id_informe, i.id_paciente,s.descsede, v.descservicio, e.nom_estudio ,i.idfuncionario_take,l.cantcontraste, i.idservicio,r.fecha, r.hora, t.desc_tecnica from r_informe_header i 
INNER JOIN r_informe_facturacion l ON l.id_informe = i.id_informe
INNER JOIN r_log_informe r ON r.id_informe= l.id_informe
INNER JOIN sede s ON s.idsede = i.idsede
INNER JOIN r_tecnica t ON  t.id_tecnica = i.id_tecnica
INNER JOIN servicio v ON v.idservicio = i.idservicio 
INNER JOIN r_estudio e ON e.idestudio = i.idestudio where r.fecha BETWEEN '$desde' AND '$hasta' AND i.idservicio IN( 2,4 ,10,5 ) and r.id_estadoinforme = '2'", $cn);


   
?>
<style type="text/css">
    body { font-family: Arial, Helvetica, sans-serif; font-size: x-small; }
    .table-fill { background: white; width: 100%;}
    tr { border-top: 1px solid #C1C3D1; border-bottom-: 1px solid #C1C3D1; }
    tr:first-child { border-top:none; }
    tr:last-child {border-bottom:none; }
    tr:nth-child(odd)
    /*td { background:#EBEBEB; }
    td { background:#FFFFFF; }*/
    .text-center { text-align: center; background-color: #000066; }
</style>
<table border="1" rules="all">
    
        <tr align="center">
        <td width="8%">Id Informe</td>
        <td width="8%">Id Paciente</td>
        <td width="8%">Entidad Responsable de pago</td>
        <td width="8%">Servicio</td>
        <td width="8%">Estudio</td>
        <td width="8%">Tecnica</td>
        <td width="8%">Fecha Preparacion</td>
        <td width="8%">Funcionario que toma el estudio</td>    
        <td width="10%">Cantidad de Contraste</td>                    
    </tr>    
 <?php

      while($row = mysql_fetch_array($SqlAgenda2)) {
            printf("<tr>

            <td>&nbsp;%s</td>
            <td>&nbsp;%s&nbsp;</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            
            </tr>",$row["id_informe"],$row["id_paciente"],$row["descsede"],$row["descservicio"],$row["nom_estudio"], $row["desc_tecnica"], $row["fecha"],$row["idfuncionario_take"],$row["cantcontraste"] );
            }
 ?>
    
</table>