<?php
// Load library
require '../vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();

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



#This is Excel Format Only


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
        
        $user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(`expense_date`, '%Y-%m-%d') BETWEEN '{$start}'AND '{$end}' AND ex.expense_user_id ='{$expense_user_id}' ORDER BY ex.expense_date DESC");
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

 
#Category Name is All
    }elseif ($form_type == 'excel' && $category_status == 'all' && $category_name != 'all') {

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
        
        $user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm 
        ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(ex.expense_date, '%Y-%m-%d') BETWEEN '{$start}'AND '{$end}' AND ex.expense_user_id ='{$expense_user_id}' 
        AND ca.category_name ='{$category_name}' ORDER BY ex.expense_date DESC");
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


#Category status is All
    } elseif ($form_type == 'excel' && $category_status != 'all' && $category_name == 'all') {

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
       
       $user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(ex.expense_date, '%Y-%m-%d') BETWEEN '{$start}' AND '{$end}' AND ca.category_status ='{$category_status}' AND ex.expense_user_id ='{$expense_user_id}' ORDER BY ex.expense_date DESC");
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
   }

#Category status  and Category Name True
elseif ($form_type == 'excel' && $category_status != 'all' && $category_name != 'all') {

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
   
   $user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(ex.expense_date, '%Y-%m-%d') BETWEEN '{$start}' AND '{$end}' AND ca.category_name ='{$category_name}' AND ca.category_status ='{$category_status}' AND ex.expense_user_id ='{$expense_user_id}' ORDER BY ex.expense_date DESC");
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
#This is Excel Format Only






#This is Pdf
}elseif ($form_type == 'pdf' && $category_status == 'all' && $category_name == 'all') {
 #All Category name and Type
 
     $html = '
     <!DOCTYPE html>
     <html>
 
         <head>
             <meta name="" content="XYZ,0,0,1" />
             <style type="text/css">
                 table {
                     font-size: 12px;
                     padding: 4px;
                 }
 
                 tr {
                     page-break-after: always;
                 }
 
                 th {
                     text-align: left;
                     padding: 4pt;
                 }
 
                 td {
                     padding: 5pt;
                 }
 
                 #b_border {
                     border-bottom: dashed thin;
                 }
 
                 legend {
                     color: #0b77b7;
                     font-size: 1.2em;
                 }
 
                 #error_msg {
                     text-align: left;
                     font-size: 11px;
                     color: red;
                 }
 
                 .header {
                     margin-bottom: 20px;
                     width: 100%;
                     text-align: left;
                     position: absolute;
                     top: 0px;
                 }
 
                 .footer {
                     width: 100%;
                     text-align: center;
                     position: fixed;
                     bottom: 5px;
                 }
 
                 #no_border_table {
                     border: none;
                 }
 
                 #bold_row {
                     font-weight: bold;
                 }
 
                 #amount {
                     text-align: right;
                     font-weight: bold;
                 }
 
                 .pagenum:before {
                     content: counter(page);
                 }
 
                 /* Thick red border */
                 hr.red {
                     border: 1px solid red;
                 }
                 .list_header{
                     font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                 }
             </style>
         </head>
 
         <body style="margin:1px;">
             <div class="footer">
                 <hr>
                 <i>Expenses Report. Report Generated On ' . date('d M Y') . '</i>
             </div>
 
             <h3 class="list_header" align="center">
             <div class="list_header" align="center">
                 
                 <br>
                 <h3>
                    Expense Tracking Management 
                 </h3>
                
                 <hr style="width:100%" , color=black>
                 <h5> Expense Report From ' . $start . ' To ' . $end . ' </h5>
             </div>
             <table border="1" cellspacing="0" width="98%" style="font-size:9pt">
             <thead>
                 <tr>
                 <th style="width:100%">Expense Name</th>
                 <th style="width:100%">Expense Type</th>
                 <th style="width:50%">Expense Date</th>
                 <th style="width:100%">Expense Budget</th>
                 <th style="width:100%">Expense cost</th>
                 </tr>
             </thead>
             ';
     $ret = "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(`expense_date`, '%Y-%m-%d') BETWEEN '{$start}'AND '{$end}' AND ex.expense_user_id ='{$expense_user_id}' ORDER BY ex.expense_date DESC";
     $stmt = $mysqli->prepare($ret);
     $stmt->execute(); //ok
     $res = $stmt->get_result();
     $cumulative_expenses = 0;
    
     while ($expenses= $res->fetch_object()) {
         /* Total Amount  */
         
         $cumulative_expenses += $expenses->expense_cost;
         
         $html .= '
         <tr>
         <td>'.$expenses->category_name .'</td>
         <td>'.$expenses->category_status .'</td>
         <td>'.$expenses->expense_date .'</td>
         <td>Ksh. '.number_format($expenses->category_init_expense, 2) .'</td>
         <td>Ksh. '.number_format($expenses->expense_cost, 2) .'</td>
     </tr>
                                     ';
     }
 
     $html .= '
         <tr>
             <td  colspan="4"><b>Cumulative Expenses: </b></td>
             <td style="width:100%"><b>Ksh  ' . number_format($cumulative_expenses, 2)  . ' </b></td>
         </tr>';
        

     $html .= '
 </tbody>
 </table>
 </body>
 </html>';
 
     $dompdf = new Dompdf();
     $dompdf->load_html($html);
     $dompdf->set_paper('A4');
     $dompdf->set_option('isHtml5ParserEnabled', true);
     $dompdf->render();
     $dompdf->stream('Expenses From ' . $start . ' To ' . $end, array("Attachment" => 1));
     $options = $dompdf->getOptions();
     $options->setDefaultFont('');
     $dompdf->setOptions($options);

 }elseif ($form_type == 'pdf' && $category_status == 'all' && $category_name != 'all') {
 #Specific Category name and All Category Type
 $html = '
 <!DOCTYPE html>
 <html>

     <head>
         <meta name="" content="XYZ,0,0,1" />
         <style type="text/css">
             table {
                 font-size: 12px;
                 padding: 4px;
             }

             tr {
                 page-break-after: always;
             }

             th {
                 text-align: left;
                 padding: 4pt;
             }

             td {
                 padding: 5pt;
             }

             #b_border {
                 border-bottom: dashed thin;
             }

             legend {
                 color: #0b77b7;
                 font-size: 1.2em;
             }

             #error_msg {
                 text-align: left;
                 font-size: 11px;
                 color: red;
             }

             .header {
                 margin-bottom: 20px;
                 width: 100%;
                 text-align: left;
                 position: absolute;
                 top: 0px;
             }

             .footer {
                 width: 100%;
                 text-align: center;
                 position: fixed;
                 bottom: 5px;
             }

             #no_border_table {
                 border: none;
             }

             #bold_row {
                 font-weight: bold;
             }

             #amount {
                 text-align: right;
                 font-weight: bold;
             }

             .pagenum:before {
                 content: counter(page);
             }

             /* Thick red border */
             hr.red {
                 border: 1px solid red;
             }
             .list_header{
                 font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
             }
         </style>
     </head>

     <body style="margin:1px;">
         <div class="footer">
             <hr>
             <i>Expenses Report. Report Generated On ' . date('d M Y') . '</i>
         </div>

         <h3 class="list_header" align="center">
         <div class="list_header" align="center">
             
             <br>
             <h3>
                Expense Tracking Management 
             </h3>
            
             <hr style="width:100%" , color=black>
             <h5> Expense Report From ' . $start . ' To ' . $end . ' </h5>
         </div>
         <table border="1" cellspacing="0" width="98%" style="font-size:9pt">
         <thead>
             <tr>
             <th style="width:100%">Expense Name</th>
             <th style="width:100%">Expense Type</th>
             <th style="width:50%">Expense Date</th>
             <th style="width:100%">Expense Budget</th>
             <th style="width:100%">Expense cost</th>
             </tr>
         </thead>
         ';
 $ret = "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm 
 ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(ex.expense_date, '%Y-%m-%d') BETWEEN '{$start}'AND '{$end}' AND ex.expense_user_id ='{$expense_user_id}' 
 AND ca.category_name ='{$category_name}' ORDER BY ex.expense_date DESC";
 $stmt = $mysqli->prepare($ret);
 $stmt->execute(); //ok
 $res = $stmt->get_result();
 $cumulative_expenses = 0;

 while ($expenses= $res->fetch_object()) {
     /* Total Amount  */
     
     $cumulative_expenses += $expenses->expense_cost;
     
     $html .= '
     <tr>
     <td>'.$expenses->category_name .'</td>
     <td>'.$expenses->category_status .'</td>
     <td>'.$expenses->expense_date .'</td>
     <td>Ksh. '.number_format($expenses->category_init_expense, 2) .'</td>
     <td>Ksh. '.number_format($expenses->expense_cost, 2) .'</td>
 </tr>
                                 ';
 }

 $html .= '
     <tr>
         <td  colspan="4"><b>Cumulative Expenses: </b></td>
         <td style="width:100%"><b>Ksh  ' . number_format($cumulative_expenses, 2)  . ' </b></td>
     </tr>';
    

 $html .= '
</tbody>
</table>
</body>
</html>';

 $dompdf = new Dompdf();
 $dompdf->load_html($html);
 $dompdf->set_paper('A4');
 $dompdf->set_option('isHtml5ParserEnabled', true);
 $dompdf->render();
 $dompdf->stream('Expenses From ' . $start . ' To ' . $end, array("Attachment" => 1));
 $options = $dompdf->getOptions();
 $options->setDefaultFont('');
 $dompdf->setOptions($options);

  
 }elseif ($form_type == 'pdf' && $category_status != 'all' && $category_name == 'all'){
  #SPECIFIC Category type
    $html = '
    <!DOCTYPE html>
    <html>
   
        <head>
            <meta name="" content="XYZ,0,0,1" />
            <style type="text/css">
                table {
                    font-size: 12px;
                    padding: 4px;
                }
   
                tr {
                    page-break-after: always;
                }
   
                th {
                    text-align: left;
                    padding: 4pt;
                }
   
                td {
                    padding: 5pt;
                }
   
                #b_border {
                    border-bottom: dashed thin;
                }
   
                legend {
                    color: #0b77b7;
                    font-size: 1.2em;
                }
   
                #error_msg {
                    text-align: left;
                    font-size: 11px;
                    color: red;
                }
   
                .header {
                    margin-bottom: 20px;
                    width: 100%;
                    text-align: left;
                    position: absolute;
                    top: 0px;
                }
   
                .footer {
                    width: 100%;
                    text-align: center;
                    position: fixed;
                    bottom: 5px;
                }
   
                #no_border_table {
                    border: none;
                }
   
                #bold_row {
                    font-weight: bold;
                }
   
                #amount {
                    text-align: right;
                    font-weight: bold;
                }
   
                .pagenum:before {
                    content: counter(page);
                }
   
                /* Thick red border */
                hr.red {
                    border: 1px solid red;
                }
                .list_header{
                    font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                }
            </style>
        </head>
   
        <body style="margin:1px;">
            <div class="footer">
                <hr>
                <i>Expenses Report. Report Generated On ' . date('d M Y') . '</i>
            </div>
   
            <h3 class="list_header" align="center">
            <div class="list_header" align="center">
                
                <br>
                <h3>
                   Expense Tracking Management 
                </h3>
               
                <hr style="width:100%" , color=black>
                <h5> Expense Report From ' . $start . ' To ' . $end . ' </h5>
            </div>
            <table border="1" cellspacing="0" width="98%" style="font-size:9pt">
            <thead>
                <tr>
                <th style="width:100%">Expense Name</th>
                <th style="width:100%">Expense Type</th>
                <th style="width:50%">Expense Date</th>
                <th style="width:100%">Expense Budget</th>
                <th style="width:100%">Expense cost</th>
                </tr>
            </thead>
            ';
    $ret = "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm 
    ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(ex.expense_date, '%Y-%m-%d') BETWEEN '{$start}'AND '{$end}' AND ex.expense_user_id ='{$expense_user_id}' 
    AND ca.category_status ='{$category_status}' ORDER BY ex.expense_date DESC";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    $cumulative_expenses = 0;
   
    while ($expenses= $res->fetch_object()) {
        /* Total Amount  */
        
        $cumulative_expenses += $expenses->expense_cost;
        
        $html .= '
        <tr>
        <td>'.$expenses->category_name .'</td>
        <td>'.$expenses->category_status .'</td>
        <td>'.$expenses->expense_date .'</td>
        <td>Ksh. '.number_format($expenses->category_init_expense, 2) .'</td>
        <td>Ksh. '.number_format($expenses->expense_cost, 2) .'</td>
    </tr>
                                    ';
    }
   
    $html .= '
        <tr>
            <td  colspan="4"><b>Cumulative Expenses: </b></td>
            <td style="width:100%"><b>Ksh  ' . number_format($cumulative_expenses, 2)  . ' </b></td>
        </tr>';
       
   
    $html .= '
   </tbody>
   </table>
   </body>
   </html>';
   
    $dompdf = new Dompdf();
    $dompdf->load_html($html);
    $dompdf->set_paper('A4');
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->render();
    $dompdf->stream('Expenses From ' . $start . ' To ' . $end, array("Attachment" => 1));
    $options = $dompdf->getOptions();
    $options->setDefaultFont('');
    $dompdf->setOptions($options);
   

 }elseif ($form_type == 'pdf' && $category_status != 'all' && $category_name != 'all') {
    # Specific  Category Type and Name
     
    $html = '
    <!DOCTYPE html>
    <html>

        <head>
            <meta name="" content="XYZ,0,0,1" />
            <style type="text/css">
                table {
                    font-size: 12px;
                    padding: 4px;
                }

                tr {
                    page-break-after: always;
                }

                th {
                    text-align: left;
                    padding: 4pt;
                }

                td {
                    padding: 5pt;
                }

                #b_border {
                    border-bottom: dashed thin;
                }

                legend {
                    color: #0b77b7;
                    font-size: 1.2em;
                }

                #error_msg {
                    text-align: left;
                    font-size: 11px;
                    color: red;
                }

                .header {
                    margin-bottom: 20px;
                    width: 100%;
                    text-align: left;
                    position: absolute;
                    top: 0px;
                }

                .footer {
                    width: 100%;
                    text-align: center;
                    position: fixed;
                    bottom: 5px;
                }

                #no_border_table {
                    border: none;
                }

                #bold_row {
                    font-weight: bold;
                }

                #amount {
                    text-align: right;
                    font-weight: bold;
                }

                .pagenum:before {
                    content: counter(page);
                }

                /* Thick red border */
                hr.red {
                    border: 1px solid red;
                }
                .list_header{
                    font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                }
            </style>
        </head>

        <body style="margin:1px;">
            <div class="footer">
                <hr>
                <i>Expenses Report. Report Generated On ' . date('d M Y') . '</i>
            </div>

            <h3 class="list_header" align="center">
            <div class="list_header" align="center">
                
                <br>
                <h3>
                   Expense Tracking Management 
                </h3>
               
                <hr style="width:100%" , color=black>
                <h5> Expense Report From ' . $start . ' To ' . $end . ' </h5>
            </div>
            <table border="1" cellspacing="0" width="98%" style="font-size:9pt">
            <thead>
                <tr>
                <th style="width:100%">Expense Name</th>
                <th style="width:100%">Expense Type</th>
                <th style="width:50%">Expense Date</th>
                <th style="width:100%">Expense Budget</th>
                <th style="width:100%">Expense cost</th>
                </tr>
            </thead>
            ';
    $ret = "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE DATE_FORMAT(ex.expense_date, '%Y-%m-%d') BETWEEN '{$start}' AND '{$end}' AND ca.category_name ='{$category_name}' AND ca.category_status ='{$category_status}' AND ex.expense_user_id ='{$expense_user_id}' ORDER BY ex.expense_date DESC";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute(); //ok
    $res = $stmt->get_result();
    $cumulative_expenses = 0;
   
    while ($expenses= $res->fetch_object()) {
        /* Total Amount  */
        
        $cumulative_expenses += $expenses->expense_cost;
        
        $html .= '
        <tr>
        <td>'.$expenses->category_name .'</td>
        <td>'.$expenses->category_status .'</td>
        <td>'.$expenses->expense_date .'</td>
        <td>Ksh. '.number_format($expenses->category_init_expense, 2) .'</td>
        <td>Ksh. '.number_format($expenses->expense_cost, 2) .'</td>
    </tr>
                                    ';
    }

    $html .= '
        <tr>
            <td  colspan="4"><b>Cumulative Expenses: </b></td>
            <td style="width:100%"><b>Ksh  ' . number_format($cumulative_expenses, 2)  . ' </b></td>
        </tr>';
       

    $html .= '
</tbody>
</table>
</body>
</html>';

    $dompdf = new Dompdf();
    $dompdf->load_html($html);
    $dompdf->set_paper('A4');
    $dompdf->set_option('isHtml5ParserEnabled', true);
    $dompdf->render();
    $dompdf->stream('Expenses From ' . $start . ' To ' . $end, array("Attachment" => 1));
    $options = $dompdf->getOptions();
    $options->setDefaultFont('');
    $dompdf->setOptions($options);

}













}










    






    
    
