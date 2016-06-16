<?php
require_once("../../../../../dbconexion/conexion.php");
$cn = Conectarse();
$idservicio = $_GET['servicio'];
$idsede = $_GET['sede'];
$datos = array();
$nombre = $_GET['term'];
$sql = "SELECT ri.desc_insumo,ri.id FROM r_insumos ri INNER JOIN  r_sede_insumos rsi ON ri.id=rsi.idinsumo
        WHERE ri.desc_insumo LIKE '%$nombre%' AND rsi.idsede='$idsede' AND ri.servicio='$idservicio' AND rsi.estado='1'
         GROUP BY rsi.idinsumo";
$resultado = mysql_query($sql);

while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)) {
    $datos[] = array("value" => $row['id'] . ' - ' . trim($row['desc_insumo']));
}

echo json_encode($datos);
?>
