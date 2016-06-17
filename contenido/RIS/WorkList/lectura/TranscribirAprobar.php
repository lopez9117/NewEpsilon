<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
include("../../../../dbconexion/conexion.php");
$cn = Conectarse();
include('Class.Query.php');
$idinforme = base64_decode($_GET['idInforme']);
$idFuncionario = base64_decode($_GET['usuario']);
$RegPaciente = DatosEsudio($cn, $idinforme);
$idPaciente = $RegPaciente['id_paciente'];
$IdEstudio = $RegPaciente['idestudio'];
$Realizacion = GetRealizacion($cn, $idinforme);
$DatosPaciente = DatosPaciente($cn, $idPaciente);
$DatosLectura = GetLectura($cn, $idinforme);
$idServicio = GetServicioEstudio($cn, $IdEstudio);
$variable = GetEstadoVentana($cn, $idinforme,$idFuncionario);
$consTipoResultado = mysql_query("SELECT * FROM r_tipo_resultado", $cn);
if (funcionario::GetPermisos($cn, $idFuncionario) == false){
    echo '<script language="javascript"> setTimeout(window.close) </script>';
}
elseif ($variable == true) {
    //echo 'este informe esta siendo leido por otro medico';
    include('VentanaOcupada.php');
}
else{
?>
<html>
<head>
    <title>.: Transcribir / Aprobar :.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE = 7, 8, 9, 10"/>
    <title>.: Transcribir y aprobar Informe :.</title>
    <script type="text/javascript" src="../../../../js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="../../js/ajax.js"></script>
    <script src="../../ckeditor/ckeditor.js"></script>
    <link href="../../ckeditor/skins/moono/editor.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        CKEDITOR.editorConfig = function (config) {
            config.language = 'es';
            config.uiColor = '#F7B42C';
            config.toolbarCanCollapse = true;
        };
        CKEDITOR.config.height = 400;
        function guardar(opcion, idServicio) {
            if (idServicio == 20) {
                tipoResultado = document.LecturaEstudio.tipoResultado.value;
                BiRads = document.LecturaEstudio.BiRads.value;
                if (tipoResultado == "" || BiRads == "10") {
                    alert("Por favor seleccione el tipo de resultado y/o cantidad de BiRads");
                    $('#opcion').val(opcion);
                }
                else {
                    $('#opcion').val(opcion);
                    document.LecturaEstudio.submit();
                }
            }
            else {
                var tipoResultado;
                tipoResultado = document.LecturaEstudio.tipoResultado.value;
                if (tipoResultado == "") {
                    alert("Por favor seleccione el tipo de resultado");
                    $('#opcion').val(opcion);
                }
                else {
                    $('#opcion').val(opcion);
                    document.LecturaEstudio.submit();
                }
            }
        }
        function Ver() {
            if ($('#VerResultados').prop("checked")) {
                $("#Resultados").show();
            }
            else {
                $("#Resultados").hide();
            }
        }

        ClosingVar = true;
        window.onbeforeunload = ExitCheck;
        window.onunload = ExitCheck;
        function ExitCheck()
        {
            var informe;
            informe = document.LecturaEstudio.informe.value;
            if(ClosingVar == true)
            { ExitCheck = false;
			var form = $('#LecturaEstudio');
            var data = form.serialize();
            var url = '../acciones/ActualizarEstadoVentana.php';
            $.post(url, data, function (data) {
              
            }).fail(function () {
                //alert('Error a eliminar el registro de la ventana, por favor informar a el Departamento de Sistemas');
            });
                //ajax = nuevoAjax();
                //llamado al archivo que va a ejecutar la consulta ajax
                //ajax.open("POST", "../acciones/ActualizarEstadoVentana.php",true);
                //ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                //ajax.send("informe="+informe+"&tiempo=" + new Date().getTime());
                //return "Abandonará la página pudiendo perder los cambios si no ha guardado?";
            }
        }
    </script>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: medium;
            background-color: #333333;
            color: #FFFFFF;
        }
        table {
            width: 100%;
        }

        td {
            width: 50%;
        }

        .input {
            font-family: Arial, Helvetica, sans-serif;
            font-size: small;
            width: 90%;
        }

        .table {
            background: white;
            width: 100%;
            font-size: small;
            margin-top: 1%;
        }

        .tr {
            border-top: 1px solid #C1C3D1;
            border-bottom-: 1px solid #C1C3D1;
            color: #333333;
        }

        .tr:first-child {
            border-top: none;
        }

        .tr:last-child {
            border-bottom: none;
        }

        .tr:nth-child(odd)
        .td {
            background: #EBEBEB;
            width: 33%;
        }

        .td {
            background: #FFFFFF;
            width: 33%;
        }
    </style>
</head>
<body onload="<?php echo GetRegistrarEstado($cn,$idinforme,$idFuncionario); ?>">
<form name="LecturaEstudio" id="LecturaEstudio" method="post" action="AccionTranscibirInforme.php">
    <table>
        <tr>
            <td>Id Paciente: <?php echo $idPaciente ?></td>
            <td>EPS: <?php echo GetEps($cn, $RegPaciente['ideps']) ?></td>
        </tr>
        <tr>
            <td>Nombres /
                Apellidos: <?php echo ucwords(strtolower($DatosPaciente['nombres'] . ' ' . $DatosPaciente['apellidos'])) ?></td>
            <td>Ubicacion: <?php echo ucwords(strtolower($RegPaciente['ubicacion'])); ?></td>
        </tr>
        <tr>
            <td>Edad: <?php echo calculaedad($DatosPaciente['fecha_nacimiento']) ?></td>
            <td>Estudio: <?php echo ucwords(strtolower($RegPaciente['nom_estudio'])) ?></td>
        </tr>
        <tr>
            <td>Sexo: <?php echo $DatosPaciente['desc_sexo'] ?></td>
            <td>Tecnica: <?php echo ucwords(strtolower($RegPaciente['desc_tecnica'])) ?></td>
        </tr>
        <tr>
            <td>N° de Ingreso: <?php echo $RegPaciente['orden']; ?></td>
            <td>Extremidad: <?php echo $RegPaciente['desc_extremidad'] ?></td>
        </tr>
        <tr>
            <td>Fecha de realizacion: <?php echo $Realizacion['fecha'] ?></td>
            <td>Hora de realizacion: <?php echo $Realizacion['hora'] ?></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                Adicional: <input type="text" name="adicional" id="adicional" class="input" value="<?php echo $DatosLectura['adicional'] ?>">
            </td>
        </tr>
    </table>
    <br>
    <table border="1" rules="all">
        <tr align="center">
            <td colspan="2">
                <textarea class="ckeditor" cols="80" id="ResultadoInforme" name="ResultadoInforme" rows="10"><?php echo $DatosLectura['detalle_informe'] ?></textarea>
            </td>
        </tr>
    </table>
    <br>
    <table>
        <tr>
            <td>Este estudio esta siendo leido por:
                <strong><?php echo funcionario::GetFuncionario($cn, $idFuncionario) ?></strong>
                <input type="hidden" name="especialista" id="especialista" value="<?php echo $idFuncionario ?>">
                <input type="hidden" name="informe" id="informe" value="<?php echo $idinforme ?>">
                <input type="hidden" name="opcion" id="opcion">
            </td>
            <td>Tipo de resultado:
                <select name="tipoResultado" id="tipoResultado">
                    <option value="">.: Seleccione :.</option>
                    <?php
                    while ($rowTipo = mysql_fetch_array($consTipoResultado)) {
                        ?>
                        <option value="<?php echo $rowTipo['id_tipo_resultado'] ?>"
                            <?php
                            if ($rowTipo['id_tipo_resultado'] == $DatosLectura['id_tipo_resultado']) {
                                echo 'selected="selected"';
                            } ?>>
                            <?php echo $rowTipo['desc_tipo_resultado'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </td>
            <td>
                <?php
                if ($idServicio == 20) {
                    echo '<input type="hidden" name="idServicio" id="idServicio" value="' . $idServicio . '">';
                    $BiRadsArray = array('.: Seleccione :.' => "10", "0" => 0, "1" => 1, "2" => 2, "3" => 3, "4" => 4, "4A" => '4A', "4B" => '4B', "4C" => '4C', "5" => 5, "6" => 6);
                    $BiRadsAlmacenado = GetBiRads($cn, $idinforme);
                    if ($BiRadsAlmacenado != "") {
                        $BiRadsValor = GetBiRads($cn, $idinforme);
                    } else {
                        $BiRadsValor = "10";
                    }
                    echo 'BiRads: <select name="BiRads" id="BiRads">';
                    foreach ($BiRadsArray as $Birads => $value) { ?>
                        <option value="<?php echo $value ?>" <?php if ($value == $BiRadsValor) {
                            echo 'selected="selected"';
                        } ?>><?php echo $Birads ?></option>
                    <?php }
                    echo '</select>';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>Ver estudios previos del paciente <input type="checkbox" name="VerResultados" value="1"
                                                         id="VerResultados" onchange="Ver()"></td>
            <td align="right">
                <input type="button" name="Marcar" id="Marcar como leido" value="Marcar como Leido"
                       onclick="guardar('1','<?php echo $idServicio ?>')"/>
                <input type="button" name="Parcial" id="Guardar Parcial" value="Guardar Parcial"
                       onclick="guardar('2','<?php echo $idServicio ?>')"/>
                <input type="button" name="Guardar" id="Guardar y Aprobar" value="Guardar y Aprobar"
                       onclick="guardar('3','<?php echo $idServicio ?>')"/>
            </td>
        </tr>
    </table>
</form>
<div id="Resultados" style="display: none;">
    <?php
    $ConsPrevios = mysql_query("SELECT h.id_informe, e.nom_estudio, l.fecha FROM r_informe_header h
    INNER JOIN r_estudio e ON e.idestudio = h.idestudio
    INNER JOIN r_log_informe l ON l.id_informe = h.id_informe
    WHERE l.id_estadoinforme = '2' AND h.id_estadoinforme = '8'
    AND h.id_paciente = '$idPaciente' ORDER BY l.fecha, l.hora ASC", $cn);
    $ContPrevios = mysql_num_rows($ConsPrevios);
    if ($ContPrevios != 0) {
        echo '<table class="table">
            <tr class="tr" align="center">
                <td class="td" width="33%"><strong>Estudio</strong></td>
                <td class="td" width="33%"><strong>Fecha</strong></td>
                <td class="td" width="33%"><strong>Resultado</strong></td>
            </tr>';
        while ($RegsPrevios = mysql_fetch_array($ConsPrevios)) {
            echo '<tr align="center" class="tr">
            <td class="td">' . ucwords(strtolower($RegsPrevios['nom_estudio'])) . '</td>
            <td class="td">' . $RegsPrevios['fecha'] . '</td>
            <td class="td"><a href="../../Resultados/Vistaimpresion.php?informe=' . base64_encode($RegsPrevios['id_informe']) . '" target="Ventana" onClick="window.open(this.href, this.target"><img src="../../../../images/fileprint.png" width="20" height="20" alt="Ver Informe" title="Ver Informe"></a></td>
        </tr>';
        }
        echo '</table>';
    }
    include("../../../../dbconexion/conexionSqlServer.php");
    $url = $_SERVER['HTTP_HOST'];
    if ($url == "www.portalprodiagnostico.com.co" || "pruebas.portalprodiagnostico.com.co" || "portalprodiagnostico.com.co") {
        $url = "pacs.portalprodiagnostico.com.co";
    } else if ($url == "192.168.200.101") {
        $url = "192.168.200.100";
    }
    $ModalidadArray = Array("CR" => 'Rayos X Convencional', "DX" => 'Rayos X Convencional', "CT" => 'Tomografia Axial Computarizada', "MR" => 'Mamografia', "MR" => 'Resonancia Magnetica', "RF" => 'Estudios Especiales', "US" => 'Ecografia', "XA" => 'Rayos X Convencional');
    $PacsSedeArray = Array("PACSNORTE_LL" => 'Fundacion Clinica del Norte', "PACS_MFS" => 'Hospital Marco Fidel Suarez', "PACS_L13" => 'Clinica Leon XIII', "PACS_CQN" => 'Clinica Conquistadores', "PACS_BLL" => 'Red Distrital Barranquilla', "PACS_CALDAS" => 'Hospital San Vicente de Paul (Caldas)', "PACS_AMB" => 'IPS Universitaria Sede Ambulatoria');
    $sql = "SELECT DISTINCT(s.StudyInstanceUid), s.PatientId, s.StudyDate, s.StudyTime, CONCAT(s.StudyDate,' ',s.StudyTime) AS fecha, se.Modality, s.StudyDescription, ser.AeTitle FROM Study s
    INNER JOIN Series se ON s.GUID = se.StudyGUID
    INNER JOIN ServerPartition ser ON s.ServerPartitionGUID = ser.GUID
    WHERE s.PatientId='$idPaciente' AND AeTitle != 'PACSNORTE' ORDER BY fecha ASC";
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $stmt = sqlsrv_query($conn, $sql, $params, $options);
    $row_count = sqlsrv_num_rows($stmt);
    if ($row_count >= 1){
    ?>
    <table class="table">
        <tr class="tr">
            <td class="td">Sede</td>
            <td class="td">Descripcion</td>
            <td class="td">Fecha / Hora de realizacion</td>
            <td class="td">Ver Imagenes</td>
        </tr>
        <?php
        while ($rowimages = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $UI = $rowimages['StudyInstanceUid'];
            $fecha = date("Y-m-d", strtotime($rowimages['StudyDate']));
            list($HoraReal) = explode(".", $rowimages['StudyTime']);
            $Hora = date("H:i:s", strtotime($HoraReal));
            echo
            '<tr class="tr">
                <td class="td">';
            foreach ($PacsSedeArray as $AeTitle => $PacsSede) {
                if ($rowimages['AeTitle'] == $AeTitle) {
                    echo $PacsSede;
                }
            }
            echo '</td>
                <td class="td">';
            foreach ($ModalidadArray as $Modalidad => $descModalidad) {
                if ($rowimages['Modality'] == $Modalidad) {
                    echo $descModalidad;
                }
            }
            echo '</td>
                <td class="td">' . $fecha . ' / ' . $Hora . '</td>
                <td class="td">
                    <a href="http://' . $url . '/ImageServer/Pages/Login/Default.aspx?origen=RIS&user=PRODIAGNOSTICO&pass=clearcanvas&ReturnUrl=%2fImageServer%2fPages%2fStudies%2fView%2fDefault.aspx%3faetitle%3d' . $aetitle . '%2cstudy%3d' . $UI . '&aetitle=' . $aetitle . ',study=' . $UI . '" target="imagen" onClick="window.open(this.href, this.target, width=600,height=800); return false;"><img src="../../../../images/x-ray.png" width="15" height="15" title="Ver Imagen" alt="Ver Imagen" /></a>
                </td>
            </tr>';
        }
        }
        sqlsrv_free_stmt($stmt);
        echo '</table>';
        } ?>
</div>
</body>
</html>