<?php 
namespace App\Config;
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


class DatabaseConfig {
   const  SERVER_NAME = $_ENV["DB_HOST"] ?? "localhost";
   const  USER_NAME = $_ENV["DB_USER"] ?? "root";
   const  PASSWORD =  $_ENV["DB_PASSWORD"] ?? "";
   const  DB_NAME  =  $_ENV["DB_NAME"]  ?? "cryptchat";
}