<?php

declare(strict_types=1);

namespace App\Utils\Router;

class JSON
{
    public const HTTP_STATUS_OK = 200;
    public const HTTP_BAD_REQUEST = 400;
    /**
     * Read JSON data from the POST request body and decode it into an associative array.
     *
     * @return array<mixed> The associative array containing the JSON data.
     */
    public static function read(): array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['CONTENT_TYPE'] === 'application/json') {
            $json_data = file_get_contents('php://input');
            $data = json_decode($json_data, true);
            if ($data === null) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON data']);
                exit;
            }
            return $data;
        }
        http_response_code(405);
        echo json_encode(['error' => 'Invalid request method or Content-Type']);
        return [];

    
    }
    /**
     * Send a JSON response with the provided data and HTTP status code.
     *
     * @param int    $code    The HTTP status code for the response.
     * @param string $type    The type of the response (e.g., "success" or "error").
     * @param string $message The message to include in the response.
     */
    public static function response(int $code, string $type, string $message): void
    {
        http_response_code($code);
        echo json_encode(
            [
                'message' => $message,
                'type' => $type,
            ]
        );
    }
}
