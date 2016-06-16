<?php 
//Conexion a la base de datos
require_once('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
$paciente = $_POST['paciente'];
if($paciente=="")
{
	echo '<font color="#FF0000">Por favor ingrese un paciente</font>';
}
else
{
list($idPaciente, $nombres) = explode("-", $paciente);
//consultar la cantidad de estudios que estan agendados para la fecha especificada
$sqlagenda = mysql_query("SELECT DISTINCT(i.id_informe), i.id_paciente, p.email, concat(p.nom1,' ', p.nom2,
' ',p.ape1,' ', p.ape2) as nombre,e.nom_estudio, l.fecha, l.hora, pr.desc_prioridad, f.nombres, f.apellidos,
tec.desc_tecnica, se.descsede
FROM r_informe_header i
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio e ON e.idestudio = i.idestudio
INNER JOIN r_log_informe l ON l.id_informe = i.id_informe
INNER JOIN r_prioridad pr ON pr.id_prioridad = i.id_prioridad
INNER JOIN funcionario f ON f.idfuncionario = i.idfuncionario_esp
INNER JOIN r_tecnica tec ON tec.id_tecnica = i.id_tecnica
INNER JOIN sede se ON se.idsede = i.idsede
WHERE i.id_estadoinforme = '8' AND l.id_estadoinforme = '8' AND i.id_paciente='$idPaciente'", $cn);
?>
<script type="text/javascript">
 $(document).ready(function(){
   $('#Resultados').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})


$('a').click(function(){
var idinforme= $(this).attr('rel');
inputInforme = document.getElementById('informe');//etiqueta donde se va a mostrar la respuesta
ajax = nuevoAjax();
	//llamado al archivo que va a ejecutar la consulta ajax
ajax.open("POST", "Crearpdf/queryInforme.php",true);
ajax.onreadystatechange=function() 
	{
		if (ajax.readyState==4) 
		{
			inputInforme.innerHTML = ajax.responseText;
		}
	}
ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
ajax.send("idinforme="+idinforme+"&tiempo=" + new Date().getTime());
})
 </script>
 <table width="100%">
  <tr bgcolor="#E1DFE3">
    	<td><strong>Resultados definitivos para <?php echo $nombres ?></strong></td>
    </tr>
 </table>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="Resultados">
<thead>
    <tr>
        <th align="left" width="10%">N° Documento</th><!--Estado-->
        <th align="left" width="20%">Nombres y Apellidos</th>
        <th align="left" width="25%">Estudio</th>
        <th align="left" width="10%">Tecnica</th>
        <th align="left" width="10%">Sede</th>
         <th align="center" width="15%">Fecha del estudio</th>
        <th align="center" width="10%">Tareas</th>
    </tr>
  <tbody>
    <?php
   while($reg =  mysql_fetch_array($sqlagenda))
   {
	   //Codificar variables para pasar por URL
	   $idInforme = $reg['id_informe'];
	   //consultar fecha de realizacion del estudio
		$con = mysql_query("SELECT fecha FROM r_log_informe WHERE id_informe = '$idInforme' AND id_estadoinforme = '1'", $cn);
		$regcon = mysql_fetch_array($con);
		$fecha = $regcon['fecha'];
	   $idInforme = base64_encode ($idInforme);
	   $user = base64_encode($usuario);
	   $informe = $reg['id_informe'];  
	   $nombres = $reg['nombre'];
       echo '<tr id="'.$informe.'">';
       echo '<td align="left">'.$reg['id_paciente'].'</td>';
       echo '<td align="left">'.$nombres.'</td>';
	   echo '<td align="left">'.$reg['nom_estudio'].'</td>';
	   echo '<td align="left">'.$reg['desc_tecnica'].'</td>';
	   echo '<td align="left">'.$reg['descsede'].'</td>';
	   echo '<td align="center">'.$fecha.'</td>';
	   echo '<td align="center">';
	   ?><a href="Vistaimpresion.php?informe=<?php echo $idInforme ?>" target="Ventana" onClick="window.open(this.href, this.target, 'toolbar=no,scrollbars=no,width=800,height=700'); return false;"><img src="../../../images/fileprint.png" width="20" height="20" alt="Imprimir Informe" title="Transcribir Imprimir"></a>
       
       <a data-toggle="modal" rel="<?php echo $informe ?>" data-target="#Correo"><img
                src="../../../images/mailreminder.png" width="20" height="20" alt="Vista Previa"
                title="Enviar Correo"></a>&nbsp;&nbsp;
                 <form name="EnviarCorreo" id="EnviarCorreo" method="post" action="Crearpdf/reporte_usuarios_pdf.php"
          enctype="multipart/form-data">
       <div class="modal fade" id="Correo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="EnviarCorreo">Enviar Correo</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="recipient-name">Dirección Correo Electronico:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $reg['email']?>" required>
          </div>
          <div class="form-group">
            <label for="recipient-name">Asunto:</label>
             <input type="text" value="Resultado de" class="form-control" id="asunto" name="asunto" required>
            <input type="hidden" value="<?php echo $reg['id_paciente']?>" name="paciente" id="paciente" />
            <!--<input type="text" name="informe" id="informe" />-->
            <div id="informe"></div>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">Mensaje:</label>
            <textarea class="form-control" id="mensaje" name="mensaje">Buenos días Prodiagnóstico IPS hace el envío del resultado.
Gracias por utilizar nuestros servicios.</textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Enviar Correo</button>
      </div>
    </div>
  </div>
</div>
</form>
      
	   <?php
       echo '</td>';
       echo '</tr>';
   }
    ?>
    
<tbody>
</table>
<br>
<?php
}
mysql_close($cn);
?>