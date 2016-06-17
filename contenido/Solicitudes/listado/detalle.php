<?php
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
include('consulta.php');
$id = $_GET['id'];
$sqlreferencia = mysql_query("SELECT * FROM equipos_biomedicos where id_referencia='$reg[id_referencia]'",$cn);
$regferencia = mysql_fetch_array($sqlreferencia);
$desc_area = $_GET['area'];
session_start();
$_SESSION['area'] = $area;
?>
<!DOCTYPE>
<html>
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
<script>
function enviarObservacion()
	{
		//declarar variables
		usuario = document.observacion.usuario.value;
		informe = document.observacion.informe.value;
		observacion = document.observacion.observacion.value;
		//validar campos obligatorios
			mensaje = "";
			document.getElementById('respuesta').innerHTML = mensaje;
			document.observacion.submit();
	}
</script>
</head>
<body>
<form id="observacion" name="observacion" method="post" action="AccionAddObservacion.php">
<fieldset>
<legend><h4 align="center"><strong>Detalle de Solicitud</strong></h4></legend>
    <div class="row">
        <div class="col-lg-3 col-sm-12 col-xs-12">
            <div class="form-group">
    <label for="solicitante"><strong>Solicitante:</strong></label>
      <input type="text" class="form-control" disabled id="solicitante" value="<?php echo $reg['nombres'].$reg['apellidos'] ?>">
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
    <label for="asunto"><strong>Asunto:</strong></label>
      <input type="text" class="form-control" disabled id="asunto" value="<?php echo utf8_decode($reg['asunto']); ?>">
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
<label for="sede"><strong>Sede:</strong></label>
     <input type="text" class="form-control" disabled id="sede"  value="<?php echo $reg['descsede']; ?>">
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
    <label for="area"><strong>Area a quien solicita:</strong></label>
      <input type="text" disabled value="<?php echo $reg['desc_area'] ?>" class="form-control" id="area">
      </div>
      </div>
      </div>
      
  <div class="row">
        <div class="col-lg-3 col-sm-12 col-xs-12">
            <div class="form-group">    
  <label for"fechasoli"><strong>Fecha y hora de solicitud:</strong></label>
      <input type="text" disabled value="<?php echo $reg['fechahora_solicitud']; ?> / <?php echo $reg['horasolicitud']; ?>" id="fechasoli" class="form-control">
      </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-xs-12">
            <div class="form-group">
    <label for="fechavisit"><strong>Fecha y hora de visita:</strong></label>
      <input type="text" readonly value="<?php echo $reg['fechahora_visita']; ?> / <?php echo $reg['horavisita']; ?>" id="fechavisit" class="form-control">
  </div>
        </div> 
  <?php
  if($area==1 || $area==2 || $area==8 || $area==9)
  {
	  ?>
   <div class="col-lg-3 col-sm-4 col-xs-12">
   <div class="form-group">  
  <label for="prioridad"><strong>Prioridad:</strong></label>
      <select name="prioridad" id="prioridad" class="form-control">
            <option value="0">.:Seleccione:.</option>           
                <?php
                while($rowPrioridad = mysql_fetch_array($ListaPrioridad))
		{?>
        <option value="<?php echo $rowPrioridad['idprioridad']?>"
            <?php if($rowPrioridad['idprioridad'] == $regprioridad['idprioridad'])
			{
				echo 'selected';
			}?>><?php echo $rowPrioridad['desc_prioridad']?></option>
        <?php
        }
	  ?>
          </select>
          </div>
          </div>
          <div class="col-lg-3 col-sm-4 col-xs-12">
   		  <div class="form-group"> 
           <label for="tipo_solicitud"><strong>Tipo Solicitud:</strong></label>
           <select name="tipo_solicitud" id="tipo_solicitud" class="form-control">
            <option value="0">.:Seleccione:.</option>
                <?php
                while($rowsolicitud = mysql_fetch_array($ListaSolicitud))
		{?>
        <option value="<?php echo $rowsolicitud['id_tiposolicitud']?>"
            <?php if($rowsolicitud['id_tiposolicitud'] == $regprioridad['id_tiposolicitud'])
			{
				echo 'selected';
			}?>><?php echo $rowsolicitud['desc_tiposolicitud']?></option>
        <?php
        }
		
	  ?>
          </select>
          </div>
          </div>
          </div>
          <div class="row">
          <div class="col-lg-6 col-sm-4 col-xs-12">
   			<div class="form-group"> 
          <label for="estado"><strong>Estado Solicitud:</strong></label>
          <select name="estado" id="estado" class="form-control">
            <option value="1">.:Seleccione:.</option>
                <?php
                while($rowsolicitud = mysql_fetch_array($ListaEstado))
		{?>
        <option value="<?php echo $rowsolicitud['idestado_solicitud']?>"
            <?php if($rowsolicitud['idestado_solicitud'] == $reg['idestado_solicitud'])
			{
				echo 'selected';
			}?>><?php echo $rowsolicitud['descestado_solicitud']?></option>
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
	  ?>
   <div class="col-lg-3 col-sm-4 col-xs-12">
   <div class="form-group">  
  <label for="prioridad"><strong>Prioridad:</strong></label>
      <input type="text" readonly value="<?php echo $reg['desc_prioridad']?>" name="prioridad" id="prioridad" class="form-control">
          </div>
          </div>
          <div class="col-lg-3 col-sm-4 col-xs-12">
   		  <div class="form-group"> 
           <label for="tipo_solicitud"><strong>Tipo Solicitud:</strong></label>
           <input readonly type="text" value="<?php echo $regprioridad['desc_tiposolicitud']?>" name="tipo_solicitud" id="tipo_solicitud" class="form-control">
          </div>
          </div>
          </div>
          <div class="row">
          <div class="col-lg-6 col-sm-4 col-xs-12">
   			<div class="form-group"> 
          <label for="estado"><strong>Estado Solicitud:</strong></label>
          <input readonly type="text" value="<?php echo $reg['descestado_solicitud']?>" name="estado" id="estado" class="form-control">
                </div>
                </div>
                </div>
  <?php
	}
  if($desc_area==2)
  {
  ?>
  <div class="row">
          <div class="col-lg-3 col-sm-4 col-xs-12">
   		  <div class="form-group"> 
  <label for="equipo"><strong>Equipo:</strong></label>
      <input type="text" value="<?php echo $regferencia['equipo']; ?>" class="form-control" id="equipo">
      </div>
          </div>
          <div class="col-lg-3 col-sm-4 col-xs-12">
   			<div class="form-group"> 
      <label for="Marca"><strong>Marca:</strong></label>
      <input type="text" value="<?php echo $regferencia['marca']; ?>" id="Marca" class="form-control">
      </div>
          </div>
          <div class="col-lg-3 col-sm-4 col-xs-12">
   			<div class="form-group"> 
            <label for="Modelo"><strong>Modelo:</strong></label>
	  <input type="text" value="<?php echo $regferencia['modelo']; ?>" id="Modelo" class="form-control">
      </div>
          </div>
          <div class="col-lg-3 col-sm-4 col-xs-12">
   			<div class="form-group"> 
            <label for="Serie"><strong>Serie</strong></label>
      <input type="text" value="<?php echo $regferencia['serie']; ?>" class="form-control" id="Serie">
      </div>
      </div>
      </div>
  <?php
  }
  ?>
  <div class="row">
          <div class="col-lg-12 col-sm-4 col-xs-12">
   		  <div class="form-group"> 
     <label for="texto"><strong>Solicitud:</strong></label>
  <div id="texto" class="texto"><?php echo utf8_decode($reg['desc_requerimiento']); ?>
</div>
</div>
</div>
</div>
</fieldset>
<!--  ----------------Comentarios--------------------------------------  -->

<fieldset>
<strong>Comentarios</strong>
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
$fecha=$rowObservacion[fecha];
list($Año,$Mes,$Dia)=explode("-",$fecha);
		?><div class="row">
          <div class="col-lg-12 col-sm-4 col-xs-12">
   		  <div class="form-group"> 
         <label for="area"><strong><?php echo utf8_decode($rowObservacion[nombres]).' '.utf8_decode($rowObservacion[apellidos]).' escrib&oacute; el dia '.$Dia.'/'.$Mes.'/'.$Año.' a las '.$rowObservacion[hora] ?>:</strong></label>
      <textarea name="area" readonly id="area" cols="45" rows="5"><?php echo utf8_decode($rowObservacion[observacion]) ?></textarea>
      </div>
	  </div>
      </div>
	  <?php
	}
}
?>
</fieldset>
<fieldset>
<label for="observacion"><strong>Agregar comentario</strong></label>
<div class="row">
          <div class="col-lg-12 col-sm-4 col-xs-12">
   		  <div class="form-group"> 
<textarea name="observacion" id="observacion" cols="45" rows="5" class="form-control"></textarea><div id="respuesta">
</div>
</div>
</div>
<div class="row">
        <div class="col-lg-6 col-sm-3 col-xs-12 form-group">
        <button type="button" value="Enviar Comentario" onClick="enviarObservacion()" class="btn-primary btn-sm">Enviar</button>
        <button type="button" value="Cerrar" onClick="window.close();" class="btn-danger btn-sm">Cerrar</button>
        </div>
        </div>
<input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>" />
<input type="hidden" name="informe" id="informe" value="<?php echo $id ?>" />
<input type="hidden" name="desc_area" id="desc_area" value="<?php echo $desc_area ?>" />
<input type="hidden" name="asunto" id="asunto" value="<?php echo $reg['asunto'] ?>" />
<input type="hidden" name="phpmailer">
</fieldset>
</form>
</body>
</html>