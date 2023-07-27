<?php
require_once __DIR__ . '/vendor/autoload.php'; 

use App\Router\Router;

Router::add('/login' ,'login');
Router::add('/register' ,'register');
Router::add('/' ,'home');

Router::start();