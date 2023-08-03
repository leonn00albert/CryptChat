<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;
use App\Utils\Socket\WebSocketServer;


Router::get('/login', 'login');
Router::get('/register', 'register');
Router::get('/', 'home');
Router::post('/auth/login', 'auth/login');

if (isset($_SESSION["auth"]) && $_SESSION["auth"]) {
    Router::get('/chat', 'chat/index');
    Router::get('/chats/{hash}', 'chats/show');
    Router::get('/new/{username}', 'chat/new');
    Router::get('/users', 'users');
    Router::get('/conversations/{hash}', 'conversations/read');
    Router::get('/conversation/keys/1', 'get/key');
    Router::get('/users/keys/1', 'users/key');
    Router::get('/message', 'message');
    Router::get('/messages/latest/{hash}', 'messages/latest');
    Router::post('/messages', 'messages/new');
    Router::post('/user', 'user/create');
}


Router::start();
