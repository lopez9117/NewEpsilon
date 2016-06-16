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
$sql = mysql_query("SELECT l.hora, l.id_informe, l.fecha, i.id_paciente,i.idestudio,i.id_tecnica,i.anestesia, es.nom_estudio, p.edad,p.peso, t.desc_tecnica,
i.ubicacion, CONCAT(p.nom1,' ', p.nom2,' ', p.ape1,' ', p.ape2) AS nombre, es.nom_estudio,es.cod_iss, ex.desc_extremidad, pr.desc_prioridad, t.desc_tecnica FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN r_tecnica t ON t.id_tecnica = i.id_tecnica
INNER JOIN r_extremidad ex ON ex.id_extremidad = i.id_extremidad WHERE i.id_informe = '$idInforme' group by id_informe", $cn);
$reg = mysql_fetch_array($sql);

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
    <script language="javascript">
        function tomar() {

            MAS = document.estadistica.MAS.value;
            KV = document.estadistica.KV.value;
            i_dañadas = document.estadistica.i_dañadas.value;
            r_innecesarias = document.estadistica.r_innecesarias.value;
            observacion = document.estadistica.observacion.value;
            lectura = document.estadistica.lectura.value;
            peso = document.estadistica.pesop.value;
            contrastereal = document.estadistica.contrastereal.value;
            codiss = document.estadistica.codiss.value;
            espaciosadicionales = 0;
            id_tecnica = document.estadistica.id_tecnica.value;
            servicio = document.estadistica.servicio.value;
            if (codiss == 213609) {
                espaciosadicionales = document.estadistica.adicionales.value;
            }
            if (MAS == "" || KV == ""  || lectura == "") {
                mensaje = '<font color="#FF0000">Por favor llene los datos necesarios para el registro de la realizacion del estudio</font>';
                document.getElementById('respuesta').innerHTML = mensaje;
            } else if ( contrastereal=="" || contrastereal==0 && id_tecnica == 3) { // peso == "" || peso == 0 &&
                mensaje = '<font color="#FF0000">Por favor ingrese la cantidad de contraste</font>';
                document.getElementById('respuesta').innerHTML = mensaje;s

            }
            else {
                document.getElementById('respuesta').innerHTML = "";
                document.estadistica.submit();
                return window.opener.CargarAgenda();
            }
        }
        function validatemedicogeneral(check) {
            if (check == true) {
                document.getElementById('nombremedicogeneral').disabled = false;
            } else {
                document.getElementById('nombremedicogeneral').disabled = true;
            }
        }

        function validatecontraste() {
            peso = $('#pesop').val();
            contraste = $('#contrastereal').val();
            cont = 0;
            if (peso > 0) {
                contrasteutilizar = peso * 1.5;
                if (contraste > contrasteutilizar) {
                    alert('La cantidad de contraste es muy alta, por favor explique el por que en el campo Observacion');
                    mensaje = '<font color="#FF0000">La cantidad de contraste es muy alta, por favor explique el por que en el campo Observacion</font>';
                    document.getElementById('respuesta').innerHTML = mensaje;
                }
            }
            else {
                alert('El peso del paciente debe ser mayor a 0');
                mensaje = '<font color="#FF0000">El peso del paciente debe ser mayor a 0</font>';
                document.getElementById('respuesta').innerHTML = mensaje;
                $('#pesop').focus();
            }
        }
    </script>
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
    </style>
    <link href="../../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        <!--
        .asterisk1 {
            color: #F00;
        }

        -->
    </style>
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
            <fieldset>
                <legend><strong>Información del paciente</strong></legend>
                <table width="100%" border="0" align="center">
                    <tr>
                        <td width="25%">N° de identificacion:</td>
                        <td width="33%">Nombres y Apellidos:</td>
                        <td width="25%">Edad:</td>
                        <td width="17">Peso:</td>
                    </tr>
                    <tr>
                        <td><label for="documento"></label>
                            <input type="text" name="documento" id="documento" class="textlarge"
                                   value="<?php echo $reg['id_paciente'] ?>" placeholder="Numero de documento"
                                   readonly="readonly"/></td>
                        <td><label for="paciente"></label>
                            <input type="text" name="paciente" id="paciente" class="textlarge"
                                   value="<?php echo $reg['nombre'] ?>" readonly="readonly"
                                   placeholder="Nombres y Apellidos"/></td>
                        <td><label for="ubicacion"></label>
                            <input type="text" name="ubicacion" id="ubicacion" class="textlarge"
                                   value="<?php echo $reg['edad'] ?>" placeholder="Ubicacion del paciente"
                                   readonly="readonly"/>
                            <input type="hidden" name="idInforme" id="idInforme" value="<?php echo $idInforme ?>"/></td>
                        <td>
                            <input type="text" name="pesop" id="pesop" class="textlarge"
                                   value="<?php echo $reg['peso'] ?>" placeholder="Peso del paciente"/>

                            <div id="respuestapeso"></div>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <fieldset>
                <legend><strong>Tipo realizacion de estudio</strong></legend>
                <table width="100%" border="0" align="center">
                    <tr>
                        <td width="22%">Estudio:</td>
                        <td width="24%">&nbsp;</td>
                        <td width="24%">&nbsp;</td>
                        <td width="17%" colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="5"><input name="text" type="text" class="textlarge"
                                               value="<?php echo trim($reg['nom_estudio']) ?>" readonly="readonly" /></td>
                    </tr>
                    <tr>
                        <td>Tecnica:</td>
                        <td>Extremidad:</td>
                        <td><label for="medicogeneral">Medico General:</label></td>
                        <td colspan="2"><label for="nombremedicogeneral">Nombre Medico General</label></td>
                    </tr>
                    <tr>
                        <td><input name="text" type="text" class="text" value="<?php echo $reg['desc_tecnica'] ?>"
                                   readonly="readonly"
                                   placeholder="Numero de documento"/><input type="hidden" value="<?php echo $reg['id_tecnica'] ?>" name="id_tecnica" id="id_tecnica"/></td>
                        <td><input name="text" type="text" class="text" value="<?php echo $reg['desc_extremidad'] ?>"
                                   readonly="readonly"
                                   placeholder="Numero de documento"/></td>
                        <td><input type="checkbox" id="medicogeneral" name="medicogeneral" value="1"
                                   onchange="validatemedicogeneral(this.checked)"/>
                        </td>
                        <td colspan="2"><input type="text" class="textlarge" id="nombremedicogeneral" name="nombremedicogeneral"
                                   disabled/></td>
                    </tr>
                    <tr>
                        <td>MAS</td>
                        <td>KV</td>
                        <td>Total Dosis</td>
                        <td colspan="2"><?php if ($servicio == 2) {
                                $contomografiascolumnas = mysql_query("SELECT idestudio FROM r_estudio WHERE cod_iss='213609'", $cn);
                                while ($resul = mysql_fetch_array($contomografiascolumnas)) {
                                    if ($reg['idestudio'] == $resul['idestudio']) {
                                        echo 'Espacios Adicionales';
                                    }
                                }
                                mysql_free_result($contomografiascolumnas);
                            }

                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><span id="sprytextfield1">
                      <input type="text" name="MAS" id="MAS" class="text" placeholder="MAS"/>
                      <span class="textfieldRequiredMsg"></span><span
                                    class="textfieldInvalidFormatMsg"></span></span><span
                                class="asterisk1">*</span></td>
                        <td><span id="sprytextfield2">
                      <input type="text" name="KV" id="KV" class="text" placeholder="KV"/>
                      <span class="textfieldRequiredMsg"></span><span
                                    class="textfieldInvalidFormatMsg"></span></span><span
                                class="asterisk1">*</span></td>
                        <td><input type="text" name="Dosis" id="Dosis" class="text" placeholder="Total Dosis de Radiacción"/></td>
                        <td colspan="2"><?php
                            if ($servicio == 2) {
                                $contomografiascolumnas = mysql_query("SELECT idestudio FROM r_estudio WHERE cod_iss='213609'", $cn);
                                while ($resul = mysql_fetch_array($contomografiascolumnas)) {
                                    if ($reg['idestudio'] == $resul['idestudio']) { ?>
                                        <select name="adicionales" id="adicionales"
                                                class="text">
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
                    </tr>
                    <tr>
                        <td style="display:none">N° Imagenes Dañadas:</td>
                        <td colspan="1" style="display:none">N° Radiacciones Innecesarias:</td>
                        <td><?php if ($reg['id_tecnica'] == 3 || $reg['id_tecnica'] == 6) {
                                ?>
                                Cantidad de Contraste Utilizado:
                            <?php } ?>
                        </td>
                        <td>Lectura
                        </td>
                        <?php if ($servicio==1){?><td>Lectura</td><?php }?>
                    </tr>
                    <tr>
                        <td style="display:none"><input type="text" name="i_dañadas" id="i_dañadas" class="text" value="0"
                                   placeholder="imagenes dañadas"/>
                            <span class="asterisk1">*</span></td>
                        <td colspan="1" style="display:none"><input type="text" name="r_innecesarias" id="r_innecesarias" class="text"
                                               value="0" placeholder="Radiacciones innecesarias"/>
                        <span
                            class="asterisk1">*</span>
                            </td>
                            <input type="hidden" name="usuario" id="usuario" value="<?php echo $idusuario ?>"/>
                            <input type="hidden" name="idInforme2" id="idInforme2" value="<?php echo $idInforme ?>"/>
                            <input type="hidden" name="sede" id="sede" value="<?php echo $sede ?>"/>
                            <input type="hidden" name="codiss" id="codiss" value="<?php echo $reg['cod_iss'] ?>"/>
                            <input type="hidden" name="servicio" id="servicio" value="<?php echo $servicio ?>"/>
                        <td>  <input type="text" name="contrastereal" id="contrastereal" placeholder="Ingresa la cantidad de contraste utilizado" value="0"
                                   onblur="validatecontraste()"
                                <?php if ($reg['id_tecnica'] == 3 || $reg['id_tecnica'] == 6) {
                                    
                                   echo 'style="display:block"';
                                } else {
                                    
                                    echo 'style="display:none"';
                                
                                } ?>/>

                            <div id="showmessage">
                                <div>
                        </td>
                        <?php if ($sede==1 && $reg['idestudio']==879){ }else{?><td>Si
                            <input type="radio" name="lectura" id="lectura" <?php if ($servicio != 1) echo 'checked="checked"'; ?> value="2"/><span
                                class="asterisk1">*</span></td><?php }?>
                        <?php if ($servicio==1 || ($sede==1 && $reg['idestudio']==879)){?><td width="10%">No
                            <input type="radio" name="lectura" id="lectura" value="10"/><span
                                class="asterisk1">*</span></td><?php } ?>
                    </tr>
					<tr>
					<td>
					<?php if($sede==3 && $servicio==2){
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
					<?php if($sede==3 && $servicio==2)
					{
					 echo 'style="display:block"';
					}else{
					echo 'style="display:none"';
					}?>/>
					</td>
                    <td>  <input
                                style="<?php if ($reg['anestesia'] == 1) { ?>
                                    display:block;<?php } else { ?>
                                    display:none;<?php } ?>" type="text" id="anestesiologo" name="anestesiologo"
                                placeholder="Ingrese el nombre del anestesiologo" class="textlarge" /></td>
					</tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <td colspan="3"><strong>Observaciones:</strong></td>
                    </tr>
                    <tr>
                        <td colspan="4">                          <textarea name="observacion"
                                                  placeholder="Registre aqui sus comentarios y observaciones" rows="3"
                                                  cols="60"></textarea></td>
                    </tr>  
                    <tr>
                        <td colspan="1">
                            <div id="respuesta"></div>
                        </td>
                        <td colspan="1"></td>
                        <td colspan="1" align="right"><input name="Registrar" type="button" onclick="tomar()"
                                                             value="Realizado"/></td>
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