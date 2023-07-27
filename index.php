<?php
require_once __DIR__ . '/vendor/autoload.php'; 

require_once 'Router.php';



Router::add('/' ,'home');

Router::start();