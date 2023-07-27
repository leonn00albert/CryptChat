<?php
namespace App\Utils\Router;

class PostJSON {
    public static function read () {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if ($data === null) {
                http_response_code(400); 
                echo json_encode(array('error' => 'Invalid JSON data'));
                exit;
            }
            return $data;
        
        } else {
            http_response_code(405);
            echo json_encode(array('error' => 'Invalid request method or Content-Type'));
        }
    }

}