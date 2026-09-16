<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
use App\Debug\Log;

Log::clearLog();

LocalRedirect('/homeworks/homework2/');
