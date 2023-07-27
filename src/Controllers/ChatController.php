<?php
namespace App\Controllers;

class ChatController
{
    static public function index()
    {
        require_once(__DIR__ . "/../views/chat/index.html");
    }
}