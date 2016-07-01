<?php

session_start();
	$CurrentUser = $_SESSION[currentuser] ;
	$mod = 2;
	include("../ValidarModulo.php");

define('EMAIL_FOR_REPORTS', '');
define('RECAPTCHA_PRIVATE_KEY', '@privatekey@');
define('FINISH_URI', 'http://');
define('FINISH_ACTION', 'message');
define('FINISH_MESSAGE', 'GUARDADO CON EXITO.');
define('UPLOAD_ALLOWED_FILE_TYPES', 'doc, docx, xls, csv, txt, rtf, html, zip, jpg, jpeg, png, gif');

define('_DIR_', str_replace('\\', '/', dirname(__FILE__)) . '/');
require_once _DIR_ . '/handler.php';




?>
<script>
$(function() {
	$( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>


<?php if (frmd_message()): ?>
<link rel="stylesheet" href="<?php echo dirname($form_path); ?>/formoid-solid-dark.css" type="text/css" />
<span class="alert alert-success"><?php echo FINISH_MESSAGE; ?></span>
<?php else: ?>
<!-- Start Formoid form-->
<link rel="stylesheet" href="<?php echo dirname($form_path); ?>/formoid-solid-dark.css" type="text/css" />
<script type="text/javascript" src="<?php echo dirname($form_path); ?>/jquery.min.js"></script>
<form class="formoid-solid-dark" style="background-color:#079beb;font-size:13px;font-family:'Times New Roman',Times,serif;color:#34495E;max-width:1000px;min-width:150px" action="guardar.php" method="post"><div class="title"><h2>REGISTRO DE DATELLE DE EVENTOS ADVERSOS</h2></div>
	<div class="element-input<?php frmd_add_class("NCP"); ?>"><label class="title"></label><div class="item-cont"><input class="large" type="text" name="NCP" placeholder="NUMERO TOTAL DE CAIDAS PRESENTADAS"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("NCE"); ?>"><label class="title"></label><div class="item-cont"><input class="large" type="text" name="NCE" placeholder="NÚMERO TOTAL DE CÁIDAS( EVENTO ADVERSO)"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("NCI"); ?>"><label class="title"></label><div class="item-cont"><input class="large" type="text" name="NCI" placeholder="NÚMERO TOTAL DE CÁIDAS CLASIFICADAS ( INCIDENTE)"/><span class="icon-place"></span></div></div>
	<div class="element-date<?php frmd_add_class("DATE"); ?>"><label class="title"></label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="DATE" placeholder="FECHA DEL REPORTE"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("MES"); ?>"><label class="title"></label><div class="item-cont"><input class="medium" type="text" name="MES" placeholder="MES REPORTE(EJ:ENERO:1)"/><span class="icon-place"></span></div></div>
	<div class="element-date<?php frmd_add_class("DATE1"); ?>"><label class="title"></label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="DATE1" placeholder="FECHA OCURRENCIA"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("DOC"); ?>"><label class="title"></label><div class="item-cont"><input class="medium" type="text" name="DOC" placeholder="DOCUMENTO  "/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("NOM"); ?>"><label class="title"></label><div class="item-cont"><input class="large" type="text" name="NOM" placeholder="NOMBRE"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("EPS"); ?>"><label class="title"></label><div class="item-cont"><input class="large" type="text" name="EPS" placeholder="EPS DEL PACIENTE"/><span class="icon-place"></span></div></div>
	<div class="element-select<?php frmd_add_class("select"); ?>"><label class="title"></label><div class="item-cont"><div class="large"><span><select name="select" >

		<option value="1">BARRANQUILLA</option>
		<option value="2">CLÍNICA CONQUISTADORES </option>
		<option value="3">CLÍNICA DEL NORTE</option>
		<option value="4">CLÍNICA LEÓN XIII</option>
		<option value="5">CLÍNICA LEÓN XIII SEDE PRADO</option>
		<option value="6">CÚCUTA</option>
		<option value="7">ESE MANRRIQUE</option>
		<option value="8">HMFS</option>
		<option value="9">INTEGRADOS</option>
		<option value="10">SAN ANDRES</option>
		<option value="11">SEDE CALDAS</option>
		<option value="12">SEDE ITAGUI</option>
		<option value="13">SEDE PARQUE BELLO</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea"); ?>"><label class="title"></label><div class="item-cont"><textarea class="medium" name="textarea" cols="20" rows="5" placeholder="DESCRIPCIÓN DEL CASO"></textarea><span class="icon-place"></span></div></div>
	<div class="element-select<?php frmd_add_class("select1"); ?>"><label class="title"></label><div class="item-cont"><div class="large"><span><select name="select1" >

		<option value="1">ADMINISTRACIÓN ERRÓNEA DE MEDICAMENTOS</option>
		<option value="2">AUSENCIA DE ACOMPAÑANTE</option>
		<option value="3">AYUNO PROLONGADO </option>
		<option value="4">BRONCOASPIRACION</option>
		<option value="4">CAÍDA</option>
		<option value="5">CANCELACIÓN DE ESTUDIO</option>
		<option value="6">CANCELACIÓN DEL SERVICIO,AYUNO PROLONGADO, DEMORA EN LA PRESTACION DEL SERVICIO</option>
		<option value="7">CONVULSIÓN</option>
		<option value="8">DEMORA EN LA ENTREGA DE RESULTADOS</option>
		<option value="9">DEMORAS EN LA PRESTACIÓN DEL SERVICIO</option>
		<option value="10">DESFACELACIÓN </option>
		<option value="11">ERROR DE IDENTIFICACIÓN DEL PACIENTE</option>
		<option value="12">ERROR DE TRANSCRIPCIÓN</option>
		<option value="13">ERROR EN AGENDAMIENTO</option>
		<option value="14">ERROR EN LA ENTREGA DE RESULTADOS</option>
		<option value="15">ERROR EN LA IDENTIFICACIÓN DEL ESTUDIO</option>
		<option value="16">ERROR EN LA LIBERACIÓN DEL ESTUDIO</option>
		<option value="17">ERROR EN LA MARCACION DEL ESTUDIO</option>
		<option value="18">ERROR EN LA TOMA DEL ESTUDIO</option>
		<option value="19">ESTUDIO O PROCEDIMIENTO TOMADO O REALIZADO EN PARTE EQUIVOCADA</option>
		<option value="20">EVENTO RELACIONADO CON EQUIPOS BIOMEDICOS</option>
		<option value="21">EXTRAVASACIÓN </option>
		<option value="22">FALTA DE DE PROYECCIONES REQUERIDAS</option>
		<option value="23">FLEBITIS QUÍMICA</option>
		<option value="24">HEMATOMA</option>
		<option value="25">HIPERSENSIBILIDAD</option>
		<option value="26">IMAGEN MAL MARCADA</option>
		<option value="27">IMAGEN MAL TOMADA</option>
		<option value="28">INFECCIÓN POST PROCEDIMIENTO</option>
		<option value="29">INFORMACIÓN INCORRECTA</option>
		<option value="30">IRRADIACIÓN INNECESARIA</option>
		<option value="31">LACERACIÓN</option>
		<option value="32">MAL TRATO HACIA EL  USUARIO</option>
		<option value="32">MALA PREPARACIÓN</option>
		<option value="33">MODIFICACIÓN DE DATOS EN HISTORIA CLINICA</option>
		<option value="34">MUERTE</option>
		<option value="35">MUESTRA INSUFICIENTE </option>
		<option value="36">MUESTRA MAL MARCADA </option>
		<option value="37">MUESTRAS MAL TOMADAS</option>
		<option value="38">MULTIPLES PUNCIONES</option>
		<option value="39">NEUMOTÓRAX</option>
		<option value="40">NO CONCORDANCIA</option>
		<option value="41">NO INDICADO PARA SU PATOLOGIA</option>
		<option value="42">NO SE REALIZA EL PROCEDIMIENTO SOLICITADO</option>
		<option value="43">OTRO</option>
		<option value="44">PERDIDA DE HISTORIA CLINICA</option>
		<option value="45">PERDIDA DE IMÁGENES</option>
		<option value="46">PERDIDA DE PERTENENCIAS DEL USUARIO</option>
		<option value="47">PERDIDA DE RESULTADO</option>
		<option value="48">PERDIDA DE VISIÓN</option>
		<option value="49">RESULTADO ERRÓNEO </option>
		<option value="50">SANGRADO</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-select<?php frmd_add_class("select2"); ?>"><label class="title"></label><div class="item-cont"><div class="large"><span><select name="select2" >

		<option value="1">ECOGRAFÍA</option>
		<option value="2">ESTUDIOS ESPECIALES</option>
		<option value="3">MAMOGRAFIA</option>
		<option value="4">PLETISMOGRAFÍA</option>
		<option value="5">RADIOLOGÍA INTERVENCIONISTA GUIADA POR ECOGRAFÍA</option>
		<option value="6">RADIOLOGÍA INTERVENCIONISTA GUIADA POR TOMOGRAFÍA</option>
		<option value="7">RADIOLOGÍA INTERVENCIONISTA HEMODINAMIA</option>
		<option value="8">RAYOS X</option>
		<option value="9">RESONANCIA</option>
		<option value="10">TOMOGRAFÍA</option>
		<option value="11">UNIDAD DE GASTRO</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-input<?php frmd_add_class("TEVEN"); ?>"><label class="title"></label><div class="item-cont"><input class="large" type="text" name="TEVEN" placeholder="TIPO DE EVENTO "/><span class="icon-place"></span></div></div>
	<div class="element-select<?php frmd_add_class("select3"); ?>"><label class="title"></label><div class="item-cont"><div class="large"><span><select name="select3" >

		<option value="1">COMPLICACIÓN</option>
		<option value="2">EA EVITABLE </option>
		<option value="3">EA NO EVITABLE</option>
		<option value="4">EA: DAÑO PSICOLOGICO</option>
		<option value="5">INCIDENTE </option>
		<option value="6">PENDIENTE X DEFINIR </option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea1"); ?>"><label class="title"></label><div class="item-cont"><textarea class="medium" name="textarea1" cols="20" rows="5" placeholder="RESPUESTA  DADA POR EL PERSONAL IMPLICADO"></textarea><span class="icon-place"></span></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea2"); ?>"><label class="title"></label><div class="item-cont"><textarea class="medium" name="textarea2" cols="20" rows="5" placeholder="ACCIÓN REALIZADA INMEDIATA (CORRECCÓN)"></textarea><span class="icon-place"></span></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea3"); ?>"><label class="title"></label><div class="item-cont"><textarea class="medium" name="textarea3" cols="20" rows="5" placeholder=" PLAN DE MEJORAMIENTO"></textarea><span class="icon-place"></span></div></div>
	<div class="element-date<?php frmd_add_class("DATE2"); ?>"><label class="title"></label><div class="item-cont"><input class="medium" data-format="yyyy-mm-dd" type="date" name="DATE2" placeholder="FECHA DE COMPROMISO DE LA ACCIÓN"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("RESPOACCION"); ?>"><label class="title"></label><div class="item-cont"><input class="medium" type="text" name="RESPOACCION" placeholder="RESPONSABLE DE EJECUTAR ACCIÓN TOMADA"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("IMPLIC"); ?>"><label class="title"></label><div class="item-cont"><input class="medium" type="text" name="IMPLIC" placeholder="IMPLICADOS "/><span class="icon-place"></span></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea4"); ?>"><label class="title"></label><div class="item-cont"><textarea class="medium" name="textarea4" cols="20" rows="5" placeholder="SEGUIMIENTO AL CUMPLIMIENTO"></textarea><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("REINCI"); ?>"><label class="title"></label><div class="item-cont"><input class="small" type="text" name="REINCI" placeholder="REINCIDENCIA (SI Ó NO)"/><span class="icon-place"></span></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea6"); ?>"><label class="title"></label><div class="item-cont"><textarea class="small" name="textarea6" cols="20" rows="5" placeholder="ANÁLISIS CAUSAL O FACTORES CONTRIBUYENTES"></textarea><span class="icon-place"></span></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea5"); ?>"><label class="title"></label><div class="item-cont"><textarea class="small" name="textarea5" cols="20" rows="5" placeholder="ACCIÓN INSEGURA"></textarea><span class="icon-place"></span></div></div>
	<div class="element-select<?php frmd_add_class("select4"); ?>"><label class="title"></label><div class="item-cont"><div class="large"><span><select name="select4" >
       
       <option value="1">CENTINELA</option>
		<option value="2">IMPROBABLE</option>
		<option value="3">LEVE</option>
		<option value="4">MODERADO</option>
		<option value="5">NO APLICA</option>
		<option value="6">POSIBLE</option>
		<option value="7">PROBABLE</option>
		<option value="8">SERIO</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-select<?php frmd_add_class("select5"); ?>"><label class="title"></label><div class="item-cont"><div class="large"><span><select name="select5" >

		<option value="1">CERRADA</option>
		<option value="2">PENDIENTE POR ANALISIS CAUSAL</option>
		<option value="3">PENDIENTE POR EVALUAR EN COMITÉ DE SEGURIDAD</option>
		<option value="4">PENDIENTE POR EVIDENCIA DE EFECTIVIDAD DE LA ACCIÓN TOMADA</option>
		<option value="5">PENDIENTE POR EVIDENCIA DE LA ACCIÓN TOMADA</option>
		<option value="6">PENDIENTE POR RESPUESTA DE IMPLICADO O COORDINACIÓN REPONSABLE</option></select><i></i><span class="icon-place"></span></span></div></div></div>
	<div class="element-textarea<?php frmd_add_class("textarea7"); ?>"><label class="title"></label><div class="item-cont"><textarea class="small" name="textarea7" cols="20" rows="5" placeholder="OBSERVACIONES /CONCLUSIONES"></textarea><span class="icon-place"></span></div></div>
	<div class="element-date<?php frmd_add_class("DATE3"); ?>"><label class="title"></label><div class="item-cont"><input class="small" data-format="yyyy-mm-dd" type="date" name="DATE3" placeholder="FECHA DE SEGUIMIENTO"/><span class="icon-place"></span></div></div>
	<div class="element-input<?php frmd_add_class("COSTA"); ?>"><label class="title"></label><div class="item-cont"><input class="small" type="text" name="COSTA" placeholder="COSTO ADICIONAL"/><span class="icon-place"></span></div></div>
<div class="submit"><input type="submit" value="Enviar "/></div></form><script type="text/javascript" src="<?php echo dirname($form_path); ?>/formoid-solid-dark.js"></script>

<!-- Stop Formoid form-->
<?php endif; ?>

<?php frmd_end_form(); ?>