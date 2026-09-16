<?php

namespace App\Debug;

use Bitrix\Main\Diag\ExceptionHandlerFormatter;
use Bitrix\Main\Diag\FileExceptionHandlerLog;

class Log extends FileExceptionHandlerLog
{
    private $level;
    /** Префикс для записи системных исключений */
    private const LOG_PREFIX = "OTUS";

    /**
     * Запись в лог
     *
     * @param           $message
     * @param   false   $clear
     * @param   string  $fileName
     *
     * @return void
     */
    public static function addLog($message, bool $clear = false, string $fileName = 'custom_debug', $timeVersion = false): void
    {
        $logFile = $_SERVER["DOCUMENT_ROOT"] . '/local/logs/' . $fileName;

        //если директории не существует, то надо её создать
        if (!is_dir($_SERVER["DOCUMENT_ROOT"] . '/local/logs/')) {
            mkdir($_SERVER["DOCUMENT_ROOT"] . '/local/logs/');
        }

        if ($timeVersion) {
            $logFile .= '_' . date("d.m.Y");
        }
        $logFile .= '.log';

        $_message = date("d.m.Y H:i:s");
        $_message .= "\n";
        $_message .= print_r($message, true);
        $_message .= "\n";
        $_message .= "---";
        $_message .= "\n";

        if ($clear) {
            file_put_contents($logFile, $_message);
        } else {
            file_put_contents($logFile, $_message, FILE_APPEND);
        }
    }

    /**
     * Очистка лога
     *
     * @param string $fileName
     * @return void
     */
    public static function clearLog(string $fileName = 'custom_debug')
    {
        $logFile = $_SERVER["DOCUMENT_ROOT"] . '/local/logs/' . $fileName;
        $logFile .= '.log';
        file_put_contents($logFile, '');
    }

    /**
     * Запись в лог
     *
     * @param $exception
     * @param $logType
     *
     * @return void
     */
    public function write($exception, $logType): void
    {
        $text = ExceptionHandlerFormatter::format($exception, false, $this->level);

        $context = [
            'type' => static::logTypeToString($logType),
        ];

        $logLevel = static::logTypeToLevel($logType);

        $message = self::LOG_PREFIX." - {date} - Host: {host} - {type} - {$text}\n";

        $this->logger->log($logLevel, $message, $context);
    }

}
