<?php
//Exportar datos de php a Excel

ini_set('max_execution_time', 0);
include("../../dbconexion/conexion.php");
$cn = Conectarse();

 
 $desde = trim(base64_decode($_GET['FchDesde']));
 $hasta = trim(base64_decode($_GET['FchHasta'])); 

//convertir el documento en excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Registro de control.xls");


//obtener totalidad de estudios
$SqlAgenda = mysql_query("select idrol from usuario where idusuario = '1143348007' ", $cn);

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
    <td width="8%">Tipo de identificacion de la entidad reportadora</td>
    <td width="8%">Numero de identificacion de la entidad reportadora</td>
    <td width="8%">Codigo de la EAPB</td>
    <td width="8%">Fecha inicial del periodo de la informacion reportada</td>
    <td width="8%">Fecha final del periodo de la informacion reportada</td>
    <td width="8%">Número total de registros de detalle contenidos en el archivo</td>        
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
            </tr>","1","NI","800250192-1","EAPB",$desde,$hasta,"Contador");
            }

         
           
            ?>
</table>
</body>