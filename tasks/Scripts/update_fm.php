<?php
include('/opt/lampp/htdocs/Weekend/ExpenseTrackingSystem/config/config.php');
 $fm_year = date('Y');
 $fm_month = date('n');
 #update the previous Month As Inactive
 $query=mysqli_query($mysqli,"UPDATE `fiscal_month` SET `fm_status`='Inactive' WHERE `fm_status`='Active'");
 #Insert the new
$query=mysqli_query($mysqli,"INSERT INTO fiscal_month (salary)SELECT salary FROM fiscal_month WHERE fm_year=YEAR(CURRENT_DATE) - 1");
#update Fy
$query=mysqli_query($mysqli,"UPDATE `fiscal_month` SET `fm_year`='{$fm_year}',`fm_month`='{$fm_month}' WHERE `fm_status`='Active'");
?>