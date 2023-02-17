<?php
include('/opt/lampp/htdocs/Weekend/ExpenseTrackingSystem/config/config.php');
#First Query
$user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id WHERE ca.category_status='monthly' AND fm_month=MONTH(CURRENT_DATE) - 1 ORDER BY ex.expense_date DESC");
if (mysqli_num_rows($user_sql) > 0) {

        #Second Query
        $current_year=mysqli_query($mysqli, "SELECT * FROM `fiscal_month` WHERE fm_status='Active'");
        while ($user = mysqli_fetch_array($user_sql) && $year=mysqli_fetch_array($current_year)) {
                #Declare varibles
                $expense_category_id=mysqli_real_escape_string($mysqli,$user['expense_category_id']);
                $expense_fm_id=mysqli_real_escape_string($mysqli,$year['expense_fm_id']);
                $expense_user_id=mysqli_real_escape_string($mysqli,$user['expense_user_id']);
                $expense_cost=mysqli_real_escape_string($mysqli,$user['expense_cost']);

                #Insert The recurring Expenses
                $insert_recurring_expense_query = mysqli_query($mysqli, "INSERT INTO `expenses`(`expense_category_id`, `expense_fm_id`, `expense_user_id`, `expense_cost`) VALUES ('{$expense_category_id}','{$expense_fm_id}','{$expense_user_id}','{$expense_cost}')");
        }}

        ?>
