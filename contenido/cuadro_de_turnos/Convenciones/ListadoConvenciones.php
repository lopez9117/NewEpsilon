<?php 
//Conexion a la base de datos
include('../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//consulta
$listado =  mysql_query("SELECT c.id,  c.alias, c.hr_inicio, c.hr_fin, c.idestado_actividad FROM convencion_cuadro c
WHERE c.idgrupo_empleado = '0' ORDER BY c.idestado_actividad ASC",$cn);
?>
 <script type="text/javascript">
 $(document).ready(function(){
   $('#tabla_listado_convenciones').dataTable( { //CONVERTIMOS NUESTRO LISTADO DE LA FORMA DEL JQUERY.DATATABLES- PASAMOS EL ID DE LA TABLA
        "sPaginationType": "full_numbers" //DAMOS FORMATO A LA PAGINACION(NUMEROS)
    } );
})
 </script>
 <script src="../js/ajax.js" type="text/javascript"></script>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="tabla_listado_convenciones">
<thead>
    <tr>
        <th align="center">Alias</th>
        <th align="center">Hora de inicio</th>
        <th align="center">Hora de finalizacion</th>
        <th align="center">Estado</th>
    </tr>
</thead>
<tfoot>
    <tr>
        <th></th>
        <th></th>
       <th></th>                     
    </tr>
</tfoot>
  <tbody>
<?php
while($reg=  mysql_fetch_array($listado))
{
   echo '<tr>';
   echo '<td align="center">'.mb_convert_encoding($reg['alias'], "UTF-8").'</td>';
   echo '<td align="center">'.$reg['hr_inicio'].'</td>';
   echo '<td align="center">'.$reg['hr_fin'].'</td>';
   echo '<td align="center">';
  if($reg['idestado_actividad'] == 1)
   {
		 echo '<input type="radio" name="'.$reg['id'].'" checked onClick="ActConvencion('.$reg['id'].')">Activo';
		 echo '<input type="radio" name="'.$reg['id'].'" onClick="DesConvencion('.$reg['id'].')">Inactivo';  
	}
	elseif($reg['idestado_actividad']==2)
	{
		 echo '<input type="radio" name="'.$reg['id'].'" onClick="ActConvencion('.$reg['id'].')">Activo';
		 echo '<input type="radio" name="'.$reg['id'].'" checked onClick="DesConvencion('.$reg['id'].')">Inactivo';  
	}
   echo '</td>';
   echo '</tr>';
}
?>
<tbody>
</table>