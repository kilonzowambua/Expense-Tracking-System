<?php
#Total Income
$query = "SELECT SUM(fm.salary) AS total_income FROM expenses AS ex INNER JOIN fiscal_month AS fm ON ex.expense_fm_id=fm.fm_id INNER JOIN users AS us ON ex.expense_user_id=us.user_id WHERE us.user_id='{$user_id}'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($total_income);
$stmt->fetch();
$stmt->close();

#Total Expenses
$query = "SELECT SUM(expense_cost)AS total_expenses  FROM expenses WHERE expense_user_id='{$user_id}'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($total_expenses);
$stmt->fetch();
$stmt->close();
#Month expense
$query = "SELECT SUM(ex.expense_cost)AS monthly_expenses FROM expenses AS ex INNER JOIN fiscal_month AS fm ON ex.expense_fm_id=fm.fm_id WHERE fm.fm_status='Active' AND ex.expense_user_id='{$user_id}'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($monthly_expenses);
$stmt->fetch();
$stmt->close();
#Net Balance
$query = "SELECT (((SUM(fm.salary)- SUM(ex.expense_cost))/fm.salary)*100) AS Net_Monthly_Balance_percentage,(SUM(fm.salary)-SUM(ex.expense_cost))AS Net_Monthly_Balance FROM expenses AS ex INNER JOIN fiscal_month AS fm ON ex.expense_fm_id=fm.fm_id WHERE fm.fm_status='Active' AND ex.expense_user_id='{$user_id}'";
$stmt = $mysqli->prepare($query);
$stmt->execute();
$stmt->bind_result($Net_Monthly_Balance_percentage,$Net_Monthly_Balance);
$stmt->fetch();
$stmt->close();