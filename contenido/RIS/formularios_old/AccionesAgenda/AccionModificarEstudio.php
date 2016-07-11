<link href="../styles/VisualStyles.css" rel="stylesheet" type="text/css">
<body onBeforeUnload="return window.opener.mostrarAgenda()">
<title>.: Guardando Cambios :.</title>
<?php
//conexion a la BD
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
//variables del sistema
$fecha = date("Y-m-d");
$hora = date("G:i:s");
//obtener variables con metodo POST
$opcion = $_POST['opcion'];
//validar la accion a ejecutar partiendo de la opcion marcada
if ($opcion == "Cancelar") {
    $funcionario = $_POST['funcionario'];
    $idInforme = $_POST['idInforme'];
    $MotivoCancelacion = $_POST['MotivoCancelacion'];
    $observaciones = $_POST['observaciones'];
    //actualizar registro y pasar a estado de cancelacion
    mysql_query("UPDATE r_informe_header SET id_estadoinforme = '6' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error());
    mysql_query("DELETE FROM r_log_informe WHERE id_informe = '$idInforme'", $cn);
    mysql_query("INSERT INTO r_log_informe VALUES('$idInforme','$funcionario','6','$fecha','$hora')", $cn) or showerror(mysql_error());
    //insertar una observacion
    mysql_query("INSERT INTO r_comentmotivocancel VALUES('$idInforme','$MotivoCancelacion','$funcionario','$observaciones','$fecha $hora')", $cn) or showerror(mysql_error());
    //Accion para cancelar el worklist worklist
    mysql_query("UPDATE r_worklist_temp SET procesado='4' WHERE idestudio=$idInforme", $cn) or showerror(mysql_error());
} elseif ($opcion == "Modificar") {
    $ruta = '../Inserts/uploads';
    $funcionario = $_POST['funcionario'];
    $norden = $_POST['norden'];
    $sede = $_POST['sede'];
    $servicio = $_POST['servicio'];
    $tecnica = $_POST['tecnica'];
    $lado = $_POST['lado'];
    $Extremidad = $_POST['Extremidad'];
    $adicional = $_POST['adicional'];
    $tipopaciente = $_POST['tipopaciente'];
    $prioridad = $_POST['prioridad'];
    $ubicacion = $_POST['ubicacion'];
    $medsolicita = $_POST['medsolicita'];
    $portatil = $_POST['portatil'];
    $horasolicitud = $_POST['horasolicitud'];
    $horacita = $_POST['horacita'];
    $observaciones = $_POST['observaciones'];
    $estudio = $_POST['estudio'];
    $erp = $_POST['erp'];
    $realizacion = $_POST['realizacion'];
    $pesop = $_POST['pesop'];
    $anestesia = $_POST['anestesia'];
    $sedacion = $_POST['sedacion'];
    $copago = $_POST['copago'];
    $comparativa = $_POST['comparativa'];
    $reconstruccion = $_POST['reconstruccion'];
    if ($anestesia == '') {
        $anestesia = 0;
    }
    if ($reconstruccion == '') {
        $reconstruccion = 0;
    }
    if ($sedacion == '') {
        $sedacion = 0;
    }
    if ($comparativa == "") {
        $comparativa = 0;
    }
    $proyeccion = $_POST['proyeccionesrx'];
    //consulta para hacer update en worklist
    $sql2 = mysql_query("SELECT alias FROM servicio WHERE idservicio = '$servicio'", $cn);
    $reg2 = mysql_fetch_array($sql2);
    $modalidad = $reg2['alias'];
    $sql3 = mysql_query("SELECT nom_estudio, idestudio  FROM r_estudio WHERE idestudio = '$estudio'", $cn);
    $reg3 = mysql_fetch_array($sql3);
    $desc_estudio = $reg3['nom_estudio'];
    $sql4 = mysql_query("SELECT stationname,device_aet  FROM r_devices_worklist WHERE idsede = '$realizacion' AND idservicio= '$servicio'", $cn);
    $reg4 = mysql_fetch_array($sql4);
    $devices_aet = $reg4['stationname'];
//Accion para modificar el estudio en el worklist.
    $consultaworklist = mysql_query("SELECT id_estadoinforme FROM r_informe_header WHERE id_informe = '$idInforme'", $cn);
    $contadorworklist = mysql_fetch_array($consultaworklist);
    if ($contadorworklist['id_estadoinforme'] == '1') {
        mysql_query("UPDATE r_worklist_temp SET modalidad= '$modalidad', cod_estudio= '$estudio', descripcion_estudio='$desc_estudio', fecha_turno='$fechacita',hora_turno='$horacita',devices='$devices_aet',procesado='2',origenpac='$realizacion', medico_informante='$medsolicita', observacion= '$observaciones' WHERE idestudio=$idInforme", $cn);
    }
//ejecutar consulta para modificar los datos del estudio
    mysql_query("UPDATE r_informe_header SET idestudio = '$estudio', id_prioridad = '$prioridad', id_extremidad = '$lado', idsede = '$sede', idservicio = '$servicio', ubicacion = '$ubicacion', portatil = '$portatil', id_tecnica = '$tecnica', idtipo_paciente = '$tipopaciente', medico_solicitante = '$medsolicita', hora_solicitud = '$horasolicitud', fecha_solicitud = '$fechasolicitud', orden = '$norden', desc_extremidad = '$Extremidad',anestesia='$anestesia',sedacion='$sedacion',peso_paciente='$pesop',erp='$erp',lugar_realizacion='$realizacion' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error());
// Actualizacion r_informe_facturacion
    mysql_query("UPDATE r_informe_facturacion SET copago='$copago',proyeccion='$proyeccion',comparativa='$comparativa', reconstruccion = '$reconstruccion' WHERE id_informe='$idInforme'", $cn) or showerror(mysql_error());
//modificar el adicional del estudio
    $cons = mysql_query("SELECT * FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error());
    $cont = mysql_num_rows($cons);
    if ($cont > 0) {
        //actualizar el adicional del reporte
        mysql_query("UPDATE r_detalle_informe SET adicional = '$adicional' WHERE id_informe = '$idInforme'", $cn) or showerror(mysql_error());
    } else {
        //insertar el detalle de informe si este no existiera
        mysql_query("INSERT INTO r_detalle_informe(id_informe, detalle_informe, adicional, id_tipo_resultado) VALUES('$idInforme', '', '$adicional', '0')", $cn) or showerror(mysql_error());
    }
//registrar la observacion necesaria
    mysql_query("INSERT INTO r_observacion_informe(id_informe, idfuncionario, observacion, fecha, hora, id_tipocomentario) VALUES('$idInforme', '$funcionario', '$observaciones', '$fecha', '$hora', '1')", $cn) or showerror(mysql_error());
//registrar los adjuntos adicionales
//Copiar archivo adjunto
    //de se asi, para procesar los archivos subidos al servidor solo debemos recorrerlo
    //obtenemos la cantidad de elementos que tiene el arreglo archivos
    $tot = count($_FILES["archivos"]["name"]);
    //este for recorre el arreglo
    for ($i = 0; $i < $tot; $i++) {
        //con el indice $i, poemos obtener la propiedad que desemos de cada archivo
        //para trabajar con este
        $tipoFile = $_FILES["archivos"]["type"][$i];
        list($nomadjun, $tipoadjun) = explode("/", $tipoFile);
        $tmp_name = $_FILES["archivos"]["tmp_name"][$i];
        $consuladjunto = mysql_query("SELECT MAX(id_adjunto) AS id FROM r_adjuntos WHERE id_informe ='$idInforme'", $cn);
        $rowultimoadjunto = mysql_fetch_array($consuladjunto);
        if ($rowultimoadjunto['id'] != null && $rowultimoadjunto['id'] != '') {
            $id = $rowultimoadjunto['id'];
            $ultimoaadjunto = mysql_query("SELECT * FROM r_adjuntos WHERE id_adjunto ='$id'", $cn);
            $rowsAdjunto = mysql_fetch_array($ultimoaadjunto);
            $vector = explode('/', $rowsAdjunto['adjunto']);
            $con = count($vector);
            $archivo = $vector[$con - 1];
            list ($nom) = explode('.', $archivo);
            $name = $nom + 1;
        } else {
            $name = $idInforme . $i;
        }
        //copiar los archivos adjuntos en la carpeta uploads
        copy($tmp_name, $ruta . '/' . $name . '.' . $tipoadjun);
        $url = $ruta . '/' . $name . '.' . $tipoadjun;
        //insertar en la tabla adjuntos para luego realizar consulta del total de archivos adjuntos
        if ($tipoFile != "") {
            mysql_query("INSERT INTO r_adjuntos (adjunto, id_informe) VALUES ('$url','$idInforme')", $cn);
        }
    }
}
function showerror($er)
{
    echo 'Ocurrio un error ' . $er;
}

?>
<table width="50%" border="0" align="center" style="margin-top:20%;">
    <tr>
        <td><img src="../../styles/images/MnyxU.gif" width="64" height="64"/>
        </td>
        <td>
            <strong><h3>Guardando los cambios, por favor espere...</h3></strong>
        </td>
    </tr>
</table>
<script language="javascript">
    setTimeout("window.close()", 2000);
</script>
</body>