<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

use App\Debug\Log;

Log::clearLog('exceptions');
LocalRedirect('/homeworks/homework2/');
