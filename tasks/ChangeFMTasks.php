<?php

declare(strict_types=1);


use Crunz\Schedule;

$scheduler = new Schedule();
$task = $scheduler->run(PHP_BINARY . ' /opt/lampp/htdoc/Weekend/Expense Tracking System/tasks/Scripts/update_fm.php');
$task
    ->description('Update Month')
    ->preventOverlapping()
    ->monthly();
;

return $scheduler;
