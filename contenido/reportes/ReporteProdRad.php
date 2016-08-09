<?php
ini_set('max_execution_time', 0);
//conexion a la base de datos
include("../../dbconexion/conexion.php");
$cn = conectarse();
//variables con POST
$FchDesde = base64_decode($_GET['FchDesde']); $FchHasta = base64_decode($_GET['FchHasta']); $IdSede = base64_decode($_GET['sede']);
//lineas para exportar a excel
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=ReporteRadiacion".$desde.'/'.$hasta.".xls");
//construir un arreglo para obtener los estudios con radiaciones ionizantes
$Servicios = array( "1"=>"Rayos X", "2"=>"Tomografia", "4"=>"Estudios Especiales", "5"=>"Hemodinamia", "20"=>"Mamografia");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.: Reporte de produccion por sede :.</title>
</head>

<style type="text/css">
    table{
        font-family: "Courier New", Courier, monospace;
        font-size: small;
    }
    .header{
        font-style: inherit;
        background-color: #000066;
        color: #EAE9E9;
    }
</style>

<body>
<?php
foreach($Servicios as $idServicio => $DescripcionServicio){

    //Consultar todos los estudios realizados en cada servicio
    $SqlEstudios = mysql_query("SELECT DISTINCT i.id_informe FROM r_informe_header i LEFT JOIN r_log_informe l ON i.id_informe = l.id_informe
    WHERE i.idsede = '$IdSede' AND l.fecha BETWEEN '$FchDesde' AND '$FchHasta' AND l.id_estadoinforme = '8' AND i.idservicio= '$idServicio' ORDER BY l.fecha ASC", $cn);
    $ContEstudios = mysql_num_rows($SqlEstudios);
    if($ContEstudios>=1){
        echo $DescripcionServicio.'<br>';
        echo
        '<table width="100%" border="1" rules="all">
        <tr align="center" style=" font-style: inherit;
        background-color: #000066;
        color: #EAE9E9;">
            <td>Id Paciente</td>
            <td>Ingreso/Orden</td>
            <td>1er nombre</td>
            <td>2do nombre</td>
            <td>1er apellido</td>
            <td>2do apellido</td>
            <td>Estudio</td>
            <td>Tecnica</td>
            <td>MAS</td>
            <td>KV</td>
            <td>Total Dosis</td>
            <td>Radiacciones Innecesarias</td>
            <td>Realizado Por</td>
            <td>Fecha / Hora Realizacion</td>
            <!--<td>Observaciones y comentarios</td>-->
        </tr>';
        while($RowEstudios = mysql_fetch_array($SqlEstudios)){
            $IdInforme = $RowEstudios['id_informe'];
            echo '<tr align="center">' . GetDetalles($IdInforme, $cn) . '</tr>';
        }
        echo '</table>';
    }
}
//detalles del estudio
?>
</body>
</html>
<?php
function GetDetalles($IdInforme, $cn){
    $String = "";
    //Obtener Informacion de los estudios realizados
    $SqlDetalle = mysql_query("SELECT DISTINCT(i.id_informe), i.orden, ser.descservicio, p.id_paciente, p.nom1, p.nom2, p.ape1, p.ape2,
    est.nom_estudio, tec.desc_tecnica, i.id_estadoinforme FROM r_informe_header i
    INNER JOIN servicio ser ON ser.idservicio = i.idservicio INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente

    INNER JOIN r_estudio est ON est.idestudio = i.idestudio INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica WHERE i.id_informe = '$IdInforme'", $cn);
    $RegDetalle = mysql_fetch_array($SqlDetalle);
    //obtener datos de la dosis de radiacion
    $SqlDosisRadiacion = mysql_query("SELECT DISTINCT(e.id_informe), e.mas, e.kv, e.i_danadas, e.r_innecesarias,e.total_dosis FROM r_estadistica e
	WHERE e.id_informe = '$IdInforme'", $cn);
    
    $RegDosisRadiacion = mysql_fetch_array($SqlDosisRadiacion);
    //consultar detalles del log
    $SqlDetalles = mysql_query("SELECT DISTINCT(l.id_estadoinforme), CONCAT(l.fecha,' / ',l.hora) AS momento, CONCAT(f.nombres,' ',f.apellidos) AS funcionario FROM r_log_informe l
    INNER JOIN funcionario f ON f.idfuncionario = l.idfuncionario
    WHERE l.id_informe = '$IdInforme' AND l.id_estadoinforme = '2' GROUP BY l.id_estadoinforme", $cn);
    $RegDetalles = mysql_fetch_array($SqlDetalles);
    //devolver una cadena con los valores correspondientes
    $String .= '<td>'.$RegDetalle['id_paciente'].'</td>
            <td>'.ucwords(strtolower($RegDetalle['orden'])).'</td>
            <td>'.ucwords(strtolower($RegDetalle['nom1'])).'</td>
            <td>'.ucwords(strtolower($RegDetalle['nom2'])).'</td>
            <td>'.ucwords(strtolower($RegDetalle['ape1'])).'</td>
            <td>'.ucwords(strtolower($RegDetalle['ape2'])).'</td>
            <td>'.ucwords(strtolower($RegDetalle['nom_estudio'])).'</td>
            <td>'.$RegDetalle['desc_tecnica'].'</td>
            <td>'.$RegDosisRadiacion['mas'].'</td
>            <td>'.$RegDosisRadiacion['kv'].'</td>
            <td>'.$RegDosisRadiacion['total_dosis'].'</td>
            <td>'.$RegDosisRadiacion['r_innecesarias'].'</td>
            <td>'.ucwords(strtolower($RegDetalles['funcionario'])).'</td>
            <td>'.$RegDetalles['momento'].'</td>
            <!--<td>Observaciones y comentarios</td>-->';
    return $String;
}
?>