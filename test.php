<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add some data to the worksheet
$sheet->setCellValue('A1', 'Hello World');

// Save the Spreadsheet as an XLSX file
$writer = new Xlsx($spreadsheet);
$xlsx_file = 'hello_world.xlsx';
$writer->save($xlsx_file);

// Load the XLSX file into DOMPDF
$dompdf = new Dompdf();
$dompdf->load_html(file_get_contents($xlsx_file));
$dompdf->render();

// Output the PDF to the browser
header('Content-Type: application/pdf');
echo $dompdf->output();
