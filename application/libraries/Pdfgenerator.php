<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('DOMPDF_ENABLE_AUTOLOAD', TRUE);
require_once(FCPATH."vendor/autoload.php");
use Dompdf\Dompdf;

class Pdfgenerator {

  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $dompdf = new Dompdf\DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }
    // Generate Order
  public function generate_order($order_id, $html, $filename='', $stream=FALSE, $paper = 'A4', $orientation = "portrait")
  {

    $filename = (!empty($filename)?$filename:$order_id.'.pdf');

    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->set_paper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename, array("Attachment" => 0));
    } else {
        $output = $dompdf->output();
        file_put_contents('my-assets/pdf/'.$filename, $output);
        $file_path = 'my-assets/pdf/'.$filename;
        return $file_path;
    }
  }


}
