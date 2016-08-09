<?php
//archivo de conexion a la BD
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//Variables por GET
$idInforme = base64_decode($_GET['idInforme']);
$idusuario = base64_decode($_GET['usuario']);
$sede = base64_decode($_GET['sede']);
$servicio = base64_decode($_GET['servicio']);
//consulta
$sql = mysql_query("SELECT l.hora, l.id_informe, l.fecha, i.id_paciente,i.idestudio,i.id_tecnica,i.anestesia, es.nom_estudio,
 p.edad,p.peso, t.desc_tecnica,i.ubicacion, CONCAT(p.nom1,' ', p.nom2,' ', p.ape1,' ', p.ape2) AS nombre, es.nom_estudio,
 es.cod_iss, ex.desc_extremidad, pr.desc_prioridad, t.desc_tecnica,i.portatil FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN r_extremidad ex ON ex.id_extremidad = i.id_extremidad WHERE i.id_informe = '$idInforme' group by id_informe", $cn);
$reg = mysql_fetch_array($sql);
if ($servicio == 2) {
    $style = 'style="display:none"';
}
//elseif ($reg['portatil'] == 1) {
//    $style = 'style="display:none"';
//} else {
//    $style = 'style="display:block"';
//}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="utf-8">
    <title>.: Realizar Estudio :.</title>
    <link href="../../../../js/themes/cupertino/jquery-ui.css" rel="stylesheet" type="text/css">
    <script src="../../../../js/jquery-1.9.1.js"></script>
    <script src="../../js/ui/1.10.3/jquery-ui.js"></script>
    <script src="../../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
    <link href="../../styles/forms.css" rel="stylesheet" type="text/css">
    <script>
        $(function () {
            $("#tabs").tabs();
        });
    </script>
    <script language="javascript" src="js/estadistica.js"></script>


    <style type="text/css">
        .asterisk {
            color: #F00;
        }

        .textlarge {
            width: 90%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            height: 12px;
        }

        .selectlarge {
            width: 95%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            height: 20px;
        }

        select {
            width: 95%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            height: 20px;
        }

        textarea {
            width: 95%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .asterisk1 {
            color: #F00;
        }
    </style>
    <link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css"/>
</head>
<body onBeforeUnload="return window.opener.CargarAgenda();">
<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Información del estudio</a></li>
    </ul>
    <div id="tabs-1">
        <p>

        <form id="estadistica" name="estadistica" method="post" action="realizarestudio.php"
              enctype="multipart/form-data">
            <!--            CABECERA INFORMACION  PACIENTE -->
            <fieldset>
                <legend><strong>Información del paciente</strong></legend>
                <table width="100%" border="0" align="center">
                    <tr>
                        <td>
                            <label for="documento">N° de identificacion:</label>
                            <input type="text" name="documento" id="documento" class="textlarge"
                                   value="<?php echo $reg['id_paciente'] ?>" placeholder="Numero de documento"
                                   readonly="readonly"/>
                        </td>
                        <td><label for="paciente">Nombres y Apellidos:</label>
                            <input type="text" name="paciente" id="paciente" class="textlarge"
                                   value="<?php echo $reg['nombre'] ?>" readonly="readonly"
                                   placeholder="Nombres y Apellidos"/>
                        </td>
                        <td><label for="ubicacion">Edad:</label>
                            <input type="text" name="ubicacion" id="ubicacion" class="textlarge"
                                   value="<?php echo $reg['edad'] ?>" placeholder="Ubicacion del paciente"
                                   readonly="readonly"/>
                            <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>"/>
                        </td>
                        <td>
                            <label for="pesop">Peso:</label>
                            <input type="text" name="pesop" id="pesop" class="textlarge"
                                   value="<?php echo $reg['peso'] ?>" placeholder="Peso del paciente"/>

                            <div id="respuestapeso"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>

            <!-- CABECERA TIPO REALIZANCION DEL ESTUDIO-->
            <fieldset>
                <legend><strong>Tipo realizacion de estudio</strong></legend>
                <table width="100%" border="0" align="center">
                    <tr>
                        <td colspan="5">
                            <label for="estudio">Estudio:</label><br>
                            <input type="text" class="textlarge" name="estudio" id="estudio"
                                   value="<?php echo trim($reg['nom_estudio']) ?>" readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="tecnica">Tecnica:</label><br>
                            <input name="tecnica" type="text" class="text" value="<?php echo $reg['desc_tecnica'] ?>"
                                   readonly="readonly"/>
                            <input type="hidden" value="<?php echo $reg['id_tecnica'] ?>" name="id_tecnica"
                                   id="id_tecnica"/>
                        </td>
                        <td>
                            <label for="extremidad">Extremidad:</label><br>
                            <input name="text" type="text" class="text" value="<?php echo $reg['desc_extremidad'] ?>"
                                   readonly="readonly"/>
                        </td>
                        <td>
                            <label for="medicogeneral">Medico General:</label>
                            <input type="checkbox" id="medicogeneral" name="medicogeneral" value="1"
                                   onchange="validatemedicogeneral(this.checked)"/>
                        </td>
                        <td width="25%" colspan="2">
                            <label for="medicogeneral"> Nombre Medico General:</label><br>
                            <input type="text" class="textlarge" id="nombremedicogeneral" name="nombremedicogeneral"
                                   disabled/>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">
                            <div id="showma">
                                <label for="MAS0">MA:</label><br>
                                <input type="text" name="MAS0" id="MAS0" class="text" placeholder="MAS"
                                       onblur="calculatedose(0)"/>
                            </div>
                            <div id="showtiempo" style="display: none">
                                <label for="tiempofluoroscopia">Tiempo de Fluoroscopia (min):</label><br>
                                <input style="width: 3em" type="text" id="campo0" name="campo0" value="0"
                                       onblur="totaltiempofluoroscopia();"/>
                            </div>
                            <?php
                            if ($servicio == 2) {
                                $contomografiascolumnas = mysql_query("SELECT idestudio FROM r_estudio WHERE cod_iss='213609'", $cn);
                                while ($resul = mysql_fetch_array($contomografiascolumnas)) {
                                    if ($reg['idestudio'] == $resul['idestudio']) { ?>
                                        <label for="adicionales">Espacios Adicionales</label>
                                        <select name="adicionales" id="adicionales">
                                            <option value="0">Seleccione la cantidad de espacios adicionales</option>
                                            <?php for ($i = 1; $i <= 12; $i++) {

                                                if ($i == 1) {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"> <?php echo $i; ?> Espacio
                                                        Adicional
                                                    </option>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <option value="<?php echo $i; ?>"> <?php echo $i; ?> Espacios
                                                        Adicionales
                                                    </option>
                                                <?php }
                                            } ?>
                                        </select>
                                    <?php }
                                }

                            } ?>
                        </td>
                        <td width="20%">
                            <div id="showerror"></div>
                            <div id="showkv">
                                <label for="KV0">KV:</label><br>
                                <input type="text" name="KV0" id="KV0" class="text" placeholder="KV"
                                       onblur="calculatedose(0)"/>
                                <span class="asterisk1">*</span>
                            </div>
                            <a id="calculator" href="http://www.gelowdose.com/msv-calculator.php" target="_blank"
                               style="display: none">Ir
                                a la
                                calculadora</a>
                        </td>
                        <td width="20%">
                            <div id="showbutton" style="display: none">
                                <input type="button" onclick="AgregarCampos()" value="+"/>
                            </div>
                            <div id="showdistancia">
                                <label for="distancia0">Distancia:</label><br>
                                <input type="text" name="distancia0" id="distancia0" class="text"
                                       placeholder="Distancia"
                                       onblur="calculatedose(0)"/>
                                <span class="asterisk1">*</span>
                            </div>
                            <div id="show_DLP" style="display: none">
                                <label for="DLP">DLP</label><br/>
                                <input type="text" id="DLP" name="DLP" value="" placeholder="DLP"/>
                            </div>
                        </td>
                        <td width="20%">
                            <div id="showfoco">
                                <label for="foco0">Foco:</label><br>
                                <input type="text" name="foco0" id="foco0" class="text" placeholder="Foco"
                                       onblur="calculatedose(0)"/>
                                <span class="asterisk1">*</span>
                            </div>
                            <div id="showtiempototal" style="display: none">
                                <label for="tiempofluoroscopia">Tiempo Total (min):</label><br>
                                <input type="text" name="tiempofluoroscopia" id="tiempofluoroscopia" class="textlarge"
                                       placeholder="Tiempo de fluoroscopia en minutos" readonly/>
                                <span class="asterisk1">*</span>
                            </div>

                        </td>
                        <td width="20%">
                            <div id="showdosis">
                                <label for="Dosis">Total Dosis (mSv):</label><br/>
                                <input type="text" name="Dosis0" id="Dosis0" class="text"
                                       placeholder="Total Dosis de Radiacción" readonly onblur="Changedosis()"/>
                            </div>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="3" align="right"><br>

                            <div id="shownuevadosisbutton" style="display: none">
                                <input type="button" onclick="Clonar()" value="Agregar Nueva dosis"/>
                            </div>
                        </td>
                        <td colspan="2" align="right">
                            <div id="shownuevadosisinput" style="display: none">
                                <label for="Dosis">Acumalado Dosis (mSv):<br>
                                    <input type="text" name="Dosis" id="Dosis" placeholder="Acumulado"/><span
                                        class="asterisk">*</span>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td style="display:none">
                            <label for="i_dañadas">N° Imagenes Dañadas</label>
                            <input type="text" name="i_dañadas" id="i_dañadas" class="text" value="0"
                                   placeholder="imagenes dañadas"/>
                            <span class="asterisk1">*</span></td>
                        <td width="20%">
                            <div id="show_r_innecesarias" style="display: none">
                                <label for="r_inecesarias">N° Exposiciones a la Radiacci&oacute;n</label><br/>
                                <input type="text" name="r_innecesarias"
                                       id="r_innecesarias" class="text"
                                       value="" placeholder="N° Exposiciones a la Radiacci&oacute;n"/>
                            </div>
                        </td>
                        <td><?php if ($reg['id_tecnica'] == 3 || $reg['id_tecnica'] == 6) {
                            ?>
                            <label for="contrastereal">Cantidad de Contraste Utilizado en (cc):</label>
                            <input type="text" name="contrastereal" id="contrastereal"
                                   placeholder="Ingresa la cantidad de contraste utilizado" 
                                <?php if ($reg['id_tecnica'] == 3 || $reg['id_tecnica'] == 6) {
                                    echo 'style="display:block"';
                                } else {
                                    echo 'style="display:none"';
                                } ?> />
                                 
                            <div id="showmessage"> <span class="asterisk1">*</span>
                                <div>
                                    <?php } ?>


                                   
                        </td>
                        <td>

                        </td>

                        <td>

                            <?php if ($sede == 1 && $reg['idestudio'] == 879) {
                            } else { ?>
                        <td>Si
                            <input type="radio" name="lectura"
                                   id="lectura" <?php if ($servicio != 1) echo 'checked="checked"'; ?> value="2"/><span
                                class="asterisk1">*</span></td><?php } ?>
                        <?php if ($servicio == 1 || ($sede == 1 && $reg['idestudio'] == 879)) { ?>
                            <td width="10%">No
                                <input type="radio" name="lectura" id="lectura" value="10"/><span
                                    class="asterisk1">*</span></td><?php } ?>


                        </td>
                    </tr>

                    <tr>
                        <input type="hidden" name="usuario" id="usuario" value="<?php echo $idusuario ?>"/>
                        <input type="hidden" name="idInforme2" id="idInforme2" value="<?php echo $idInforme ?>"/>
                        <input type="hidden" name="sede" id="sede" value="<?php echo $sede ?>"/>
                        <input type="hidden" name="codiss" id="codiss" value="<?php echo $reg['cod_iss'] ?>"/>
                        <input type="hidden" name="servicio" id="servicio" value="<?php echo $servicio ?>"/>
                        <input type="hidden" name="portatil" id="portatil" value="<?php echo $reg['portatil'] ?>"/>
                        <input type="hidden" name="contador" id="contador" value="1">
                        <input type="hidden" name="MAS" id="MAS">
                        <input type="hidden" name="KV" id="KV">
                        <input type="hidden" name="distancia" id="distancia">
                        <input type="hidden" name="foco" id="foco">
                    </tr>
                    <tr>
                        <td>
                            <?php if ($sede == 3 && $servicio == 2) {
                                echo 'Realizado en Sotano';
                            }
                            ?>
                        </td>
                        <td><?php if ($reg['anestesia'] == 1) {
                                echo 'Anestesiologo';
                            } ?></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" name="sotano" id="sotano" value="1"
                                <?php if ($sede == 3 && $servicio == 2) {
                                    echo 'style="display:block"';
                                } else {
                                    echo 'style="display:none"';
                                } ?>/>
                        </td>
                        <td><input
                                style="<?php if ($reg['anestesia'] == 1) { ?>
                                    display:block;<?php } else { ?>
                                    display:none;<?php } ?>" type="text" id="anestesiologo" name="anestesiologo"
                                placeholder="Ingrese el nombre del anestesiologo" class="textlarge"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <td colspan="3">
                        <strong>Observaciones:</strong>
                    </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <textarea name="observacion"
                                      placeholder="Registre aqui sus comentarios y observaciones"
                                                                            rows="3"
                                                                            cols="60"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="1">
                            <div id="respuesta"></div>
                        </td>
                        <td colspan="1"></td>
                        <td colspan="1" align="right"><input name="Registrar" type="button" onclick="tomar()"  value="Realizado"/></td>
                    </tr> 
                </table>
            </fieldset>

        </form>
        </p>
        <!--Mostrar las devoluciones por especialista-->
        <fieldset>
            <legend><strong>Observaciones</strong></legend>
            <?php
            //consultar todas las observaciones
            $sqlComentario = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, CONCAT(f.nombres,' ', f.apellidos) AS nombre
		FROM r_observacion_informe o
		INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
		WHERE o.id_informe = '$idInforme'", $cn);
            $regComentario = mysql_num_rows($sqlComentario);
            if ($regComentario == 0 || $regComentario == "") {
                echo 'No se han registrado observaciones para este estudio';
            } else {
                while ($rowComentario = mysql_fetch_array($sqlComentario)) {
                    echo '<strong>' . $rowComentario['nombre'] . '</strong>hizo la siguiente observación, a las <strong>' . $rowComentario['hora'] . '</strong> del <strong>' . $rowComentario['fecha'] . '</strong><br><textarea readonly="readonly">' . $rowComentario['observacion'] . '</textarea></br>';
                }
            }
            ?>
        </fieldset>
        <fieldset>
            <legend><strong>Comentarios por devoluciones</strong></legend>
            <?php
            //consultar cantidad de devoluciones
            $sqldevuelto = mysql_query("SELECT o.comentario, o.fecha,CONCAT(f.nombres,'', f.apellidos) AS medico,m.desc_motivo
	FROM r_estudiodevuelto o
	INNER JOIN funcionario f ON f.idfuncionario = o.usuario
INNER JOIN r_motivodevolucion m ON m.idmotivo= o.idmotivo
	WHERE o.id_informe = '$idInforme'", $cn);
            $regdevuelto = mysql_num_rows($sqldevuelto);
            if ($regdevuelto == 0 || $regdevuelto == "") {
                echo 'No se han registrado observaciones de devoluciones';
            } else {
                while ($rowDevuelto = mysql_fetch_array($sqldevuelto)) {
                    echo '<strong>Devuelto por motivo de: </strong>' . $rowDevuelto['desc_motivo'] . '';
                    echo '<strong>' . $rowDevuelto['medico'] . '</strong> hizo la siguiente observación, el dia <strong>' . $rowDevuelto['fecha'] . '</strong></br><textarea readonly="readonly">' . $rowDevuelto['comentario'] . '</textarea></br>';
                }
            }
            ?>
        </fieldset>
    </div>
</div>
<script type="text/javascript">





    var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {useCharacterMasking: true});
    var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "integer", {
        useCharacterMasking: true,
        isRequired: false
    });
</script>
</body>
</html>