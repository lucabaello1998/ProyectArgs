<?php
require '../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;


	ob_start();
	require_once 'preview_pdf.php';
	$html = ob_get_clean();

if (isset($_POST['crear'])) {
  $tecnico = $_POST['tecnico'];

$html2pdf = new Html2pdf('P', 'A4', 'es', 'true', 'UTF-8');
$html2pdf->writeHTML($html);
$html2pdf->output( $tecnico .'.pdf');

}
?>