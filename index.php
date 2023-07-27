<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php'; 

use App\Router\Router;

Router::get('/login' ,'login');
Router::get('/register' ,'register');
Router::get('/' ,'home');
Router::post('/users' ,'user/create');
Router::get('/chat' ,'chat/index');

Router::start();