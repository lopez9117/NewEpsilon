<?php
	require_once('tcpdf/config/lang/eng.php');
	require_once('tcpdf/tcpdf.php');
	//DECLARACION DE VARIABLES
	$Norden = $_POST['adjunto'];
	require_once("Orden_pdf.php");
	ob_end_clean();

$perfil="";
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('http://www.prodiagnostico.com');
$pdf->SetTitle('Resultado Paciente');
$pdf->SetSubject('Resultado Paciente');
$pdf->SetKeywords('Reporte, usuario, php, mysql');
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
$pdf->SetFont('helvetica', '', 13, '', true);
// Add a page 
// This method has several options, check the source code documentation for more information.
$pdf->setPrintHeader(false); //no imprime la cabecera ni la linea 
$pdf->setPrintFooter(true); // imprime el pie ni la linea 
$pdf->AddPage();
//*************
  ob_end_clean();//rompimiento de pagina
//************* 
$html = createOrdenpdf();
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
$pdf->Output('PDF/'.$Norden.'.pdf', 'F');
//require_once("EnviarCorreo.php");
//F guardar
?>
<label><strong>Archivos a Subir:</strong><br/></label>
<input type="text" id="archivo" name="archivos" value="<?php echo '../Crearpdf/PDF/'.$Norden.'.pdf'; ?>" readonly/>
