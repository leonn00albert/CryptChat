<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Utils\Auth\AuthException;
use App\Utils\Router\JSON;
use Exception;

class DevController
{

    public static function DeployUpdate(){ 
        echo "deployed new build";
        shell_exec('/bin/bash /home/ubuntu/CryptChat/build.sh 2> deployment_log.txt');

    }

    public static function githubWebhook($data){ 
        echo json_encode($data);
    }
}
