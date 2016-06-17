<?php
//Conexion a la base de datos
include('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//variables con GET
$fecha = $_GET['fecha'];
$funcionario = $_GET['funcionario'];
if ($fecha != "") {
    //desglosar fecha para obtener rango
    list($anio, $mes, $dia) = explode("-", $fecha);
    //construir rango de fechas
    $desde = $anio . '-' . $mes . '-' . "01";
    $hasta = $anio . '-' . $mes . '-' . "31";
    //consultar disponibilidades
    $consulta = mysql_query("SELECT fecha FROM ct_disponibilidad_funcionario WHERE idfuncionario = '$funcionario' AND fecha BETWEEN '$desde' AND '$hasta' ORDER BY fecha ASC", $cn);
    $contador = mysql_num_rows($consulta);

    if ($contador = "" || $contador == 0) {
        echo '<table width="100%" border="0" class="table">
			  <tr class="tr">
				<td colspan="2" align="center" class="td">No se han registrado disponibilidades</td>
			  </tr>
			  </table>';
    } else {
        ?>
        <table width="100%" border="1" rules="all" class="table">
            <tr class="tr">
                <td class="td" width="50%" align="center"><strong>Fecha</strong></td>
                <td class="td" width="50%" align="center"><strong>Tareas</strong></td>
            </tr>
            <?php
            while ($row = mysql_fetch_array($consulta))
            {
                $fechaDisponibilidad = $row['fecha'];

                echo
                    '<tr class="tr">
						<td class="td" align="center">' . $fechaDisponibilidad . '</td>
						<td class="td" align="center"><a href="#" onClick="EliminarDisponibilidad(' . $funcionario . ',\''.$fechaDisponibilidad.'\' )"><img src="../../../images/button_cancel.png" width="16" height="16" alt="Eliminar" title="Eliminar"></a></td>
					</tr>';
            }
            ?>
        </table>
        <?php
    }
}
?>	