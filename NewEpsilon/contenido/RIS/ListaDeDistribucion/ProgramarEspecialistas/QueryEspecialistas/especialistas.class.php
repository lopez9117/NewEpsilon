<?php
class Usuarios
{
    public function buscarUsuario($nombreUsuario){
        $datos = array();

		$sql = "SELECT esp.idfuncionario_esp, CONCAT(f.nombres,' ', f.apellidos) AS nombre_completo FROM r_especialista esp
INNER JOIN funcionario f ON f.idfuncionario = esp.idfuncionario_esp
WHERE CONCAT(f.nombres,' ', f.apellidos) LIKE '%$nombreUsuario%' OR esp.idfuncionario_esp LIKE '%$nombreUsuario%' LIMIT 10";

        $resultado = mysql_query($sql);

        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)){
            $datos[] = array("value" => $row['idfuncionario_esp'] . ' - ' .
										$row['nombre_completo'],
                             "descripcion" => $row['descripcion_usuarios'],
                            );
        }

        return $datos;
    }
}