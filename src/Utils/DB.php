<?php
namespace App\Utils;
use App\Config\DatabaseConfig;
use Exception;
use PDO;
class DB {
        private static $instances = [];
   
        protected function __construct() { }
    
  
        protected function __clone() { }


        public function __wakeup()
        {
            throw new \Exception("Cannot unserialize a singleton.");
        }
        public static function getInstance(): PDO 
        {
            $cls = static::class;
            if (!isset(self::$instances[$cls])) {
                try {
                    self::$instances[$cls] = new PDO("mysql:host=" . DatabaseConfig::SERVER_NAME . ";dbname=" . DatabaseConfig::DB_NAME, DatabaseConfig::USER_NAME,DatabaseConfig::PASSWORD);

                }
                catch(Exception $e) {

                }
            }
    
            return self::$instances[$cls];
        }
        public static function conn() {
            
        }
    
}