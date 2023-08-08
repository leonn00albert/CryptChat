<?php
namespace App\Controllers;

use App\Utils\Router\JSON;
use App\Utils\Upload;
use Exception;


class FileController
{
    static public function profilePicture()
    {
        try {
            $profilePicture = new Upload();
            $profilePicture->upload();
        } catch (Exception $e) {
            JSON::response(JSON::HTTP_BAD_REQUEST, "error", $e->getMessage());
        }
    }

}