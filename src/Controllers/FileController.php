<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Utils\Router\JSON;
use App\Utils\Upload;
use Exception;

class FileController
{
    public static function profilePicture(): void
    {
        try {
            $profilePicture = new Upload();
            $profilePicture->upload();
        } catch (Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, 'error', $e->getMessage());
        }
    }
}
