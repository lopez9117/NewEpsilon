<?php 
ini_set('max_execution_time', 6000);
//Conexion a la base de datos
include('../../dbconexion/conexionreporte.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$Fchdesde = $_GET['FechaDesde'];
$fchHasta = $_GET['FechaHasta'];
//consulta
$listado =  mysql_query("SELECT DISTINCTROW (l.idfuncionario), CONCAT(f.nombres,' ',f.apellidos) AS especialista FROM r_log_informe l
INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
WHERE l.fecha BETWEEN '$Fchdesde' AND '$fchHasta' AND l.id_estadoinforme = '5'",$cn);
?> 
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#ListadoEspecialistas').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    });
    })
</script>
<title>.: Especialistas Prodiagnostico S.A :.</title>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListadoEspecialistas">
<thead>
    <tr>
        <th align="center" width="25%">N° Documento</th>
        <th align="center" width="25%">Nombres y apellidos</th>
        <th align="center" width="25%">Cantidad de estudios / Procedimientos</th>
        <th align="center" width="25%">Descargar Reporte</th>
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
    while($reg = mysql_fetch_array($listado))
    {
        $idEspecialista = $reg['idfuncionario'];
        $NomEspecialista = $reg['especialista'];
        //consultar la cantidad de procedimientos leidos y aprobados por el especialista en las fechas seleccionadas
        $sqlCont = mysql_query("SELECT DISTINCTROW (l.id_informe) AS id_informe FROM r_log_informe l LEFT JOIN r_informe_header h ON l.id_informe = h.id_informe
WHERE l.idfuncionario = '$idEspecialista' AND l.fecha BETWEEN '$Fchdesde' AND '$fchHasta' AND l.id_estadoinforme = '5' AND h.id_estadoinforme = '8'", $cn);
        $contador = mysql_num_rows($sqlCont);
        echo '<tr>';
        echo '<td align="center">'.$idEspecialista.'</td>';
        echo '<td align="left">'.ucwords(strtolower($NomEspecialista)).'</td>';
        echo '<td align="center">'.$contador.'</td>';
        echo '<td align="center"><a href="ReporteProduccionEspecialistaExcel.php?Especialista='.base64_encode($idEspecialista).'&FechaInicio='.base64_encode($Fchdesde).'&FechaFinal='.base64_encode($fchHasta).'&NomEspecialista='.base64_encode($NomEspecialista).'"><img src="../../images/excel.png" width="18" height="18" title="Descargar Reporte" alt="Descargar Reporte" /></a></td>';
        echo '</tr>';
    }
   

?>
<tbody>
</table>
