<?php
namespace App\Utils;

class WebSocketLogger
{
    static function logRequest()
    {
        $logFile =  __DIR__ . '/../../request_log.txt';
    
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        $remoteAddr = $_SERVER['REMOTE_ADDR'];
        $timestamp = date('Y-m-d H:i:s');
    
        $logEntry = "$timestamp | $requestMethod | $requestUri | $remoteAddr" . PHP_EOL;
    
        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }
}
