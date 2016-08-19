<?php
include("../select/select.php");
?>
<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <title>Prodiagnostico S.A</title>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script src="../../js/jquery-1.7.1.js"></script>
    <script src="../../js/ui/jquery.ui.core.js"></script>
    <script src="../../js/ui/jquery.ui.widget.js"></script>
    <script src="../../js/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
    <link href="../../js/themes/cupertino/jquery.ui.all.css" rel="stylesheet" type="text/css">
    <link href="../../js/lib/base.css" rel="stylesheet" type="text/css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../RIS/bootstrap-3.3.2-dist/css/bootstrap.min.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="../RIS/bootstrap-3.3.2-dist/css/bootstrap-theme.min.css">
    <script>
        function VerFacturacion() {
            var FechaDesde, FechaHasta, erp;
            FechaDesde = document.Facturacion.FechaDesde.value;
            FechaHasta = document.Facturacion.FechaHasta.value;
            erp = document.Facturacion.erp.value;
            if (FechaDesde == "" || FechaHasta == "" || erp == "") {
                if (FechaDesde == "") {
//                    alert("Fecha Desde es un campo olbigatorio");
                    $('#alertdesde').show();
                    $('#FechaDesde').focus();
                } else if (FechaHasta == "") {
                    alert("Fecha Hasta es un campo olbigatorio");
                    $('#FechaHesde').focus();
                } else if (erp == "") {
                    alert("Entidad Responsable de Pago es un campo olbigatorio");
                    $('#erp').focus();
                }
            }
            else {
                $(document).ready(function () {
                    verlistado()
                    //CARGAMOS EL ARCHIVO QUE NOS LISTA LOS REGISTROS, CUANDO EL DOCUMENTO ESTA LISTO
                })
                function verlistado() { //FUNCION PARA MOSTRAR EL LISTADO EN EL INDEX POR JQUERY
                    var randomnumber = Math.random() * 11;
                    $.post("ValidateFacturacionSedes.php?FechaDesde=" + FechaDesde + "&FechaHasta=" + FechaHasta + "&erp=" + erp + "",
                        {randomnumber: randomnumber},
                        function (data) {
                            $("#contenido").html(data);
                        });
                }
            }
        }
    </script>
    <link type="text/css" href="../../css/demo_table.css" rel="stylesheet"/>
    <link href="../../css/default.css" rel="stylesheet" type="text/css">
    <link href="../../css/forms.css" rel="stylesheet" type="text/css">

    <script>
        $(function () {
            $("#FechaDesde").datepicker({
                onClose: function (selectedDate) {
                    $("#FechaHasta").datepicker("option", "minDate", selectedDate);
                    $("#FechaHasta").focus();
                }
            });
            $("#FechaHasta").datepicker({
                onClose: function (selectedDate) {
                    $("#FechaDesde").datepicker("option", "maxDate", selectedDate);
                }
            });
        });
    </script>

</head>
<body>
<form name="Facturacion" id="Facturacion" method="post" action="#">

    <div class="marco container-fluid">
        <div class="ruta">
    			<span class="class_cargo" style="font-size:14px"><span class="class_cargo" style="font-size:14px">
					<a href="../../includes/main_menu.php">MEN&Uacute; PRINCIPAL</a></span> &gt; <a
                        href="main_menu_reportes.php">Reportes</a>
				</span>
   				<span class="class_cargo" style="font-size:14px">&gt; Facturaci&oacute;n Sede
				</span>
        </div>
        <div class="row">

            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="FechaDesde">Desde:</label>

                    <div class='input-group date' id='datetimepicker9'>
                        <input name="FechaDesde" class="form-control" type="text" id="FechaDesde" required readonly>
                              <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                    </div>
                </div>
            </div>


            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="FechaHasta">Hasta:</label>

                    <div class='input-group date' id='datetimepicker9'>
                        <input name="FechaHasta" class="form-control" type="text" id="FechaHasta" required readonly>
                              <span class="input-group-addon">
                                      <span class="glyphicon glyphicon-calendar"></span>
                              </span>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="erp">ERP:</label>
                    <select name="erp" class="form-control" id="erp" required>
                        <option value="">.: Seleccione :.</option>
                        <?php
                        while ($rowSede = mysql_fetch_array($ListaErp)) {
                            echo '<option value="' . $rowSede['erp'] . '">' . $rowSede['desc_erp'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="col-xs-6 col-sm-6 col-md-12">
                <div class="form-group" align="center">
                    <button type="button" value="Consultar" onclick="VerFacturacion()" class="btn btn-primary">
                        Consultar
                    </button>
                </div>
            </div>
        </div>


        <div id="contenido"></div>


    </div>

</form>
<!-- Latest compiled and minified JavaScript -->
<script src="../RIS/bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>