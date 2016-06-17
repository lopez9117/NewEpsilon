<?php
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
include('consulta2.php');
$id = $_GET[id];
$desc_area = $_GET['area'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<title>.: Ver detalles de la Solucitud :.</title>
<style type="text/css">
fieldset
{width:98%;
border-color:#FFF;}
textarea
	{
		font-family:Arial, Helvetica, sans-serif;
		font-size:12px;
		width:100%;
		height:70px;
		resize:none;
		background-color:#FFF;
		}
.texto {
	height: 100px;
	width: 100%;
	padding:4px;
	background:#fff;
	overflow-y: scroll;
}
</style>
<script type="text/javascript" src="../../../js/ajax.js"></script>
<script type="text/javascript" src="../../../js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../../../js/jquery.js"></script></script>
<link href="../styles/Style.css" rel="stylesheet" type="text/css">
<script src="../bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
<script type="text/javascript">
CKEDITOR.config.height = 130
</script> 
<script language='javascript'>
function presupuestado(idsolicitud)
{
	estado = document.presupuesto.presu.value;
	ajax=nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
	ajax.open("POST","../update/presupuestado.php",true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("idsolicitud="+idsolicitud+"&estado="+estado+"&tiempo=" + new Date().getTime());
	return window.opener.CargarCompra();
	return window.opener.cargardiv2();
}
</script>
<script language="javascript">
	function enviarObservacion()
	{
		//declarar variables
		usuario = document.observacion.usuario.value;
		informe = document.observacion.informe.value;
		observacion = document.observacion.observacion.value;
		//validar campos obligatorios
		if(observacion=="")
		{
			mensaje = "<font color='#FF0000'><strong>Por favor escriba su comentario.</strong></font>";
			document.getElementById('respuesta').innerHTML = mensaje;			
		}
		else
		{
			mensaje = "";
			document.getElementById('respuesta').innerHTML = mensaje;
			
			document.observacion.submit();
		}
	}
</script>
</head>
<body>
<fieldset>
<legend><h4 align="center"><strong>Detalle de Solicitud</strong></h4></legend>
<div class="row">
        <div class="col-lg-3 col-sm-12 col-xs-12">
            <div class="form-group">
<label for="solicitante"><strong>Solicitante:</strong></label>
     <input type="text" class="form-control" readonly="readonly" id="solicitante" value="<?php echo $reg['nombres'].$reg['apellidos'] ?>" />      
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
            
            <label for="asunto"><strong>Asunto:</strong></label>
      <input type="text" class="form-control" id="asunto" readonly="readonly" value="<?php echo utf8_decode($reg['asunto']); ?>" />
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
      <label for="sede"><strong>Sede:</strong></label>
      <input type="text" class="form-control" value="<?php echo $reg['descsede']; ?>" id="sede" readonly="readonly" />
        </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
      <label for="area"><strong>Area a quien solicita:</strong></label>
      <input type="text" value="<?php echo $reg['desc_area'] ?>" class="form-control" id="area" readonly="readonly" />
      </div>
        </div>
        </div>
        <div class="row">
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
      <label for="fechasolic"><strong>Fecha y hora de solicitud:</strong></label>
      <input type="text" value="<?php echo $reg['fechahora_solicitud']; ?> / <?php echo $reg['horasolicitud']; ?>" class="form-control" id="fechasolic" readonly="readonly" />
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
      <label for="fechavisita"><strong>Fecha y hora de visita:</strong></label>
      <input type="text" value="<?php echo $reg['fechahora_visita']; ?> / <?php echo $reg['horavisita']; ?>" id="fechavisita" readonly="readonly" class="form-control" />
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
      <label for="prioridad"><strong>Prioridad:</strong></label>
      <input type="text" class="form-control" value="<?php echo $reg['desc_prioridad']; ?>" id="prioridad" readonly="readonly" />
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
      <label for="estado"><strong>Estado de la solicitud:</strong></label>
      <input type="text" value="<?php echo $reg['descestado_solicitud']; ?>" class="form-control" id="estado" readonly="readonly" />
      </div>
        </div>
        </div>
      <label ><strong>Solicitud:</strong></label>
      <div id="global">
  <div id="mensajes">
  <div class="texto"><?php echo utf8_decode($reg['desc_requerimiento']); ?>
  </div>
  </div>
</div>
    <form id="presupuesto" name="presupuesto" method="post" action="#">
    <label for="presu"><strong>Presupuesto</strong></label>
    <div class="row">
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
    <?php
	   if ($area==7)
	   {
		   ?>
		   <select name="presu" class="form-control" id="presu" onchange="presupuestado(<?php echo $id ?>)">
            <option value="">.:Seleccione:.</option>
             <?php
					while($rowpresupuesto = mysql_fetch_array($Listapresupuesto))
					{
						?>
					<option value="<?php echo $rowpresupuesto[id_presupuesto]?>"
						<?php
                    if ($rowpresupuesto[id_presupuesto]==$regpresupuesto[id_presupuesto])
						{
						?>
                        selected="selected"
                        <?php
						}
						?>
						>
                      <?php echo $rowpresupuesto[desc_presupuesto]?></option>
				<?php
					}
					?>
					 </select>
                      </div>
        </div>
        </div>
                     <?php
	   }
	   else
	   {
		   echo '<input type="text" class="form-control" id="presu" readonly="readonly" value="'.$regpresupuesto['desc_presupuesto'].'" /> ';
		}
          ?>
          </div></div></div>
    </form>
</fieldset>


<!--   -------------------------------------------------------------  -->
<fieldset>
<label><strong>Comentarios:</strong></label><br />
<?php
$sql = mysql_query("SELECT o.idfuncionario, o.observacion, f.nombres, f.apellidos,o.fecha,o.hora
FROM observaciones o
INNER JOIN funcionario f ON f.idfuncionario = o.idfuncionario
WHERE o.idsolicitud = '$id'", $cn);
$con = mysql_num_rows($sql);
if($con == "" || $con==0)
{
	echo 'No se han registrado comentarios';
}
else
{
   	while($rowObservacion = mysql_fetch_array($sql))
	{
$fecha=$rowObservacion['fecha'];
list($Año,$Mes,$Dia)=explode("-",$fecha);
		?>
        <div class="row">
        <div class="col-lg-12 col-sm-4 col-xs-12">
            <div class="form-group">
         <label for="area"><strong><?php echo utf8_decode($rowObservacion['nombres']).' '.utf8_decode($rowObservacion['apellidos']).' escrib&oacute; '.$Dia.'/'.$Mes.'/'.$Año.' a las '.$rowObservacion['hora'] ?>:</strong><br>
         </label> 
      <textarea name="area" class="form-control" id="area" cols="45" rows="5" readonly="readonly"><?php echo utf8_decode($rowObservacion['observacion']) ?></textarea></div></div></div>
        <?php
	}
}
?>
</fieldset>
<form id="observacion" name="observacion" method="post" action="AccionAddObservacion.php">
<fieldset>
<div class="row">
        <div class="col-lg-12 col-sm-4 col-xs-12">
            <div class="form-group">
<label for="observacion"><strong>Agregar comentario</strong></label>
<textarea name="observacion" id="observacion" class="form-control" cols="45" rows="5"></textarea><div id="respuesta"></div>
</div></div></div>
<button type="button" value="Enviar Comentario" onclick="enviarObservacion()" class="btn-primary btn-sm"/>Enviar</button>
<button type="button" value="Cerrar" onclick="window.close();" class="btn-danger btn-sm" />Cerrar </button> 
<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" />
<input type="hidden" name="informe" id="informe" value="<?php echo $id ?>" />
<input type="hidden" name="desc_area" id="desc_area" value="<?php echo $desc_area ?>" />
<input type="hidden" name="asunto" id="asunto" value="<?php echo $reg['asunto'] ?>" />
<input type="hidden" name="phpmailer">
</fieldset>
</form>
</body>
</html>