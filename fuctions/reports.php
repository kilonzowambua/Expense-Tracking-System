<?php
// Load library
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['download_report'])) {
    #Declare Vairable
    $expense_user_id = mysqli_real_escape_string($mysqli, $_POST['expense_user_id']);
    $category_name = mysqli_real_escape_string($mysqli, $_POST['category_name']);
    $category_status = mysqli_real_escape_string($mysqli, $_POST['category_status']);
    $form_type = mysqli_real_escape_string($mysqli, $_POST['form_type']);
    $start = mysqli_real_escape_string($mysqli, $_POST['start']);
    $end = mysqli_real_escape_string($mysqli, $_POST['end']);

    if ($form_type == 'excel' && $category_status == 'all' && $category_name == 'all') {
        // Create spreadsheet object
        $file='../Storage/template.xlsx';
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(date('d_m_Y'), true);
        // Add header row
                $sheet->setCellValue('A1', 'Expense Name');
                $sheet->setCellValue('B1', 'Expense Type');
                $sheet->setCellValue('C1', 'Expense Date');
                $sheet->setCellValue('D1', 'Expense Budget');
                $sheet->setCellValue('E1', 'Expense cost');
        
        $user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id  ORDER BY ex.expense_date DESC");
        if (mysqli_num_rows($user_sql) > 0) {
            $row = 2;
            $total = 0;
            while ($data = mysqli_fetch_array($user_sql)) {
                $sheet->setCellValue('A' . $row, $data['category_name']);
                        $sheet->setCellValue('B' . $row, $data['category_status']);
                        $sheet->setCellValue('C' . $row, $data['expense_date']);
                        $sheet->getStyle('D'.$row)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_kSH);
                        $sheet->setCellValue('D' . $row, $data['category_init_expense']);
                        $sheet->getStyle('E'.$row)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_kSH);
                        $sheet->setCellValue('E' . $row, $data['expense_cost']);
                $total = $total+$data['expense_cost'];
                $row++;
            }
            //here your $i val already incremented in foreach() loop
        $sheet->setCellValue('D'.$row , "Total");
        $sheet->getStyle('E'.$row)
              ->getNumberFormat()
              ->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_kSH);
        $sheet->setCellValue('E'.$row , $total);
        }
        $file_name='Expense_from'.$start.'_to_'.$end.'.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename='.$file_name.'');
        header('Cache-Control: max-age=0');
        
        $xlsxWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $xlsxWriter = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        exit($xlsxWriter->save('php://output'));
    }}