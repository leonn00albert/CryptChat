<?php
namespace App\Utils;

class DevLogger
{
    static function logRequest($message, $commitId, $author)
    {
        $logFile =  __DIR__ . '/../../dev_log.txt';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "$timestamp | $message | $commitId | $author" . PHP_EOL;
    
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
