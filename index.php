<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php'; 

use App\Router\Router;
use App\Utils\Socket\WebSocketServer;


Router::get('/login' ,'login');
Router::get('/register' ,'register');
Router::get('/' ,'home');
Router::get('/message' ,'message');
Router::post('/users' ,'user/create');
Router::post('/auth/login' ,'auth/login');

if( isset($_SESSION["auth"]) && $_SESSION["auth"]) {
    Router::get('/chat' ,'chat/index');
}


Router::start();