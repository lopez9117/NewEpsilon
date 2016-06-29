<?php 
//Conexion a la base de datos
include('../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
$desde = $_GET['FechaDesde']; $hasta =$_GET['FechaHasta']; $idSede = $_GET['sede'];
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#ListadoSedes').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
            "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
        } );
    })
</script>
<br>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="ListadoSedes">
    <thead>
    <tr>
        <th align="center" width="16%">Estudios / Procedimientos Realizados</th>
       
        <th align="center" width="50%">reporte Oprotunidad</th>
         <th align="center" width="60%">reporte de control</th>

    </tr>
</thead>
<tfoot>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
</tfoot>
<tbody>
<?php
function VerSede($cn, $IdSede){
    $SqlSede = mysql_query("SELECT descsede FROM sede WHERE idsede = '$IdSede'", $cn);
    $RegSede = mysql_fetch_array($SqlSede);
    $NomSede = $RegSede['descsede'];
    return $NomSede;
}
function GetValores($cn, $idSede, $desde, $hasta){
    $conCantidad = mysql_query("SELECT COUNT(DISTINCT i.id_informe) AS cantidad FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
    WHERE i.idsede = '$idSede' AND l.fecha BETWEEN '$desde' AND '$hasta' AND l.id_estadoinforme IN ('8','10')", $cn);
    $RegCantidad = mysql_fetch_array($conCantidad);
    $Total = $RegCantidad['cantidad'];
    return $Total;
}
$NomSede = VerSede($cn, $idSede);
$VarUrl = "?sede=". base64_encode($idSede). "&FchDesde=". base64_encode($desde) ."&FchHasta=". base64_encode($hasta) ."&descSede=". base64_encode($NomSede) ."";
$XlsIco = 'src="../../images/excel.png" width="20" height="20"';
	echo '<tr>';
	echo '<td align="center">'. GetValores($cn, $idSede, $desde, $hasta) .'</td>';

    echo '<td align="center"><a href="ReporteOportunidad.php'.$VarUrl.'"><img '.$XlsIco.' alt="Descargar Oportunidad en Asignacion" title="Descargar Oportunidad en Asignacion" /></a></td>';

      echo '<td align="center"><a href="Reportedecontrol.php'.$VarUrl.'"><img '.$XlsIco.' alt="Descargar Reporte de control" title="Descargar Reporte de control" /></a></td>';
	echo '</tr>';
?>
<tbody>
</table>