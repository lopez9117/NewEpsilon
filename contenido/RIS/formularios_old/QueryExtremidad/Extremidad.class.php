<?php
class Extremidad
{
    public function buscarExtremidad($nombreExtremidad){
        $datos = array();

		$sql = "SELECT desc_extremidad FROM r_descextremidad WHERE desc_extremidad LIKE '%$nombreExtremidad%'";
        $resultado = mysql_query($sql);

        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)){
            $datos[] = array("value" => $row['desc_extremidad'],
                             "descripcionExtre" => $row['descripcionExtre'],
                            );
        }
        return $datos;
    }
}