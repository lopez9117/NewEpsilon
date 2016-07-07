<?php
class Estudios
{
    public function buscarEstudios($nombreEstudio,$servicio){
        $datos = array();
		$sql ="SELECT * FROM r_estudio WHERE nom_estudio LIKE '%$nombreEstudio%' AND idestado = '1' AND idservicio='$servicio' OR cups_iss LIKE '%$nombreEstudio%' AND idestado = '1' AND idservicio='$servicio'";
        $resultado = mysql_query($sql);
        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC))
		{
							$datos[] = array("value" => $row['cups_iss'].' - ' .
								trim($row['nom_estudio'])
                            );
        }
		return $datos;
    }
}