<?php
include('/opt/lampp/htdocs/Weekend/Expense%20Tracking%20System/config/config.php');
$user_sql = mysqli_query($mysqli, "SELECT * FROM expenses AS ex INNER JOIN fiscal_month AS fm ON fm.fm_id=ex.expense_fm_id INNER JOIN categories AS ca ON ca.category_id=ex.expense_category_id   ORDER BY ex.expense_date DESC");

        ?>
