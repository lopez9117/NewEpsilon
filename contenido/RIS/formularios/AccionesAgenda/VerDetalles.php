<?php
//conexion a la BD
include("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idInforme = base64_decode($_GET['idInforme']);
$usuario = base64_decode($_GET['usuario']);
//obtener los datos de la agenda
$validate = mysql_query("SELECT id_estadoinforme FROM r_informe_header
	WHERE id_informe = '$idInforme'", $cn);
$regvalidate = mysql_fetch_array($validate);
$validate1 = mysql_query("SELECT id_estadoinforme,hora FROM r_log_informe WHERE id_informe = '$idInforme' and id_estadoinforme='11'", $cn);
$regvalidate1 = mysql_fetch_array($validate1);
$sql = mysql_query("SELECT l.hora, l.id_informe, l.fecha, i.id_paciente, i.idestudio, i.id_prioridad, i.id_extremidad, i.id_tecnica,i.ubicacion, i.idservicio,i.idsede,
	CONCAT(p.nom1,' ',p.nom2,'<br>',p.ape1,' ',p.ape2) AS nombre, p.edad, es.nom_estudio, pr.desc_prioridad, t.desc_tecnica,rif.insumos,rif.cantidadinsumos FROM r_log_informe l
	INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
	INNER JOIN r_informe_facturacion rif ON i.id_informe=rif.id_informe
	INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
	INNER JOIN r_estudio es ON es.idestudio = i.idestudio
	INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
	INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
	WHERE i.id_informe = '$idInforme'", $cn);
$reg = mysql_fetch_array($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <link rel="stylesheet" href="../../bootstrap-3.3.2-dist/css/bootstrap.min.css">
    <script language="JavaScript" src="../../../../js/ajax.js"></script>
    <script src="../../../../js/jquery-1.9.1.js"></script>
    <script src="../../../../js/jquery.js"></script>
    <script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
    <link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css"/>
    <script src="js/VerDetalles.js"></script>
    <title>.: Detalles :.</title>
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        fieldset {
            width: 98%;
            border-color: #FFF;
        }

        .ui-autocomplete {
            position: fixed;
            z-index: 2147483647;
        }

        .modal-dialog {
            width: 100%;
        }
    </style>

</head>

<body onload="HoraActual()">
<form id="observacion" name="observacion" method="post" action="AccionAddObservacion.php">
    <fieldset>
        <legend><strong>Detalles de la cita</strong></legend>
        <table width="100%" border="0" align="center">
            <tr>
                <td colspan="4" bgcolor="#CCCCCC" style="color:#333"><strong>Paciente:</strong></td>
            </tr>
            <tr>
                <td><strong>N° de identificacion: </strong><?php echo $reg['id_paciente'] ?></td>
                <td width="46%"><strong>Nombres y Apellidos: </strong><?php echo $reg['nombre'] ?></td>
                <td width="23%"><strong>Edad: </strong><?php echo $reg['edad'] ?>(S)</td>
            </tr>
            <tr>
                <td colspan="4" bgcolor="#CCCCCC" style="color:#333"><strong>Información del estudio:</strong>&nbsp;
                </td>
            </tr>
            <tr>
                <td><strong>Estudio: </strong><?php echo $reg['nom_estudio'] ?></td>
                <td><strong>Tecnica: </strong><?php echo $reg['desc_tecnica'] ?></td>
                <td><strong>Fecha y hora:</strong><?php echo $reg['fecha'] ?>
                    <strong>/</strong><?php echo $reg['hora'] ?></td>
                <td>
                    <?php if (($reg['idservicio'] == 5 || $reg['idservicio'] == 23) && $reg['idsede'] == 3) { ?>
                        <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalinsumos"
                               value="Agregar Insumos"/>
                    <?php }
                    ?></td>
            </tr>
            <tr>
                <td colspan="4"><strong>Observacion:</strong><input name="tipo_comentario" type="radio" value="1"
                                                                    checked="checked"/>
                    <strong>Evento Adverso:</strong>
                    <input name="tipo_comentario" type="radio" value="2"/></td>
            </tr>
            <tr>
                <td colspan="4" bgcolor="#CCCCCC" style="color:#333"><strong>Observacion:</strong></td>
            </tr>
            <tr>
                <td colspan="4"><textarea name="observacion" placeholder="Registre aqui sus comentarios y observaciones"
                                          style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;"
                                          rows="4" cols="60"></textarea></td>
            </tr>
            <tr>
                <td width="31%">
                    <?php if ($regvalidate['id_estadoinforme'] == 1 && $regvalidate1['id_estadoinforme'] != 11) {

                        echo '<strong>Marcar Hora llegada:</strong>';
                        echo '</div><input name="horallegada" type="checkbox" value="1" onclick="horallega()"/>';
                        echo '<div id="contenedor_reloj" style="display:none"">';
                    } else {
                        echo '<strong>Hora de llegada del paciente:</strong><br/>';
                        echo $regvalidate1['hora'];
                    }
                    ?>
                </td>

                <td align="right" colspan="2">

                </td>
            </tr>
            <tr>
                <td width="31%"><input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"/>
                    <input type="hidden" name="informe" id="informe" value="<?php echo $idInforme ?>"/>

                    <div id="respuesta"></div>
                </td>
                <td align="right" colspan="3"><input type="button" value="Agregar Observacion"
                                                     onClick="enviarObservacion()" class="btn btn-success"/></td>
            </tr>
        </table>
    </fieldset>
    <input type="hidden" id="sede" value="<?php echo $reg['idsede'] ?>"/>
    <input type="hidden" id="servicio" value="<?php echo $reg['idservicio'] ?>"/>
    <input type="hidden" id="insumos" name="insumos"/>
    <input type="hidden" id="cantidades" name="cantidades"/>

    <div class="modal fade" id="modalinsumos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar o Retirar Insumos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="contenedor">
                            <?php

                            if ($reg['insumos'] != 0) {
                                $insumoshg = explode('-', $reg['insumos']);
                                $cantidadinsumoshg = explode('-', $reg['cantidadinsumos']);
                                $counthg = count($insumoshg);

                                for ($i = 0; $i <= ($counthg - 1); $i++) {
                                    $coninsumoshg = mysql_query("SELECT id,desc_insumo FROM r_insumos WHERE id='$insumoshg[$i]'", $cn);
                                    $reginsumoshg = mysql_fetch_array($coninsumoshg); ?>

                                    <div id="row<?php echo $i; ?>">
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 form-group">
                                            <?php if ($i == 0) { ?>
                                                <label for="buscarinsumos0">Insumo:</label>
                                            <?php } ?>
                                            <input type="text" name="buscarinsumos[]"
                                                   id="buscarinsumos<?php echo $i; ?>"
                                                   value="<?php echo trim($reginsumoshg['id']) . ' - ' . trim($reginsumoshg['desc_insumo']) ?>"
                                                   class="form-control"
                                                   onfocus="buscarInsumos()"/>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-group">
                                            <?php if ($i == 0) { ?>
                                                <label for="cantidad">Cantidad:</label>
                                            <?php } ?>
                                            <input type="text" name="cantidad[]" id="cantidad<?php echo $i; ?>"
                                                   value="<?php echo $cantidadinsumoshg[$i] ?>"
                                                   class="form-control"/>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-group">
                                            <?php if ($i == 0) { ?>
                                                <br/>
                                                <button type="button" class="btn btn-success"
                                                        onClick="Clonar()"
                                                        id="agregar">
                                                    Agregar
                                                </button>
                                            <?php } else { ?>
                                                <button type="button"
                                                        class="btn btn-danger"
                                                        onClick="eliminar('row<?php echo $i; ?>')" id="Eliminar">
                                                    Eliminar
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>

                                <?php
                                } ?>
                                <input type="hidden" id="contador" value="<?php echo $i ?>">
                            <? } else {
                                ?>
                                <div id="row0">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 form-group">
                                        <label for="buscarinsumos0">Insumo:</label>
                                        <input type="text" name="buscarinsumos[]" id="buscarinsumos0"
                                               class="form-control"
                                               onfocus="buscarInsumos()"/>
                                    </div>
                                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 form-group">
                                        <label for="cantidad">Cantidad:</label>
                                        <input type="text" name="cantidad[]" id="cantidad0" value="1"
                                               class="form-control"/>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 form-group">
                                        <br>
                                        <button type="button" class="btn btn-success" onClick="Clonar()"
                                                class="btn btn-primary"
                                                id="agregar">
                                            Agregar
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" id="contador" value="1">
                            <?php } ?>

                            <div class="error_form">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                            onclick="saveinsumos('<?php echo $reg['idservicio'] ?>')" data-dismiss="modal">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>

</form>
<!-- Mostrar las observaciones registradas durante el proceso -->
<fieldset>
    <legend><strong>Observaciones:</strong></legend>
    <?php
    //consultar cantidad de comentarios
    $sqlComentario = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, f.nombres, f.apellidos
	FROM r_observacion_informe o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
	WHERE o.id_informe = '$idInforme' AND id_tipocomentario=1", $cn);
    $regComentario = mysql_num_rows($sqlComentario);
    echo '<table width="100%" border="0" align="center">';
    if ($regComentario == 0 || $regComentario == "") {
        echo '<tr><td>No se han registrado observaciones para este estudio</td></tr>';
    } else {
        while ($rowComentario = mysql_fetch_array($sqlComentario)) {
            echo '<tr>
			<td><strong>' . $rowComentario['nombres'] . '&nbsp;' . $rowComentario['apellidos'] . '</strong>hizo la siguiente observación, a las <strong>' . $rowComentario['hora'] . '</strong> del <strong>' . $rowComentario['fecha'] . '</strong><br><textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">' . $rowComentario['observacion'] . '</textarea></td>
			</tr>';
        }
    }
    echo '</table>';
    ?>
</fieldset>
<?php
//consultar cantidad de devoluciones
$sqldevuelto = mysql_query("SELECT o.comentario, o.fecha,CONCAT(f.nombres,'', f.apellidos) AS medico,m.desc_motivo
	FROM r_estudiodevuelto o
	INNER JOIN funcionario f ON f.idfuncionario = o.usuario
INNER JOIN r_motivodevolucion m ON m.idmotivo= o.idmotivo
	WHERE o.id_informe = '$idInforme'", $cn);
$regdevuelto = mysql_num_rows($sqldevuelto);
?>
<fieldset>
    <?php
    echo '<table width="100%" border="0" align="center">';
    ?>
    <legend><strong>Devoluciones por Especialista</strong></legend>
    <?php
    if ($regdevuelto == 0 || $regdevuelto == "") {
        echo '<tr><td>No se han registrado devoluciones para este estudio</td></tr>';
    } else {
        while ($rowDevuelto = mysql_fetch_array($sqldevuelto)) {
            echo '<tr>
			<td><strong>Devuelto por motivo de: </strong>' . $rowDevuelto['desc_motivo'] . '</td>
			</tr>';
            echo '<tr>
			<td><strong>' . $rowDevuelto['medico'] . '</strong> hizo la siguiente observación, el dia <strong>' . $rowDevuelto['fecha'] . '</strong><br>		<textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">' . $rowDevuelto['comentario'] . '</textarea></td>
			</tr>';
        }
        ?>

    <?php
    }
    echo '</table>';
    ?>
    <!-- Mostrar las observaciones registradas durante el proceso -->
</fieldset>
</form>
<fieldset>
    <?php
    echo '<table width="100%" border="0" align="center">';
    ?>
    <legend><strong>Cancelado</strong></legend>
    <?php
    //consultar los cancelados
    $sqlcancel = mysql_query("SELECT o.id_informe,o.comentario, o.fecha,CONCAT(f.nombres,'', f.apellidos) AS funcionario, c.desc_motivo FROM r_comentmotivocancel o
INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
INNER JOIN r_motivocancel c ON c.id_motivo = o.id_motivo WHERE id_informe='$idInforme';", $cn);
    $regcancel = mysql_num_rows($sqlcancel);
    if ($regcancel == 0 || $regcancel == "") {
        echo '<tr><td>No se han registrado cancelaciones para este estudio</td></tr>';
    } else {
        while ($rowCancel = mysql_fetch_array($sqlcancel)) {
            echo '<tr>
			<td><strong>Motivo de cancelación: </strong>' . $rowCancel['desc_motivo'] . '</td>
			</tr>';
            echo '<tr>
			<td><strong>' . $rowCancel['funcionario'] . '</strong> hizo la siguiente observación, el dia <strong>' . $rowCancel['fecha'] . '</strong><br>		<textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">' . $rowCancel['comentario'] . '</textarea></td>
			</tr>';
        }
    }
    echo '</table>';
    ?>
</fieldset>
<fieldset>
    <?php
    echo '<table width="100%" border="0" align="center">';
    ?>
    <legend><strong>Eventos Adversos:</strong></legend>
    <?php
    $sqlEvent = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, f.nombres, f.apellidos
	FROM r_observacion_informe o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
	WHERE o.id_informe = '$idInforme' AND id_tipocomentario=2", $cn);
    $regEvent = mysql_num_rows($sqlEvent);
    if ($regEvent == 0 || $regEvent == "") {
        echo '<tr><td>No se han registrado cancelaciones para este estudio</td></tr>';
    } else {
        while ($rowEvent = mysql_fetch_array($sqlEvent)) {
            echo '<td><strong>' . $rowEvent['nombres'] . '&nbsp;' . $rowEvent['apellidos'] . '</strong>hizo el siguiente evento adverso, a las <strong>' . $rowEvent['hora'] . '</strong> del <strong>' . $rowEvent['fecha'] . '</strong><br><textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">' . $rowEvent['observacion'] . '</textarea></td>
			</tr>';
        }
    }
    echo '</table>';
    ?>
</fieldset>
<fieldset>
    <?php
    echo '<table width="100%" border="0" align="center">';
    ?>
    <legend><strong>Notas Medicas:</strong></legend>
    <?php
    $sqlNota = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, f.nombres, f.apellidos
	FROM r_observacion_informe o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
	WHERE o.id_informe = '$idInforme' AND id_tipocomentario=4", $cn);
    $regNota = mysql_num_rows($sqlNota);
    if ($regNota == 0 || $regNota == "") {
        echo '<tr><td>No se han registrado Notas Medicas para este estudio</td></tr>';
    } else {
        while ($rowNota = mysql_fetch_array($sqlNota)) {
            echo '<td><strong>' . $rowNota['nombres'] . '&nbsp;' . $rowNota['apellidos'] . '</strong>hizo la siguiente nota medica, a las <strong>' . $rowNota['hora'] . '</strong> del <strong>' . $rowNota['fecha'] . '</strong><br><textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">' . $rowNota['observacion'] . '</textarea></td>
			</tr>';
        }
    }
    echo '</table>';
    ?>
</fieldset>
<fieldset>
    <?php
    echo '<table width="100%" border="0" align="center">';
    ?>
    <legend><strong>Notas de enfermeria:</strong></legend>
    <?php
    $sqlEnfer = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, f.nombres, f.apellidos
	FROM r_observacion_informe o
	INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
	WHERE o.id_informe = '$idInforme' AND id_tipocomentario=5", $cn);
    $regEnfer = mysql_num_rows($sqlEnfer);
    if ($regEnfer == 0 || $regEnfer == "") {
        echo '<tr><td>No se han registrado notas de enfermeria para este estudio</td></tr>';
    } else {
        while ($rowEnfer = mysql_fetch_array($sqlEnfer)) {
            echo '<td><strong>' . $rowEnfer['nombres'] . '&nbsp;' . $rowEnfer['apellidos'] . '</strong>hizo la siguiente nota de enfermeria, a las <strong>' . $rowEnfer['hora'] . '</strong> del <strong>' . $rowEnfer['fecha'] . '</strong><br><textarea style="font-family:Arial, Helvetica, sans-serif; font-size:12px; width:99%;" rows="3" cols="60" readonly="readonly">' . $rowEnfer['observacion'] . '</textarea></td>
			</tr>';
        }
    }
    echo '</table>';
    ?>
</fieldset>
<script src="../../bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>