<?php
class Adiciones
{
    public function buscarAdiciones($nombreAdicion){
        $datos = array();

		$sql = "SELECT desc_adicional FROM r_adicional WHERE desc_adicional LIKE '%$nombreAdicion%'";
        $resultado = mysql_query($sql);

        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)){
            $datos[] = array("value" => utf8_encode($row['desc_adicional']),
                             "descripcionAdicion" => $row['descripcionAdicion'],
                            );
        }
        return $datos;
    }
}