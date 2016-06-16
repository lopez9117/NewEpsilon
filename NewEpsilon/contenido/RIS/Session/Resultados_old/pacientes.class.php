<?php
class Pacientes
{
    public function  __construct() {
       $dbhost = 'localhost';
        $dbuser = 'root';
        $dbpass = 'root';
        $dbname = 'epsilon';

        mysql_connect($dbhost, $dbuser, $dbpass);

        mysql_select_db($dbname);
    }

    public function buscarPacientes($nombreUsuario){
        $datos = array();

		$sql = "SELECT id_paciente, CONCAT(nom1,' ',nom2,' ',ape1,' ',ape2) AS paciente FROM r_paciente
				WHERE CONCAT(nom1,' ',nom2,' ',ape1,' ',ape2) LIKE '%$nombreUsuario%'
				OR id_paciente LIKE '%$nombreUsuario%' LIMIT 10";

        $resultado = mysql_query($sql);

        while ($row = mysql_fetch_array($resultado, MYSQL_ASSOC)){
            $datos[] = array("value" => $row['id_paciente'] . ' - ' .
										$row['paciente'],
                             "descripcion" => $row['descripcion_usuarios'],
                            );
        }

        return $datos;
    }
}