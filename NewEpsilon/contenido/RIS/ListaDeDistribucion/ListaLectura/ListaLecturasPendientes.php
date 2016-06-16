<?php
include("../../select/selects.php");
$Anio=date("Y");
$Mes=date("m");
$dias = date('t', mktime(0,0,0, $Mes, 1, $Anio));
$fecha_inicio=($Anio.'-'.$Mes.'-'.'01');
$fecha_limite=($Anio.'-'.$Mes.'-'.$dias);
list($AÑO,$MES,$DIA)=explode("-",$fecha_inicio);
$DESDE= $MES."/".$DIA."/".$AÑO;
list($AÑO,$MES,$DIA)=explode("-",$fecha_limite);
$HASTA= $MES."/".$DIA."/".$AÑO;
//declarar variables por GET
$sede = $_GET['sede']; 
$servicio = $_GET['servicio'];
$especialista = $_GET['especialista'];
//consultar especialistas activos
$sqlEspecialista = mysql_query("SELECT idfuncionario, CONCAT(nombres,' ',apellidos) AS especialista FROM funcionario
WHERE idgrupo_empleado = '4' AND idestado_actividad = '1' ORDER BY especialista ASC", $cn);
?>
<script type="text/javascript" language="javascript" src="../../javascript/jquery.dataTables.js"></script>
<link type="text/css" href="../../styles/demo_table.css" rel="stylesheet" />
<script>
function CargarEstudiosPendientes()
{
	var fechaDesde,fechaHasta, sede, servicio, usuario, especialista;
	fechaDesde = document.VerAgenda.fechaDesde.value;
	fechaHasta = document.VerAgenda.fechaHasta.value;
	sede = document.VerAgenda.sede.value;
	servicio = document.VerAgenda.servicio.value;
	usuario = document.VerAgenda.usuario.value;
	especialista = document.VerAgenda.especialista.value;
	
	if(fechaDesde=="" || fechaHasta=="" || sede=="" || servicio=="" || especialista=="")
	{
		mensaje = "<font color='#FF0000'>Los campos marcados con * son obligatorios</font>";
		document.getElementById('contenido').innerHTML = mensaje;
	}
	else
	{	
		document.getElementById('contenido').innerHTML = "";
		$(document).ready(function(){
		verlistado()
			//CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
	})
		function verlistado(){ //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
			var randomnumber=Math.random()*11;
			$.post("ListaPendientesPorLectura.php?fechaHasta="+fechaHasta+"&fechaDesde="+fechaDesde+"&sede="+sede+"&servicio="+servicio+"&usuario="+usuario+"&especialista="+especialista+"", {
				randomnumber:randomnumber
			}, function(data){
			  $("#contenido").html(data);
			});
		}
	}
}

/*function AsignarEstudio(especialista, informe)
{
	var mensaje, especialista, informe;
	mensaje = confirm("Desea asignar este estudio al especialista");
	if(mensaje==true)
	{
		nombre = document.getElementById('nombre');
		ajax=nuevoAjax();
		//llamado al archivo que va a ejecutar la consulta ajax
		ajax.open("POST", "Querys/AccionAsignarInforme.php",true);
		ajax.onreadystatechange = function() 
		{
			if (ajax.readyState==4) 
			{
				nombre.innerHTML = ajax.responseText;
			}
		}
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("especialista="+especialista+"&informe="+informe+"&tiempo=" + new Date().getTime());	
		
		return CargarEstudiosPendientes();
		return  MostrarAsignados();
	}
	else
	{
		document.getElementById(informe).checked = false;
	}	
}*/
</script>
<body onFocus="CargarAgenda()">
<form name="VerAgenda" id="VerAgenda" method="post">
  <table width="100%">
    <tr bgcolor="#E1DFE3">
      <td width="15%"><strong>Desde</strong></td>
      <td width="15%"><strong>Hasta</strong></td>
      <td width="22%"><strong>Sede</strong></td>
      <td width="22%"><strong>Servicio</strong></td>
      <td width="">
        <strong>Especialista</strong>
        <input type="hidden" name="usuario" id="usuario" value="<?php echo $usuario ?>">
      </td>
    </tr>
    <tr>
      <td><input type="text" id="datepicker2" name="fechaDesde" class="texto" value="<?php
echo $DESDE;
?>" onChange="CargarEstudiosPendientes()" readonly /><span class="asterisk">*</span></td>
      <td><label for="fecha"></label>
      <input type="text" id="datepicker" name="fechaHasta" class="texto" value="<?php
echo $HASTA;
?>" onChange="CargarEstudiosPendientes()" readonly /><span class="asterisk">*</span></td>
      <td><label for="sede"></label>
        <select name="sede" id="sede" class="select" onChange="CargarEstudiosPendientes()">
        <option value="">.: Seleccione :.</option>
        <?php 
	  	while($rowSede = mysql_fetch_array($listaSede))
		{?>
			<option value="<?php echo $rowSede['idsede']?>"
            <?php if($rowSede['idsede'] == $sede)
			{
				echo 'selected';
			}?>><?php echo $rowSede['descsede']?></option>
		<?php
        }
	  ?>
      </select><span class="asterisk">*</span></td>
      <td><label for="servicio"></label>
        <select name="servicio" id="servicio" class="select" onChange="CargarEstudiosPendientes()">
        <option value="">.: Seleccione :.</option>
        <?php
        	while($regListaServicio = mysql_fetch_array($listaServicio))
			{?>
			<option value="<?php echo $regListaServicio['idservicio']?>"
            <?php if($regListaServicio['idservicio'] == $servicio)
			{
				echo 'selected';
			}?>><?php echo $regListaServicio['descservicio'] ?></option>
		<?php
        }
	  ?>
      </select><span class="asterisk">*
      
      </span></td>
      <td>
      <select name="especialista" id="especialista" onChange="CargarEstudiosPendientes()">
        <option value="">.:Seleccione :.</option>
        <?php
        	//imprimir nombres de especialista
			while($rowEspecialista = mysql_fetch_array($sqlEspecialista))
			{?>
			<option value="<?php echo $rowEspecialista['idfuncionario']?>"
            <?php if($rowEspecialista['idfuncionario'] == $especialista)
			{
				echo 'selected';
			}?>><?php echo $rowEspecialista['especialista'] ?></option>
		<?php
        }
	  ?>
      </select>
        <span class="asterisk">*</span></td>
    </tr>
  </table>
  <table width="100%">
<tr>
<td><div id="contenido"></div></td>
</tr>
</table>
<div id="nombre"></div>
</form>