<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php'; 

use App\Router\Router;
use App\Utils\Socket\WebSocketServer;


Router::get('/login' ,'login');
Router::get('/register' ,'register');
Router::get('/' ,'home');
Router::get('/chats/{id}','chats/show');
Router::get('/conversations/{id}','conversations/read');
Router::get('/conversation/keys/1','get/key');
Router::get('/users/keys/1','users/key');
Router::get('/message' ,'message');
Router::post('/messages' ,'messages/new');
Router::post('/users' ,'user/create');
Router::post('/auth/login' ,'auth/login');

if( isset($_SESSION["auth"]) && $_SESSION["auth"]) {
    Router::get('/chat' ,'chat/index');
}


Router::start();    