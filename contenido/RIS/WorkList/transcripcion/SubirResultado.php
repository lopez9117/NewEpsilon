<?php
//archivo de conexion
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
//variables GET
$idInforme = base64_decode($_GET['informe']);
$usuario = base64_decode($_GET['usuario']);
//obtener los datos del encabezado para el informe
$sqlHeader = mysql_query("SELECT i.id_informe, i.ubicacion,i.idsede,i.id_paciente, i.idestudio, i.orden, i.id_extremidad,
 i.idfuncionario_esp,rif.insumos,rif.cantidadinsumos,rif.eco_biopsia,rif.guia,rif.bilateral,CONCAT(p.nom1,' ', p.nom2,' ',p.ape1,' ', p.ape2) AS nombre, p.fecha_nacimiento,
 p.edad, e.nom_estudio,e.idservicio,t.id_tecnica,eps.desc_eps,sex.desc_sexo, l.fecha, l.hora, t.desc_tecnica, i.desc_extremidad,p.peso,
 CONCAT(f.nombres,' ', f.apellidos) AS nombres, (ex.desc_extremidad) AS lado FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_sexo sex ON sex.id_sexo = p.id_sexo
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN r_extremidad ex ON ex.id_extremidad = i.id_extremidad
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
INNER JOIN eps eps ON p.ideps=eps.ideps
LEFT JOIN r_informe_facturacion rif ON rif.id_informe=i.id_informe
WHERE i.id_informe = '$idInforme' AND l.id_estadoinforme = 5", $cn);
$regHeader = mysql_fetch_array($sqlHeader);
$especialista = $regHeader['idfuncionario_esp'];
//obtener contenido del informe
$consInforme = mysql_query("SELECT * FROM r_detalle_informe WHERE id_informe = '$idInforme'", $cn);
$regsInforme = mysql_fetch_array($consInforme);
//validar si el especialista requiere de firma de respaldo
$conFirma = mysql_query("SELECT * FROM r_especialista WHERE idfuncionario_esp = '$especialista' AND firma_respaldo = '1' ", $cn);
$regFirma = mysql_num_rows($conFirma);
//obtener la tecnica del estudio si ya se ha registrado
$consTecnica = mysql_query("SELECT contenido FROM r_tecnica_estudio WHERE id_informe = '$idInforme'", $cn);
$regsTecnica = mysql_fetch_array($consTecnica);
//consulta de insumos biopsias por sede.
$idsede = $regHeader['idsede'];
$idservicio = $regHeader['idservicio'];
$conInsumos = mysql_query("SELECT * FROM r_insumos ri inner join r_sede_insumos rsi on ri.id=rsi.idinsumo where rsi.idsede='$idsede' AND ri.servicio='$idservicio' AND rsi.estado='1'", $cn);
//consulta de ecografias para agracion a la biopsia
$ecografias = mysql_query("SELECT idestudio,concat(cups_iss,' - ',nom_estudio) AS nombre FROM r_estudio WHERE idservicio =3 and idestado=1", $cn);
//consulta de las tomografias que se pueden utilizar
$tomografias = mysql_query("SELECT idestudio,concat(cups_iss,' - ',nom_estudio) AS nombre FROM r_estudio WHERE idservicio =2 and idestado=1", $cn);

$guia = $regHeader['guia'];
$estudio = $regHeader['eco_biopsia'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <link href="../../bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet"/>
    <!--<link href="../../bootstrap-3.3.2-dist/css/bootstrap-theme.min.css" rel="stylesheet"/>-->
    <title>.: Publicar Informe :.</title>
    <script type="text/javascript" src="../../../../js/ajax.js"></script>
    <script src="../../../../js/jquery-1.9.1.js"></script>
    <script src="../../../../js/jquery.js"></script>
    <script src="../../../../js/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" language="javascript" src="../../../../js/ajax.js"></script>
    <link href="../../../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css"/>
    <link href="../../styles/forms.css" rel="stylesheet" type="text/css">
    <script src="../ckeditor/ckeditor.js"></script>
    <!--    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
    <!--    <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
    <!--    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
    <!--    <link rel="stylesheet" href="/resources/demos/style.css">-->
    <style type="text/css">

        .ui-autocomplete {
            position: fixed;
            z-index: 2147483647;
        }

        .form-group input[type="checkbox"] {
            display: none;
        }

        .form-group input[type="checkbox"] + .btn-group > label span {
            width: 15px;
        }

        .form-group input[type="checkbox"] + .btn-group > label span:first-child {
            display: none;
        }

        .form-group input[type="checkbox"] + .btn-group > label span:last-child {
            display: inline-block;
        }

        .form-group input[type="checkbox"]:checked + .btn-group > label span:first-child {
            display: inline-block;
        }

        .form-group input[type="checkbox"]:checked + .btn-group > label span:last-child {
            display: none;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            background: -moz-linear-gradient(top, rgba(232, 232, 232, 1) 0%, rgba(232, 232, 232, 0.99) 1%, rgba(229, 229, 229, 0.55) 45%, rgba(229, 229, 229, 0) 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(232, 232, 232, 1)), color-stop(1%, rgba(232, 232, 232, 0.99)), color-stop(45%, rgba(229, 229, 229, 0.55)), color-stop(100%, rgba(229, 229, 229, 0))); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top, rgba(232, 232, 232, 1) 0%, rgba(232, 232, 232, 0.99) 1%, rgba(229, 229, 229, 0.55) 45%, rgba(229, 229, 229, 0) 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top, rgba(232, 232, 232, 1) 0%, rgba(232, 232, 232, 0.99) 1%, rgba(229, 229, 229, 0.55) 45%, rgba(229, 229, 229, 0) 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top, rgba(232, 232, 232, 1) 0%, rgba(232, 232, 232, 0.99) 1%, rgba(229, 229, 229, 0.55) 45%, rgba(229, 229, 229, 0) 100%); /* IE10+ */
            background: linear-gradient(to bottom, rgba(232, 232, 232, 1) 0%, rgba(232, 232, 232, 0.99) 1%, rgba(229, 229, 229, 0.55) 45%, rgba(229, 229, 229, 0) 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e8e8e8', endColorstr='#00e5e5e5', GradientType=0); /* IE6-9 */
        }

        fieldset {
            width: 98%;
            border-color: #FFF;
        }

        table {
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        input.text {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            width: 88%;
        }

        textarea {
            font-family: Verdana, Geneva, sans-serif;
            font-size: 12px;
            width: 100%;
            height: 55px;
            resize: none;
        }

        #lectura {
            height: 350px;
            width: 100%;
            border: 1px solid #ddd;
            background: #FFF;
            overflow-y: scroll;
        }

        #tecnica {
            height: 70px;
            width: 100%;
            border: 1px solid #ddd;
            background: #FFF;
            overflow-y: scroll;
        }

        #modalinsumosbiopsias .modal-dialog {
            width: 98%;
        }

        }
        .custom-combobox {
            position: relative;
            display: inline-block;
        }

        .custom-combobox-toggle {
            position: absolute;
            top: 0;
            bottom: 0;
            margin-left: -1px;
            padding: 0;
        }

        .custom-combobox-input {
            margin: 0;
            padding: 5px 10px;
            width: 95%;
        }

    </style>
    <!--    <script language="javascript">-->
    <!--     -->
    <!---->
    <!--    </script>-->
</head>
<body onBeforeUnload="return window.opener.cargarResultados()" class="body">
<form name="Informe" id="Informe" method="post" action="../acciones/PublicarResultado.php">
    <fieldset>
        <legend><strong>Informe de Lectura:</strong></legend>
        <table width="100%" border="0">
            <tr>
                <td width="20%"><strong>Paciente:</strong></td>
                <td width="20%"><strong>N° de documento: </strong><?php echo $regHeader['id_paciente'] ?></td>
                <td width="20%"><strong>N° de Ingreso: </strong><?php echo $regHeader['orden'] ?></td>
                <td width="20%"><strong>Edad: </strong><?php echo $regHeader['edad'] ?>(S)</td>
                <td width="20%"><strong>Peso: </strong><?php echo $regHeader['peso'] ?> KG(S)</td>
            </tr>
            <tr>
                <td><?php echo $regHeader['nombre'] ?></td>
                <td><strong>Ubicación: </strong> <?php echo $regHeader['ubicacion'] ?></td>
                <td><strong>Fecha de la cita: </strong><?php echo $regHeader['fecha'] ?></td>
                <td><strong>Hora de la cita: </strong><?php echo $regHeader['hora'] ?></td>
                <td><strong>Genero: </strong><?php echo $regHeader['desc_sexo'] ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Estudio: </strong><?php echo $regHeader['nom_estudio'] ?></td>
                <td><strong>Tecnica: </strong><?php echo $regHeader['desc_tecnica'] ?></td>
                <td><strong>Extremidad: </strong><?php echo $regHeader['desc_extremidad'] ?></td>
                <td><strong>EPS: </strong><?php echo $regHeader['desc_eps'] ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong>Adicional: </strong>
                    <input class="text" type="text" name="adicional" id="adicional"
                           value="<?php echo $regsInforme['adicional'] ?>"
                           placeholder="Registre aqui las adiciones al estudio"/></td>
                <td colspan="2"><strong>Lado: </strong><?php echo $regHeader['lado'] ?>
                    <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>"/>
                    <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>"/>
                    <input type="hidden" name="opcion"/></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Tecnica:</strong></td>
                <td>&nbsp;</td>
                <td colspan="2" align="right"> <?php
                    if ($regHeader['idservicio'] == 7) {
                        echo '<button onclick="validateguiasonload(' . $guia . ',' . $estudio . ')" type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalinsumosbiopsias">Agregacion Insumos y Materiales</button>';
                    } elseif ($regHeader['idservicio'] == 8 && $regHeader['idsede'] == 1) {
                        echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalinsumos">Agregacion Insumos y Materiales</button>';
                    } elseif ($regHeader['idservicio'] == 5 || $regHeader['idservicio'] == 4 && $regHeader['idsede'] == 3) {
                        echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalinsumos">Agregacion Insumos y Materiales</button>';
                    } elseif ($regHeader['idservicio'] == 23 && ($regHeader['idsede'] == 3 || $regHeader['idsede'] == 1)) {
                        echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalinsumos">Agregacion Insumos y Materiales</button>';
                    }
                    ?>
                    <input type="hidden" id='hiddenservicio' name="hiddenservicio"
                           value="<?php echo $regHeader['idservicio'] ?>"></td>
            </tr>
            <tr>
                <td colspan="5"><textarea class="ckeditor" cols="80" id="tecnica" name="tecnica"
                                          rows="10"><?php echo $regsTecnica['contenido'] ?></textarea></td>
            </tr>
            <tr>
                <td colspan="5"><strong>Informe:</strong></td>
            </tr>
            <tr>
                <td colspan="5"><textarea class="ckeditor" cols="80" id="informe" name="informe"
                                          rows="10"><?php echo $regsInforme['detalle_informe'] ?></textarea></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Leido por</strong> :<?php echo $regHeader['nombres'] ?></td>
                <td>
                    <?php
                    if ($regFirma == 1) {
                        $consEspecialista = mysql_query("SELECT e.idfuncionario_esp, e.reg_medico, u.nom_universidad, f.nombres, f.apellidos FROM r_especialista e
				INNER JOIN r_universidad u ON u.iduniversidad = e.iduniversidad
				INNER JOIN funcionario f ON f.idfuncionario = e.idfuncionario_esp
				WHERE e.reg_medico != '' AND e.reg_medico != 2 AND e.firma_respaldo = 2 ORDER BY f.nombres ASC", $cn);

                        echo '<select name="firmaRespaldo">';
                        echo '<option value="">.: Seleccione firma de respaldo :.</option>';
                        while ($regEspecialista = mysql_fetch_array($consEspecialista)) {
                            echo '<option value="' . $regEspecialista['idfuncionario_esp'] . '">' . $regEspecialista['nombres'] . '&nbsp;' . $regEspecialista['apellidos'] . '</option>';
                        }
                        echo '</select>';
                    }
                    ?>
                </td>
                <td colspan="2" align="right">
                    <input type="button" name="button" id="button" value="Guardar Parcial"
                           onclick="Guardar('parcial')"/>
                    <input type="button" name="button2" id="button2" value="Guardar y Finalizar"
                           onclick="Guardar('finalizar')"/>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <legend><strong>Registrar Observación</strong></legend>
        <table width="100%" align="center">
            <tr>
                <td colspan="5">
                    <textarea name="observacionTranscripcion"></textarea>
                </td>
            </tr>
        </table>
    </fieldset>
    <table width="100%" align="center">
        <tr>
            <td width="100%"><a class="texto" href="javascript:MostrarOcultar('observaciones');">Ver / Ocultar todas las
                    observaciones</a></td>
        </tr>
    </table>

    <input type="hidden" name="guias" id="guias">
    <input type="hidden" name="biopsiabilateral" id="biopsiabilateral">
    <input type="hidden" name="eco_biopsia" id="eco_biopsia">
    <input type="hidden" name="insumos" id="insumos">
    <input type="hidden" name="cantidades" id="cantidades">
    <input type="hidden" id="idsede" value="<?php echo $idsede ?>"/>
    <input type="hidden" id="idservicio" value="<?php echo $idservicio ?>"/>

    <!----------------------MODAL PARA LA AGREGACION DE INSUMOS Y MATERIALES EN BIOPSIAS---------------->
    <?php if ($regHeader['idservicio'] == 7) { ?>
        <div class="modal fade" id="modalinsumosbiopsias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
                            <?php
                            $insumos = $regHeader['insumos'];
                            $selectinsumos = explode('-', $insumos);
                            $countselectinsumos = count($selectinsumos);

                            $cantidadinsumos = $regHeader['cantidadinsumos'];
                            $arraycantidad = explode('-', $cantidadinsumos);
                            while ($resultado = mysql_fetch_array($conInsumos)) {
                                ?>
                                <div class="col-xs-10 col-sm-10 col-md-5 col-lg-5">
                                    <div class="[ form-group ]">

                                        <input type="checkbox" name="check<?php echo $resultado['id'] ?>"
                                               id="check<?php echo $resultado['id'] ?>"
                                               value="<?php echo $resultado['id'] ?>"
                                               autocomplete="off"
                                               onchange="habilitarinputs(<?php echo $resultado['id'] ?>)"
                                            <?php for ($i = 0; $i < $countselectinsumos; $i++) {
                                                if ($resultado['id'] == $selectinsumos[$i]) {
                                                    echo 'checked';
                                                }
                                            }
                                            ?>/>

                                        <div class="[ btn-group ]">
                                            <label for="check<?php echo $resultado['id'] ?>"
                                                   class="[ btn btn-sm btn-primary ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="check<?php echo $resultado['id'] ?>"
                                                   class="[ btn btn-sm btn-default active ]">
                                                <?php echo $resultado['desc_insumo'] ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                    <input class="input-sm form-control" type="text"
                                           id="input<?php echo $resultado['id'] ?>"
                                           name="input<?php echo $resultado['id'] ?>"
                                        <?php for ($i = 0; $i < $countselectinsumos; $i++) {
                                            if ($resultado['id'] == $selectinsumos[$i]) { ?>
                                                value="<?php echo $arraycantidad[$i] ?>"
                                            <?php }
                                        }
                                        ?>
                                        />

                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <div class="[ form-group ]">

                                        <input type="checkbox" name="guiaecografica"
                                               id="guiaecografica"
                                               value="1048"
                                               autocomplete="off"
                                               onchange="validateguias('guiaecografica','guiatomografica')"
                                            <?php
                                            if ($regHeader['guia'] == 1048) {
                                                echo 'checked';
                                            }

                                            ?>/>


                                        <div class="[ btn-group ]">
                                            <label for="guiaecografica"
                                                   class="[ btn btn-sm btn-warning ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="check<?php echo $resultado['id'] ?>"
                                                   class="[ btn btn-sm btn-default active ]">
                                                GUIA ECOGRAFIA
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <div class="[ form-group ]">

                                        <input type="checkbox" name="guiatomografica"
                                               id="guiatomografica"
                                               value="166"
                                               onchange="validateguias('guiatomografica','guiaecografica')"
                                            <?php
                                            if ($regHeader['guia'] == 166) {
                                                echo 'checked';
                                            }
                                            ?>
                                            />

                                        <div class="[ btn-group ]">
                                            <label for="guiatomografica"
                                                   class="[ btn btn-sm btn-warning ]">
                                                <span class="[ glyphicon glyphicon-ok ]"></span>
                                                <span> </span>
                                            </label>
                                            <label for="check<?php echo $resultado['id'] ?>"
                                                   class="[ btn btn-sm btn-default active ]">
                                                GUIA TOMOGRAFICA
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                <div class="[ form-group ]">

                                    <input type="checkbox" name="bilateral" id="bilateral" value="1"
                                           autocomplete="off"
                                        <?php if ($resultado['bilateral'] > 0) {
                                            echo 'checked';
                                        }

                                        ?>/>

                                    <div class="[ btn-group ]">
                                        <label for="bilateral"
                                               class="[ btn btn-sm btn-success ]">
                                            <span class="[ glyphicon glyphicon-ok ]"></span>
                                            <span> </span>
                                        </label>
                                        <label for="bilateral"
                                               class="[ btn btn-sm btn-default active ]">
                                            BIOPSIA O DRENAJE BILATERAL
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="selectguiaecografica" style="display: none">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="selguiaecografica">Seleccione la Ecografia</label>

                                <div class="ui-widget">
                                    <select id="selguiaecografica" name="selguiaecografica">
                                        <option value="0">Seleccionar Ecografia</option>
                                        <?php
                                        while ($ecos = mysql_fetch_array($ecografias)) {
                                            ?>
                                            <option value="<?php echo $ecos['idestudio'] ?>"
                                                <?php
                                                if ($ecos['idestudio'] == $regHeader['eco_biopsia']) {
                                                    echo 'selected';
                                                }
                                                ?>
                                                >
                                                <?php echo $ecos['nombre'] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="selectguiatomografica" style="display: none">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <label for="selguiatomografica">Seleccione la Tomografia</label>

                                <div class="ui-widget">
                                    <select class="form-control" id="selguiatomografica" name="selguiatomografica">
                                        <option value="0">Seleccionar Tomografia</option>
                                        <?php
                                        while ($tomos = mysql_fetch_array($tomografias)) {
                                            ?>
                                            <option value="<?php echo $tomos['idestudio'] ?>"
                                                <?php
                                                if ($tomos['idestudio'] == $regHeader['eco_biopsia']) {
                                                    echo 'selected';
                                                }
                                                ?>
                                                >
                                                <?php echo $tomos['nombre'] ?></option>0
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } // MODAL PARA LA AGREGACION DE INSUMOS Y MATERIALES EN GASTRO


    elseif
    ($regHeader['idservicio'] == 5 || $regHeader['idservicio'] == 8 || $regHeader['idservicio'] == 23
    ) { ?>
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
                                if ($regHeader['insumos'] != 0) {
                                    $insumoshg = explode('-', $regHeader['insumos']);
                                    $cantidadinsumoshg = explode('-', $regHeader['cantidadinsumos']);
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
                                                       value="<?php echo $reginsumoshg['id'] . ' - ' . $reginsumoshg['desc_insumo'] ?>"
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
                                                            onClick="eliminar('row<?php echo $i; ?>')"
                                                            id="Eliminar">
                                                        Eliminar
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div>

                                    <?php
                                    } ?>
                                    <input type="hidden" id="contador" value="<?php echo $i ?>">
                                <?php } else {
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
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</form>
<div class="cp_oculta" id="observaciones">
    <table width="100%" align="center">

        <?php
        //consultar observaciones realizadas en el informe
        $sqlObservacion = mysql_query("SELECT o.idfuncionario, o.observacion, o.fecha, o.hora, f.nombres, f.apellidos
FROM r_observacion_informe o
INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
WHERE o.id_informe = '$idInforme'", $cn);
        $conObservacion = mysql_num_rows($sqlObservacion);
        if ($conObservacion == 0 || $conObservacion == "") {
            echo '<tr>
		<td>No se han registrado observaciones</td>
	</tr>';
        } else {
            while ($rowObservacion = mysql_fetch_array($sqlObservacion)) {
                ?>
                <tr>
                    <td>
                        <fieldset>
                            <legend>
                                <strong> <?php echo $rowObservacion['nombres'] . ' ' . $rowObservacion['apellidos'] ?> </strong>hizo
                                la siguiente observación, las <?php echo $rowObservacion['hora'] ?>
                                del <?php echo $rowObservacion['fecha'] ?></legend>
                            <label for="area"></label>
                            <textarea name="area" id="area" cols="45" rows="5"
                                      readonly="readonly"><?php echo $rowObservacion['observacion'] ?></textarea>
                        </fieldset>
                    </td>
                </tr>
            <?php
            }
        }
        ?>
    </table>
</div>
<script src="../../bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
<script src="js/SubirResultado.js"></script>
<script>
    (function ($) {
        $.widget("custom.combobox", {
            _create: function () {
                this.wrapper = $("<span>")
                    .addClass("custom-combobox")
                    .insertAfter(this.element);

                this.element.hide();
                this._createAutocomplete();
                this._createShowAllButton();
            },

            _createAutocomplete: function () {
                var selected = this.element.children(":selected"),
                    value = selected.val() ? selected.text() : "";

                this.input = $("<input>")
                    .appendTo(this.wrapper)
                    .val(value)
                    .attr("title", "")
                    .addClass("custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left")
                    .autocomplete({
                        delay: 0,
                        minLength: 0,
                        source: $.proxy(this, "_source")
                    })
                    .tooltip({
                        tooltipClass: "ui-state-highlight"
                    });

                this._on(this.input, {
                    autocompleteselect: function (event, ui) {
                        ui.item.option.selected = true;
                        this._trigger("select", event, {
                            item: ui.item.option
                        });
                    },

                    autocompletechange: "_removeIfInvalid"
                });
            },

            _createShowAllButton: function () {
                var input = this.input,
                    wasOpen = false;

                $("<a>")
                    .attr("tabIndex", -1)
                    .attr("title", "Show All Items")
                    .tooltip()
                    .appendTo(this.wrapper)
                    .button({
                        icons: {
                            primary: "ui-icon-triangle-1-s"
                        },
                        text: false
                    })
                    .removeClass("ui-corner-all")
                    .addClass("custom-combobox-toggle ui-corner-right")
                    .mousedown(function () {
                        wasOpen = input.autocomplete("widget").is(":visible");
                    })
                    .click(function () {
                        input.focus();

                        // Close if already visible
                        if (wasOpen) {
                            return;
                        }

                        // Pass empty string as value to search for, displaying all results
                        input.autocomplete("search", "");
                    });
            },

            _source: function (request, response) {
                var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
                response(this.element.children("option").map(function () {
                    var text = $(this).text();
                    if (this.value && ( !request.term || matcher.test(text) ))
                        return {
                            label: text,
                            value: text,
                            option: this
                        };
                }));
            },

            _removeIfInvalid: function (event, ui) {

                // Selected an item, nothing to do
                if (ui.item) {
                    return;
                }

                // Search for a match (case-insensitive)
                var value = this.input.val(),
                    valueLowerCase = value.toLowerCase(),
                    valid = false;
                this.element.children("option").each(function () {
                    if ($(this).text().toLowerCase() === valueLowerCase) {
                        this.selected = valid = true;
                        return false;
                    }
                });

                // Found a match, nothing to do
                if (valid) {
                    return;
                }

                // Remove invalid value
                this.input
                    .val("")
                    .attr("title", value + " didn't match any item")
                    .tooltip("open");
                this.element.val("");
                this._delay(function () {
                    this.input.tooltip("close").attr("title", "");
                }, 2500);
                this.input.autocomplete("instance").term = "";
            },

            _destroy: function () {
                this.wrapper.remove();
                this.element.show();
            }
        });
    })(jQuery);

    $(function () {
        $("#selguiaecografica").combobox();
        $("#selguiatomografica").combobox();
    });
</script>
</body>

</html>