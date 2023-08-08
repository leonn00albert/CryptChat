<?php
namespace App\Controllers;

use Exception;
/**
 * Class A_Controller
 */
class A_Controller {
    /**
     * Renders a view file and returns its content.
     *
     * @param string $viewPath The path to the view file.
     *
     * @return string The content of the rendered view.
     */
    static protected function renderView(string $viewPath): string {
        try {
            ob_start();
            require_once(__DIR__ . "/../views/" . $viewPath);
            $content = ob_get_clean();
            return $content;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
