<?php

//conexion a base de datos
require_once('../../../../dbconexion/conexion.php');
//funcion para abrir conexion
$cn = Conectarse();
//declaracion de variables
   
//este es dato que guarda si tiene copago o no (id_capago)
   $ing1 = $_POST['ing1'];
   $ing2 = $_POST['ing2']; 
   $cant1 = $_POST['cant1']; 
   $cant2 = $_POST['cant2'];
   $COP = $_POST['idInforme'];
 

   if ($COP > 0) {
        mysql_query("UPDATE r_informe_facturacion SET tipocontraste1 = '$ing1', tipocontraste2 = '$ing2', cantcontraste1 ='$cant1', cantcontraste2 = '$cant2' WHERE id_informe = '$COP'", $cn) or showerror(mysql_error(), 4);
    }
     
    		   


   

?>