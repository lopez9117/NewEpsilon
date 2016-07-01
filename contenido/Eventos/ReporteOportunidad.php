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
header("content-disposition: attachment;filename=OportunidadAsignacionCitas".$descSede.'-'.desde.'-'.$hasta.".xls");

//obtener totalidad de estudios
$SqlAgenda = mysql_query("SELECT  t.cod_documento,p.id_paciente,p.fecha_nacimiento,s.desc_sexo,p.ape1,p.ape2, p.nom1,p.nom2,eps.eapb, e.cups_iss, i.fecha_solicitud,i.fecha_preparacion,i.lugar_realizacion FROM r_paciente p
INNER JOIN tipo_documento t ON  t.idtipo_documento = p.idtipo_documento
INNER JOIN r_sexo s ON s.id_sexo =  p.id_sexo
INNER JOIN eps eps ON eps.ideps = p.ideps
INNER JOIN r_informe_header i ON i.id_paciente = p.id_paciente 
INNER JOIN r_estudio e ON e.idestudio = i.idestudio where  (e.cups_iss BETWEEN '881112' and '882841' or e.cups_iss BETWEEN '883101' and '883910')  AND  i.fecha_solicitud BETWEEN '$desde' AND '$hasta' AND (i.lugar_realizacion ='32' or i.lugar_realizacion ='15')", $cn);


   
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
    <td width="8%">Tipo de registro</td>
    <td width="8%">Consecutivo de registro</td>
    <td width="8%">Tipo de identificacion del usuario</td>
    <td width="8%">Numero de identificacion del usuario</td>
    <td width="8%">Fecha de nacimiento del usuario</td>
        <td width="8%">Sexo del usuario</td>
        <td width="10%">Primer  apellido del usuario</td>        
        <td width="10%">Segundo apellido del usuario</td>
        <td width="10%">Primer Nombre del usuario</td>
        <td width="10%">Segundo nombre del usuario</td>
        <td width="20%">Codigo de la EAPB del usuario</td>
        <td width="5%">Identificacion del tipo de cita o procedimiento no quirujico</td>
        <td width="9%">Fecha de la solicitud de la cita</td>
        <td width="10%">La cita fue asignada</td>
        <td width="10%">Fecha de la Asignacion de la cita</td>
        <td width="8%">Fecha para la cual el usuario solicito que le fuera asignada la cita(fecha deseada)</td>
    </tr>

    
 <?php

      while($row = mysql_fetch_array($SqlAgenda)) {
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
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            <td>&nbsp;%s</td>
            </tr>","2"," ",$row["cod_documento"],$row["id_paciente"],$row["fecha_nacimiento"],$row["desc_sexo"],$row["ape1"],$row["ape2"],$row["nom1"],$row["nom2"], $row["eapb"],$row["cups_iss"],$row["fecha_solicitud"],$siono,$row["fecha_preparacion"]," ");
            }
 ?>
    
</table>