<?php
//conexion a la base de datos
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
//archivo con listas seleccionables
include("../select/selects.php");
$Idinforme = base64_decode($_GET['idInforme']);
$usuario = base64_decode($_GET['usuario']);
$sql = mysql_query("SELECT CONCAT(e.cups_iss,' - ',TRIM(e.nom_estudio)) AS nom_estudio, l.hora, l.id_informe, l.fecha,i.orden, i.idservicio, i.id_paciente,
 i.idestudio, i.id_prioridad,p.id_sexo, i.id_extremidad, i.desc_extremidad, i.id_tecnica,i.ubicacion, i.idsede,i.erp,
 i.lugar_realizacion,i.idservicio,i.portatil, i.idtipo_paciente, i.id_prioridad, i.medico_solicitante, i.fecha_solicitud,
 i.fecha_preparacion,i.hora_solicitud, p.nom1,p.nom2,p.ape1,p.ape2,
 p.edad,f.copago,i.peso_paciente,i.erp,i.anestesia,i.sedacion,f.reconstruccion,f.comparativa,f.proyeccion,f.guia
FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio=i.idestudio
INNER JOIN r_informe_facturacion f ON f.id_informe=i.id_informe
WHERE i.id_informe = '$Idinforme'", $cn);
$reg = mysql_fetch_array($sql);
$sqladicional = mysql_query("SELECT * FROM r_detalle_informe WHERE id_informe='$Idinforme'", $cn);
$regadicional = mysql_fetch_array($sqladicional);
$fechasolicitud = $reg['fecha_solicitud'];
$fechacita = $reg['fecha'];
$fechapreparacion = $reg['fecha_preparacion'];
list ($fechap, $horap) = explode(' ', $fechapreparacion);
$servicio = $reg['idservicio'];
?>
<link type="text/css" href="css/TablaCss.css" rel="stylesheet"/>
<script language="javascript">
    function ValidarModificacion(opcion) {
        var norden, sede, servicio, tecnica, lado, guia, Extremidad, adicional, tipopaciente, prioridad, ubicacion, medsolicita, portatil, fechasolicitud, horasolicitud, fechacita, horacita, observaciones, estudio, erp;
        document.nuevo_informe.opcion.value = opcion;
        norden = document.nuevo_informe.norden.value;
        sede = document.nuevo_informe.sede.value;
        erp = document.nuevo_informe.erp.value;
        servicio = document.nuevo_informe.servicio.value;
        tecnica = document.nuevo_informe.tecnica.value;
        lado = document.nuevo_informe.lado.value;
        tipopaciente = document.nuevo_informe.tipopaciente.value;
        prioridad = document.nuevo_informe.prioridad.value;
        ubicacion = document.nuevo_informe.ubicacion.value;
        medsolicita = document.nuevo_informe.medsolicita.value;
        portatil = document.nuevo_informe.portatil.value;
        fechasolicitud = document.nuevo_informe.fechasolicitud.value;
        horasolicitud = document.nuevo_informe.horasolicitud.value;
        fechacita = document.nuevo_informe.fechacita.value;
        horacita = document.nuevo_informe.horacita.value;
        observaciones = document.nuevo_informe.observaciones.value;
        estudio = document.nuevo_informe.estudio.value;
        paciente = document.nuevo_informe.ndocumento.value;
        guia = $('#guiaselected').val();
        //validar campos obligatorios en el formulario
        if (norden == "" || sede == "" || estudio == "" || servicio == "" || tecnica == "" || lado == "" || tipopaciente == "" ||
            prioridad == "" || ubicacion == "" || fechasolicitud == "" || horasolicitud == "" || fechacita == "" || horacita == "" ||
            observaciones == "" || erp == "" || (servicio == 7 && guia == '')) {
            resp = '<font color="#FF0000">Los campos señalados con * son obligatorios</font>';
            document.getElementById('respuest').innerHTML = resp;
        }
        else {
            //Codigo ajax para enviar datos al servidor y obtener respuesta
            document.nuevo_informe.submit();
        }
    }
    function ValCitaUpdate() {
        var paciente, sede, servicio, fechacita, horacita;
        sede = document.nuevo_informe.sede.value;
        servicio = document.nuevo_informe.servicio.value;
        fechacita = document.nuevo_informe.fechacita.value;
        horacita = document.nuevo_informe.horacita.value;
        paciente = document.nuevo_informe.ndocumento.value;

        munbar = document.getElementById('mostrarboton');//etiqueta donde se va a mostrar la respuesta
        ajax = nuevoAjax();
        //llamado al archivo que va a ejecutar la consulta ajax
        ajax.open("POST", "QueryValidarCita/ValidarCitaUpdate.php", true);
        ajax.onreadystatechange = function () {
            if (ajax.readyState == 4) {
                munbar.innerHTML = ajax.responseText;
            }
        }
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("paciente=" + paciente + "&servicio=" + servicio + "&fechacita=" + fechacita + "&sede=" + sede + "&horacita=" + horacita + "&tiempo=" + new Date().getTime());
    }
    $(document).ready(function () {
        var servicio, sede, idestudio;
        servicio = $('#servicio').val();
        sede = $('#sede').val();
        idestudio = $('#estudio').val();
        if (servicio == 1) {
            $('#showcomparativa').show();
            $('#showproyeccion').show();
            $('#descripcion_extremidad').hide();
            $('#Extremidad').val('');
        } else {
            $('#showcomparativa').hide();
            $('#comparativa').prop('checked', false);
            $('#showproyeccion').hide();
            $('#proyeccionesrx').val('0');
            $('#descripcion_extremidad').show();
        }

        if (servicio == 2) {
            $('#showreconstruccion').show();
        } else {
            $('#showreconstruccion').hide();
            $('#reconstruccion').prop('checked', false);
        }
        if (servicio == 1 || servicio == 3 || servicio == 51 || servicio == 9 || servicio == 20 || servicio == 53 || servicio == 7) {
            $('#tecnicaestudio').hide();
        }
        else {
            $('#tecnicaestudio').show();
        }
        if (servicio == 7) {
            $('#showguia').show();
        } else {
            $('#showguia').hide();
        }

        peticionajaxestudio('', servicio, sede, idestudio);
    });
</script>
</head>
<body>
<form name="nuevo_informe" id="nuevo_informe" method="post" action="AccionesAgenda/AccionCancelarCita.php"
      enctype="multipart/form-data">
    <fieldset>
        <legend><strong>Informaci&oacute;n del paciente</strong></legend>
        <table width="100%" border="0">
            <tr>
                <td width="16%"><strong>N&deg; Documento</strong></br>

                    <input type="text" name="ndocumento" value="<?php echo $reg['id_paciente'] ?>"
                           placeholder="Numero de documento" readonly="readonly"/></td>
                <td width="16%"><strong>1&deg; Nombre</strong><br>
                    <input type="text" value="<?php echo $reg['nom1'] ?>" readonly="readonly"
                           placeholder="Primer Nombre"/></td>
                <td width="16%"><strong>2&deg; Nombre</strong><br>
                    <input type="text" value="<?php echo $reg['nom2'] ?>" readonly="readonly"
                           placeholder="Segundo Nombre"/></td>
                <td width="16%"><strong>1&deg; Apellido</strong><br>
                    <input type="text" value="<?php echo $reg['ape1'] ?>" readonly="readonly"
                           placeholder="Primer Apellido"/></td>
                <td width="16%"><strong>2&deg; Apellido</strong><br>
                    <input type="text" value="<?php echo $reg['ape2'] ?>" readonly="readonly"
                           placeholder="Segundo Apellido"/></td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <table width="100%">
            <legend><strong>Informaci&oacute;n para la agenda</strong></legend>
            <tr>
                <td width="27%"><strong>N&deg; orden / Ingreso</strong><br/>
                    <input type="text" name="norden" class="textlarge"
                           placeholder="Numero de ingreso u orden de servicio" value="<?php echo $reg['orden'] ?>"/>
                    <span class="asterisk">*</span></td>
                <td width="24%"><strong>Entidad Reponsable de Pago (ERP):</strong><br/>
                    <select name="erp" class="text" id="erp">
                        <option value="">.: Seleccione :.</option>
                        <?php
                        $listaSede = mysql_query("SELECT * FROM r_erp WHERE idestado_actividad=1 ORDER BY desc_erp ASC", $cn);
                        while ($rowerp = mysql_fetch_array($listaSede)) {
                            ?>
                            <option value="<?php echo $rowerp['erp'] ?>"
                                <?php if ($rowerp['erp'] == $reg['erp']) {
                                    echo 'selected';
                                } ?>><?php echo $rowerp['desc_erp'] ?></option>
                        <?php
                        }
                        mysql_free_result($listasede);
                        ?>
                    </select>
                    <span class="asterisk">*</span></td>
                <td width="23%"><strong>Sede</strong><br/>
                    <select name="sede" id="sede" class="text">
                        <option value="">.: Seleccione :.</option>
                        <?php
                        $listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 ORDER BY descsede ASC", $cn);
                        while ($rowSede = mysql_fetch_array($listaSede)) {
                            ?>
                            <option value="<?php echo $rowSede['idsede'] ?>"
                                <?php if ($rowSede['idsede'] == $reg['idsede']) {
                                    echo 'selected';
                                } ?>><?php echo $rowSede['descsede'] ?></option>
                        <?php
                        }
                        mysql_free_result($listasede);
                        ?>
                    </select>
                    <span class="asterisk">*</span></td>
                <td width="24%"><strong>Lugar de
                        Realizacion:</strong><br/>
                    <select name="realizacion" class="text" id="realizacion">
                        <option value="">.: Seleccione :.</option>
                        <?php
                        $listaSede = mysql_query("SELECT * FROM sede WHERE idestado_actividad=1 AND idsede NOT IN (38,14,40,45,47,29,39,37,34) ORDER BY descsede ASC", $cn);
                        while ($rowrealizacion = mysql_fetch_array($listaSede)) {
                            ?>
                            <option value="<?php echo $rowrealizacion['idsede'] ?>"
                                <?php if ($rowrealizacion['idsede'] == $reg['lugar_realizacion']) {
                                    echo 'selected';
                                } ?>> <?php echo $rowrealizacion['descsede'] ?></option>
                        <?php }
                        mysql_free_result($listasede);
                        ?>
                    </select>
                    <span class="asterisk">*</span></td>
            </tr>
            <tr>
                <td><strong>Servicio</strong><br/>
                    <select name="servicio" class="text" id="servicio" onchange="MostrarEstudios()">
                        <option value="">.: Seleccione :.</option>
                        <?php
                        while ($rowServicio = mysql_fetch_array($listaServicio)) {
                            ?>
                            <option value="<?php echo $rowServicio['idservicio'] ?>"
                                <?php if ($rowServicio['idservicio'] == $reg['idservicio']) {
                                    echo 'selected';
                                } ?>><?php echo $rowServicio['descservicio'] ?></option>
                        <?php
                        }
                        ?>
                    </select><span class="asterisk"> *</span></td>
                <td colspan="2"><strong>Estudio</strong><br/>

                    <div class="ui-widget">
                        <select id="estudio" name="estudio" class="text">
                            <option value="<?php echo $reg['idestudio'] ?>"><?php echo $reg['nom_estudio']; ?></option>
                        </select>
                    </div>
                </td>
                <!--                <div id="vistaidestudio"></div>-->
                <td>
                    <div id="showproyeccion" style="display: none">
                        <strong>Proyecciones Adicionales</strong>
                        <select id="proyeccionesrx" name="proyeccionesrx" class="form-control">
                            <option value=0>Seleccione a cantidad de proyecciones realizadas</option>

                            <?php for ($i = 1; $i <= 2; $i++) {
                                ?>
                                <option value="<?php echo $i; ?>"
                                    <?php if ($reg['proyeccion'] == $i) {
                                        echo 'selected';
                                    } ?>><?php echo $i; ?> Proyeccion(es)
                                </option>
                            <?php
                            } ?>
                        </select>
                    </div>
                    <div id="showreconstruccion" style="display:none">
                        <label for="reconstruccion"><strong>Reconstruccion 3D</strong></label>
                        <input type="checkbox" name="reconstruccion" id="reconstruccion" value="1"
                            <?php if ($reg['reconstruccion'] == 1) {
                                echo 'checked';
                            } ?>/>
                    </div>
                    <div id="showguia" style="display:none">
                        <strong>Gu&iacute;a Ecogr&aacute;fica</strong>
                        <input type="radio" name="guia" value="1048"
                               onchange="validateradio()"
                            <?php if ($reg['guia'] == '1048') {
                                echo 'checked';
                            } ?>/>
                        <strong>Gu&iacute;a Tomogr&aacute;fica</strong>
                        <input type="radio" name="guia" value="166"
                               onchange="validateradio()"
                            <?php if ($reg['guia'] == '166') {
                                echo 'checked';
                            } ?>/>
                        <input type="hidden" name="guiaselected" id="guiaselected" value="<?php echo $reg['guia']; ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td id="tecnicaestudio"><strong>Tecnica</strong><br/>
                    <select name="tecnica" class="text" onBlur="ValidarEstudio()" onChange="ValidarEstudio()">
                        <?php
                        while ($rowTecnica = mysql_fetch_array($listaTecnica)) {
                            ?>
                            <option value="<?php echo $rowTecnica['id_tecnica'] ?>"
                                <?php if ($rowTecnica['id_tecnica'] == $reg['id_tecnica']) {
                                    echo 'selected';
                                } ?>><?php echo $rowTecnica['desc_tecnica'] ?></option>

                        <?php
                        }
                        ?>
                    </select>
                    <span class="asterisk">*</span></td>

                <td>
                    <strong>Copago</strong><br/>
                    <input type="numeric" id="copago" name="copago" value="<? echo $reg['copago'] ?>"></td>
                <td width="25%"><strong>Peso Paciente</strong><br/>
                    <input type="text" name="pesop" class="textlarge" placeholder="Peso del Paciente en Kilogramos"
                           value="<?php echo $reg['peso_paciente'] ?>" onFocus="ValCitaUpdate();"/>
                    <span class="asterisk">*</span></td>
                <td>
                    <div id="showcomparativa" style="display: none">
                        <label for="comparativa"><strong>Comparativa </strong></label>
                        <input type="checkbox" name="comparativa" id="comparativa" value="1"
                            <?php if ($reg['comparativa'] == 1) {
                                echo 'checked';
                            } ?>/>
                    </div>
                </td>
            </tr>
            <tr>
                <td id="valilado"><strong>Lado</strong><br/>
                    <select name="lado" id="lado" class="text">
                        <?php
                        while ($rowExtremidad = mysql_fetch_array($listaExtremidad)) {
                            ?>
                            <option value="<?php echo $rowExtremidad['id_extremidad'] ?>"
                                <?php if ($rowExtremidad['id_extremidad'] == $reg['id_extremidad']) {
                                    echo 'selected';
                                } ?>><?php echo $rowExtremidad['desc_extremidad'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="asterisk">*</span></td>
                <td id="descripcion_extremidad"><strong>Extremidad:</strong><br>
                    <input type="text" name="Extremidad" class="textlarge"
                           placeholder="Ejemplo:(Mano, Pie, Cuello de pie, Mu�eca, entre otros...)"
                           onKeyUp="this.value=this.value.toUpperCase()" onFocus="BuscarExtremidad();ValCitaUpdate();"
                           id="Extremidad" value="<?php echo utf8_decode($reg['desc_extremidad']) ?>"/></td>
                <td><strong>Adicional:</strong><br/>
                    <input type="text" name="adicional" class="textlarge"
                           placeholder="Registrar adiciones al estudio solo si es necesario"
                           onKeyUp="this.value=this.value.toUpperCase()" onFocus="BuscarAdicional();ValCitaUpdate();"
                           id="adicional" value="<?php echo $regadicional['adicional'] ?>"/></td>
                <td width="21%">
                    <label for="portatil"><strong>Portatil</strong></label>
                    <input type="checkbox" name="portatil" id="portatil" value="1"
                        <?php if ($reg['portatil'] == 1) {
                            echo 'checked';
                        } ?>/>
                    <label for="anestesia"><strong>Anestesia</strong></label>
                    <input type="checkbox" name="anestesia" id="anestesia" value="1"
                        <?php if ($reg['anestesia'] == 1) {
                            echo 'checked';
                        } ?>/>
                    <label for="sedacion"><strong>Sedaci&oacute;n </strong></label>
                    <input type="checkbox" name="sedacion" id="sedacion" value="1"
                        <?php if ($reg['sedacion'] == 1) {
                            echo 'checked';
                        } ?>/></td>
            </tr>
            <tr>
                <td><strong>Tipo paciente</strong><br>
                    <select name="tipopaciente" id="tipopaciente" class="text">
                        <option value="">.:Seleccione:.</option>
                        <?php
                        while ($rowTipoPaciente = mysql_fetch_array($ListaTipoPAciente)) {
                            ?>
                            <option value="<?php echo $rowTipoPaciente['idtipo_paciente'] ?>"
                                <?php if ($rowTipoPaciente['idtipo_paciente'] == $reg['idtipo_paciente']) {
                                    echo 'selected';
                                } ?>><?php echo $rowTipoPaciente['desctipo_paciente'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="asterisk">*</span></td>
                <td><strong>Prioridad</strong><br>
                    <select name="prioridad" id="prioridad" class="text">
                        <option value="">.: Seleccione :.</option>
                        <?php
                        while ($rowPrioridad = mysql_fetch_array($listaPrioridad)) {
                            ?>
                            <option value="<?php echo $rowPrioridad['id_prioridad'] ?>"
                                <?php if ($rowPrioridad['id_prioridad'] == $reg['id_prioridad']) {
                                    echo 'selected';
                                } ?>><?php echo $rowPrioridad['desc_prioridad'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <span class="asterisk">*</span></td>
                <td><strong>Ubicacion</strong><br>
                    <input type="text" name="ubicacion" class="textlarge" placeholder="Ubicaci�n del paciente"
                           onKeyUp="this.value=this.value.toUpperCase()" value="<?php echo $reg['ubicacion'] ?>"/>
                    <span class="asterisk">*</span></td>
                <td><strong>Medico solicitante</strong><br>
                    <input type="text" name="medsolicita" id="medsolicita" class="textlarge"
                           placeholder="Medico que solicita el estudio" onKeyUp="this.value=this.value.toUpperCase()"
                           value="<?php echo $reg['medico_solicitante'] ?>" onFocus="ValCitaUpdate();"/></td>
            </tr>
            <tr>
                <td align="left">
                    <label><strong>Archivos a Subir:</strong><br/></label>
                    <input type="file" id="archivo" name="archivos[]" multiple="multiple"/><br>
                </td>
                <td><strong>Fecha y hora de solicitud</strong><br>
                    <input name="fechasolicitud" type="text"
                           value="<?php echo date("d/m/Y", strtotime($reg['fecha_solicitud'])); ?>"
                        <?php if ($estado == 1) {
                            echo "id='datepicker1'";
                        } ?>
                           readonly/>
                    <span class="asterisk">*</span>
                    <input type="text" name="horasolicitud" placeholder="00:00" class="textmedium" id="hora"
                           value="<?php echo $reg['hora_solicitud'] ?>"
                        <?php if ($estado != 1) {
                            echo "readonly";
                        } ?>/>
                    <span class="asterisk">*</span></td>
                <td><strong>Fecha y hora de preparaci&oacute;n</strong><br>
                    <input type="text" name="fechapreparacion"
                        <?php if ($estado == 1) {
                            echo "id='datepicker3'";
                        } ?>
                           value="<?php echo date("d/m/Y", strtotime($fechap)); ?>" readonly/>
                    <span class="asterisk">*</span>
                    <input type="text" name="horapreparacion" onBlur="MostrarCitas(1)" placeholder="00:00"
                           class="textmedium"
                           id="hora3" value="<?php echo $horap; ?>"
                        <?php if ($estado != 1) {
                            echo "readonly";
                        } ?>/>
                    <span class="asterisk">*</span></td>
                <td><strong>Fecha y hora de la cita</strong><br>
                    <input type="text" name="fechacita"
                        <?php if ($estado == 1) {
                            echo "id='datepicker21'";
                        } ?>
                           value="<?php echo date("d/m/Y", strtotime($reg['fecha'])); ?>"
                           onChange="MostrarCitas()" readonly/>
                    <span class="asterisk">*</span>
                    <input type="text" name="horacita" placeholder="00:00" class="textmedium" id="hora2"
                           onChange="ValCitaUpdate()"
                           onBlur="ValCitaUpdate()"
                           value="<?php echo $reg['hora'] ?>"
                        <?php if ($estado != 1) {
                            echo "readonly";
                        } ?>/>
                    <span class="asterisk">*</span></td>
            </tr>
            <tr>
                <td colspan="2"><input type="hidden" name="funcionario" id="funcionario"
                                       value="<?php echo $usuario ?>"/>
                    <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $Idinforme ?>"/>
                    <input type="hidden" name="opcion" id="opcion"/>
                    <strong>Observaciones:</strong></td>
                <td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="observaciones" id="observaciones" cols="45" rows="5"
                              placeholder="Realizar las observaciones necesarias" onFocus="ValCitaUpdate();"></textarea><span
                    <span class="asterisk">*</span></td>
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"/>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="respuest"><font color="#FF0000">Los campos se�alados con * son obligatorios</font></div>
                </td>
                <td>
                    <div id="mostrarboton">
                    </div>
                </td>
                <td>&nbsp;</td>
                <div id="MosCita" title="Alerta Citas"></div>
            </tr>
            <tr>
                <td id="archivos_adjuntos">
                    <?php $sqladjuntos = mysql_query("SELECT * FROM r_adjuntos WHERE id_informe = '$Idinforme'", $cn);
                    $numsrowadjuntos = mysql_num_rows($sqladjuntos);
                    if ($numsrowadjuntos >= 1) { ?>
                    <div class="table">
                        <div class="row header blue">
                            <div class="cell">
                                <strong>Adjunto</strong>
                            </div>
                            <div class="cell">
                                <strong>Acciones</strong>
                            </div>
                        </div>
                        <?php
                        while ($rowadjuntos = mysql_fetch_array($sqladjuntos)) {
                            echo
                            '<div class="row">
              <div class="cell">'; ?>
                            <a href="../WorkList/ViewAttached.php?Attached=<?php echo base64_encode($rowadjuntos['id_adjunto']) ?> "
                               target="pop-up-adjunto"
                               onClick="window.open(this.href, this.target, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, width=1920, height=1080, top=85, left=140'); return false;"><img
                                    src="../../../images/pdf grande.png" width="15" height="15" title="Ver adjunto"
                                    alt="Ver adjunto"/></a>
                            <?php echo '</div>
			  <div class="cell">
                <input type="button" value="Eliminar" onclick="EliminarAdjunto(' . $rowadjuntos['id_adjunto'] . ' , ' . $rowadjuntos['id_informe'] . ')"/>
              </div>
            </div>';

                        }
                        mysql_free_result($sqladjuntos);
                        mysql_close($cn);
                        }
                        ?>
                    </div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
</form>
</body>
</html>