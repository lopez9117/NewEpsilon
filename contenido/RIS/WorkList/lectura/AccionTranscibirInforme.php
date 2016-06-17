<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include("../../../../dbconexion/conexion.php");
$cn = Conectarse();
//declaracion de variables
$idInforme = $_POST['informe'];
$idFuncionario = $_POST['especialista'];
$tipoResultado = $_POST['tipoResultado'];
$adicional = $_POST['adicional'];
$ResultadoInforme = $_POST['ResultadoInforme'];
$BiRads = $_POST['BiRads'];
$opcion = $_POST['opcion'];
//opciones de guardado 1 - Solo marcar como leido, 2 - Guardado Parcial, 3 - Guardar y Aprobar
function EstadoLectura($cn, $idInforme){
    $SqlEstado = mysql_query("SELECT id_informe, detalle_informe FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
    $contador = mysql_num_rows($SqlEstado);
    if($contador>0) {
        $RegEstado = mysql_fetch_array($SqlEstado);
        $ContenidoInforme = $RegEstado['detalle_informe'];
        $RegistroInforme = $RegEstado['id_informe'];
        if ($ContenidoInforme == "" && $RegistroInforme == "") {
            $Accion = 'Registrar';
            return $Accion;
        }
        else {
            $Accion = 'Modificar';
            return $Accion;
        }
    }
    else{
        $Accion = 'Registrar';
        return $Accion;
    }
    return $Accion;
}
function EstadoInforme($cn, $idInforme){
    $SqlEstadoInforme = mysql_query("SELECT id_estadoinforme FROM r_informe_header WHERE id_informe = '$idInforme'", $cn);
    $RegEstadoInforme = mysql_fetch_array($SqlEstadoInforme);
    $EstadoInforme = $RegEstadoInforme['id_estadoinforme'];
    return $EstadoInforme;
}
$EstadoActual = EstadoInforme($cn, $idInforme);
if($opcion=="1"){ $maxEstado = 3; }
elseif($opcion=="2"){ $maxEstado = 4; }
elseif($opcion=="3"){ $maxEstado = 5; }
$Accion = EstadoLectura($cn, $idInforme);
mysql_query("UPDATE r_informe_header SET id_estadoinforme = '$maxEstado', idfuncionario_esp = '$idFuncionario' WHERE id_informe = '$idInforme'", $cn);
if($Accion=="Registrar"){
    mysql_query("INSERT INTO r_detalle_informe(id_informe, detalle_informe, adicional, id_tipo_resultado) VALUES ('$idInforme','$ResultadoInforme','$adicional','$tipoResultado')", $cn);
    for($i=$EstadoActual; $i<=$maxEstado; $i=$i+1){
       mysql_query(" INSERT INTO r_log_informe (id_informe, idfuncionario, id_estadoinforme, fecha, hora) VALUES ('$idInforme','$idFuncionario','$i', CURDATE(), CURTIME())", $cn);
    }
    if($BiRads!=""){ mysql_query("INSERT INTO r_birad_informe (id_informe, valor_birad) VALUES ('$idInforme','$BiRads')", $cn); }
    if($opcion==2) {
        echo '<script language="javascript">location.href = "TranscribirAprobar.php?idInforme=' . base64_encode($idInforme) . '&usuario=' . base64_encode($idFuncionario) . '"; </script>';
    }
    elseif($opcion==1 || $opcion==3){ echo '<script language="javascript"> window.close(); </script>';}
}
elseif($Accion=="Modificar"){
    mysql_query("UPDATE r_detalle_informe SET detalle_informe = '$ResultadoInforme', adicional = '$adicional', id_tipo_resultado = '$tipoResultado' WHERE id_informe = '$idInforme'", $cn);
    for($i=$EstadoActual; $i<=$maxEstado; $i=$i+1){ mysql_query(" INSERT INTO r_log_informe (id_informe, idfuncionario, id_estadoinforme, fecha, hora) VALUES ('$idInforme','$idFuncionario','$i', CURDATE(), CURTIME())", $cn); }
    if($BiRads!=""){ mysql_query("UPDATE r_birad_informe SET valor_birad = '$BiRads' WHERE id_informe = '$idInforme'", $cn); }
    if($opcion==2) { echo '<script language="javascript"> location.href = "TranscribirAprobar.php?idInforme=' . base64_encode($idInforme) . '&usuario=' . base64_encode($idFuncionario) . '"; </script>'; }
    elseif($opcion==3){ echo '<script language="javascript"> window.close(); </script>';}
}
mysql_query("DELETE FROM r_estadoventana WHERE id_informe = '$idInforme'", $cn);
mysql_close($cn);
?>
<body onBeforeUnload="return window.opener.CargarAgenda()"></body>