<?php 

	require_once 'dompdf/autoload.inc.php';
	use Dompdf\Dompdf;

	$dompdf = new Dompdf();
	$html = file_get_contents("http://localhost/crearPDF/D/dom.php");


	$options = $dompdf->getOptions();
	$options->set(array('isRemoteEnabled' => true));

	$dompdf->setOptions($options);

	$dompdf->loadHTML($html);

	$dompdf->setPaper('legal', 'landscape');

	$dompdf->render();

	$dompdf->stream("archivo_.pdf", array("Attachment" => false));
	
?>