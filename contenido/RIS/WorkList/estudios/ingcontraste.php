<?php
require_once("../../../../dbconexion/conexion.php");
$cn = conectarse();
include("../../select/selects.php");
$idInforme = base64_decode($_GET['idInforme']);
$idusuario = base64_decode($_GET['usuario']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Medio de contraste</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">



   

</head>


<body onLoad="">
		<div class="container">
		<form action="insertarcontraste.php" method="POST">
			<div class="col-xs-6">
	
	         <td><label for="Cantidad de contraste 1">Tipo de contraste 1</label>
                <select name="ing1" id="ing1" class="form-control" >
                    <option value="0">.: Seleccione :.</option>
                    <option value="1">.: Optiray :.</option>
                    <option value="2">.: Gadovist :.</option>
                    <option value="3">.: Md76 :.</option>
                    <option value="4">.: Conray :.</option>
                    <option value="5">.: Ultravist :.</option>
                    <option value="6">.: Bario :.</option>
                   
                </select>               
              </td>
				</br>
              <td>
              <label for="Cantidad de contraste 1">Tipo de contraste 2</label>
                <select name="ing2" id="ing2" class="form-control" >
                    <option value="0">.: Seleccione :.</option>
                    <option value="1">.: Optiray :.</option>
                    <option value="2">.: Gadovist :.</option>
                    <option value="3">.: Md76 :.</option>
                    <option value="4">.: Conray :.</option>
                    <option value="5">.: Ultravist :.</option>
                    <option value="6">.: Bario :.</option>
                   
                </select> 
             </div>

             <div class="col-xs-6">					  
					<td> 
					  <div class="form-group">
					    <label for="Cantidad de contraste 1">Cantidad de contraste 1</label>
					    <input type="text" class="form-control" id="cant1" name="cant1" placeholder="contrate 1">
					  </div>
					</td>

					<td> 
					  <div class="form-group">
					    <label for="Cantidad de contraste 1">Cantidad de contraste 2</label>
					    <input type="text" class="form-control" id="cant2" name="cant2"  placeholder="Contraste 2">
					  </div>
					</td>  

               <TD><input type="hidden" name="idInforme" value= <?php echo $idInforme;?>></TD>					  					 

             </div>
           <input type="submit"  class="btn btn-success" value="Guardar">
		</form>
		</div>

<?php
	echo($idInforme);
?>
	
</body>
</html>