<?php
$sede = $_POST['sede'];
$mes = $_POST['mes'];
$anio = $_POST['anio'];
$servicio = $_POST['servicio'];
echo '<a href="PacientesAtendidos.php?sede='.$sede.'&mes='.$mes.'&anio='.$anio.'&servicio='.$servicio.'">Descargar base de datos</a>';
?>
