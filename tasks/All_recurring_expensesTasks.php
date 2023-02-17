<?php

declare(strict_types=1);
/*
|--------------------------------------------------------------------------------------
|  Task File
|--------------------------------------------------------------------------------------
|
| This file basically registers a new task to be executed by Crunz
| To get the list of all frequency and constraint method, you may
| go to this link: https://github.com/crunzphp/crunz#frequency-of-execution
|
*/

use Crunz\Schedule;

$scheduler = new Schedule();
$task1 = $scheduler->run(PHP_BINARY . ' /opt/lampp/htdocs/Weekend/ExpenseTrackingSystem/tasks/Scripts/update_yearly_expenses.php');
$task1
    ->description('Year Expenses')
    ->preventOverlapping()
    ->yearly();

;
$task2 = $scheduler->run(PHP_BINARY . ' /opt/lampp/htdocs/Weekend/ExpenseTrackingSystem/tasks/Scripts/update_month_expenses.php');
$task2
    ->description('Monthly Expenses')
    ->preventOverlapping()
    ->monthly();
;
$task3 = $scheduler->run(PHP_BINARY . ' /opt/lampp/htdocs/Weekend/ExpenseTrackingSystem/tasks/Scripts/update_weekly_expenses.php');
$task3
    ->description('Weekly Expenses')
    ->preventOverlapping()
    ->weekly();
$task4 = $scheduler->run(PHP_BINARY . ' /opt/lampp/htdocs/Weekend/ExpenseTrackingSystem/tasks/Scripts/update_daily_expenses.php');
$task4
    ->description('Daily Expenses')
    ->preventOverlapping()
    ->daily(); 
;
return $scheduler;
