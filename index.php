<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;
use App\Utils\Socket\WebSocketServer;


Router::get('/login', 'login');
Router::get('/logout', 'logout');
Router::get('/register', 'register');
Router::get('/', 'home');
Router::post('/auth/login', 'auth/login');

if (isset($_SESSION["auth"]) && $_SESSION["auth"]) {
    Router::get('/chat', 'chat/index');
    Router::get('/settings', 'settings');
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
    Router::post("/users/search","users/search");
    Router::post("/upload/image", "upload/image");
    Router::post("/settings/password", "settings/password");

}


Router::start();
