<?php
//conexion a la base de datos
require_once("../../../dbconexion/conexion.php");
$cn = conectarse();
//archivo con listas seleccionables
include("../select/selects.php");
$Idinforme = base64_decode($_GET['idInforme']);
$usuario = base64_decode($_GET['usuario']);
$sql = mysql_query("SELECT e.cod_iss, e.nom_estudio, l.hora, l.id_informe, l.fecha,i.orden, i.idservicio, i.id_paciente, i.idestudio, i.id_prioridad,p.id_sexo, i.id_extremidad, i.desc_extremidad, i.id_tecnica,
i.ubicacion, i.idsede,i.erp,i.lugar_realizacion,i.idservicio,i.portatil, i.idtipo_paciente, i.id_prioridad, i.medico_solicitante, i.fecha_solicitud,i.hora_solicitud, p.nom1,p.nom2,p.ape1,p.ape2, p.edad FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio=i.idestudio
WHERE i.id_informe = '$Idinforme' AND l.id_estadoinforme=1", $cn);
$reg = mysql_fetch_array($sql);
$fechasolicitud = date("m/d/Y", strtotime($reg['fecha_solicitud']));
$fechacita = date("m/d/Y", strtotime($reg['fecha']));
?>
<script language="javascript">
    function ValidarCancelado(opcion) {
        var MotivoCancelacion, observaciones, funcionario, idInforme;
        formulario = document.FormCancelarCita;
        MotivoCancelacion = formulario.MotivoCancelacion.value;
        observaciones = formulario.observaciones.value;
        funcionario = formulario.funcionario.value;
        idInforme = formulario.idInforme.value;
        formulario.opcion.value = opcion;
        //validar campos obligatorios del formulario
        if (MotivoCancelacion == "" || observaciones == "" || funcionario == "" || idInforme == "") {
            mensaje = '<font color="#FF0000">Los campos se�alados con * son obligatorios</font>';
            document.getElementById('respuesta').innerHTML = mensaje;
        }
        else {
            //asignar el valor del boton al campo oculto para cambiar la opcion
            formulario.submit();
        }
    }
</script>
<form name="FormCancelarCita" id="FormCancelarCita" method="post" action="AccionesAgenda/AccionCancelarCita.php">
    <fieldset>
        <legend><strong>Informaci&oacute;n del paciente</strong></legend>
        <table width="100%" border="0">
            <tr>
                <td width="16%"><strong>N&deg; Documento</strong></br>
                    <input type="text" value="<?php echo $reg['id_paciente'] ?>" placeholder="Numero de documento"
                           readonly="readonly"/></td>
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
                <td width="25%"><strong>N&deg; orden / Ingreso</strong><br/>
                    <input type="text" disabled="disabled" class="textlarge" value="<?php echo $reg['orden'] ?>"
                           placeholder="Numero de ingreso u orden de servicio" autofocus onfocus="MostrarEstudios()"/>
                </td>
                <td width="25%"><strong>Sede</strong><br/>
                    <select class="selectlarge" disabled="disabled">
                        <option value="">.: Seleccione :.</option>
                        <?php
                        while ($rowSede = mysql_fetch_array($listaSede)) {
                            ?>
                            <option value="<?php echo $rowSede['idsede'] ?>"
                                <?php if ($rowSede['idsede'] == $reg['idsede']) {
                                    echo 'selected';
                                } ?>><?php echo $rowSede['descsede'] ?></option>
                            ';

                        <?php
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Estudio</strong><br/>
                    <input type="text" disabled="disabled" class="textlarge"
                           value="<?php echo $reg['cod_iss'] . ' - ' . utf8_decode($reg['nom_estudio']) ?>"
                           placeholder="Ingresar nombre del estudio o procedimiento"/></td>
            </tr>
            <tr>
                <td><strong>Servicio</strong><br/>
                    <select name="servicio" class="selectlarge" id="servicio" disabled="disabled">
                        <option value="">.: Seleccione :.</option>
                    </select>
                    </select></td>
                <td><strong>Tecnica</strong><br/>
                    <select class="selectlarge" disabled="disabled">
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
                    </select></td>
            </tr>
            <tr>
                <td><strong>Lado</strong><br/>
                    <select class="selectlarge" disabled="disabled">
                        <?php
                        while ($rowExtremidad = mysql_fetch_array($listaExtremidad)) {
                            ?>
                            <option value="<?php echo $rowExtremidad['id_extremidad'] ?>"
                                <?php if ($rowExtremidad['id_extremidad'] == $reg['id_extremidad']) {
                                    echo 'selected';
                                } ?>><?php echo $rowExtremidad['desc_extremidad'] ?></option>
                            ';

                        <?php
                        }
                        ?>
                    </select></td>
                <td id="descripcion_extremidad"><strong>Extremidad:</strong><br><input type="text" disabled="disabled"
                                                                                       class="textlarge"
                                                                                       value="<?php echo utf8_decode($reg['desc_extremidad']) ?>"
                                                                                       placeholder="Ejemplo:(Mano, Pie, Cuello de pie, Mu�eca, entre otros...)"/>
                </td>
            </tr>
            <tr>
                <td><strong>Adicional:</strong><br/>
                    <input type="text" disabled="disabled" class="textlarge" value="<?php echo $reg['adicional'] ?>"
                           placeholder="Registrar adiciones al estudio solo si es necesario"/></td>
                <td><strong>Tipo paciente</strong><br/>
                    <select class="selectlarge" disabled="disabled">
                        <option value="">.: Seleccione :.</option>
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
                    </select></td>
            </tr>
            <tr>
                <td><strong>Prioridad</strong><br/>
                    <select class="selectlarge" disabled="disabled">
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
                    </select></td>
                <td><strong>Ubicacion</strong><br/>
                    <input type="text" disabled="disabled" class="textlarge" value="<?php echo $reg['ubicacion'] ?>"
                           placeholder="Ubicaci�n del paciente"/></td>
            </tr>
            <tr>
                <td>
                    <dt><strong>Fecha y hora de solicitud</strong><br/>
                        <input type="text" disabled="disabled" id="textmedium" value="<?php echo $fechasolicitud ?>"/>
                        <input type="text" disabled="disabled" class="textmedium"
                               value="<?php echo $reg['hora_solicitud'] ?>" placeholder="00:00"/>
                    </dt>
                    <div id="archivos"></div>
                </td>

                <td><strong>Fecha y hora de la cita</strong><br/>
                    <input type="text" disabled="disabled" value="<?php echo $fechacita ?>"/>
                    <input type="text" disabled="disabled" class="textmedium" value="<?php echo $reg['hora'] ?>"
                           placeholder="00:00"/></td>
            </tr>
            <tr>
                <td><strong>Motivo Cancelacion</strong><br/>
                    <select name="MotivoCancelacion" id="MotivoCancelacion" class="selectlarge">
                        <option value="">.: Seleccione :.</option>
                        <?php
                        while ($rowMotivoCancel = mysql_fetch_array($listarMotivoCancel)) {
                            echo '<option value="' . $rowMotivoCancel['id_motivo'] . '">' . utf8_decode($rowMotivoCancel['desc_motivo']) . '</option>';
                        }
                        ?>
                    </select><span class="asterisk">*</span></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <div id="motivo_cancel">
                    <td colspan="2">
                        <input type="hidden" name="funcionario" id="funcionario" value="<?php echo $usuario ?>"/>
                        <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $Idinforme ?>"/>
                        <input type="hidden" name="opcion" id="opcion"/>
                        <strong>Observaciones:</strong></td>
                </div>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea name="observaciones" id="observaciones" cols="45" rows="5"
                              placeholder="Realizar las observaciones necesarias"
                              onfocus="ValidarCita();"></textarea><span class="asterisk">*</span></td>
                <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"/>
            </tr>
            <tr>
                <td>
                    <div id="respuesta"></div>
                </td>
                <td align="left"><input type="button" name="button" id="button" value="Cancelar Cita"
                                        onclick="ValidarCancelado('Cancelar')"/></td>
            </tr>
        </table>
    </fieldset>
</form>