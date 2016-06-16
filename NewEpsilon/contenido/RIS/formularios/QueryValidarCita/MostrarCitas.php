<?php
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
$idpaciente = $_POST['idpaciente'];
$fecha = $_POST['fecha'];
list ($dia,$mes,$ano) = explode('/',$fecha);
$fechaEstudio = $ano.'-'.$mes.'-'.$dia;
$sqlValCitas = mysql_query("SELECT i.id_informe, l.hora, l.fecha, i.id_paciente, i.id_estadoinforme, CONCAT(p.nom1,' ',p.nom2,'
',p.ape1,' ',p.ape2) AS nombre, es.nom_estudio, se.descsede, t.desc_tecnica FROM r_log_informe l
INNER JOIN r_informe_header i ON i.id_informe = l.id_informe
INNER JOIN r_paciente p ON p.id_paciente = i.id_paciente
INNER JOIN r_estudio es ON es.idestudio = i.idestudio
INNER JOIN sede se ON i.idsede = se.idsede
INNER JOIN r_tecnica t ON i.id_tecnica = t.id_tecnica
WHERE l.fecha = '$fechaEstudio' AND l.id_estadoinforme = '1' AND p.id_paciente='$idpaciente' GROUP BY i.id_informe",$cn);
$contadorValCitas=mysql_num_rows($sqlValCitas);
	if ($contadorValCitas>=1)
	{
		?>
		<table border="1">
          <tr>
                    <td><strong>Cedula</strong></td>
                    <td><strong>Nombre</strong></td>
                    <td><strong>Sede</strong></td>
                    <td><strong>Estudio</strong></td>
			  		<td><strong>Tecnica</strong></td>
                    <td><strong>Fecha y Hora</strong></td>
          </tr>
		<?php
		while ($MostrarEstudio = mysql_fetch_array($sqlValCitas))
			{
				
				echo '<tr>';
				echo'<td>'.$idpaciente.'</td>
				<td>'.$MostrarEstudio['nombre'].'</td>
				<td>'.$MostrarEstudio['descsede'].'</td>
				<td>'.$MostrarEstudio['nom_estudio'].'</td>
				<td>'.$MostrarEstudio['desc_tecnica'].'</td>
				<td>'.$MostrarEstudio['fecha'].'<br/>'.$MostrarEstudio['hora'].'</td>';
				echo '</tr>';
			}
echo '</table>'; 
	}
?>