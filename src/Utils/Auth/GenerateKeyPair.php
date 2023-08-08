<?php
namespace App\Utils\Auth;

use Exception;

class generateKeyPair
{

    static function create(): array
    {
        if (extension_loaded('sodium')) {
                $keyPair = sodium_crypto_box_keypair();
        
                $publicKey = bin2hex(sodium_crypto_box_publickey($keyPair));
                $privateKey = bin2hex(sodium_crypto_box_secretkey($keyPair));
                return array(
                    'public_key' => $publicKey,
                    'private_key' => $privateKey,
                );
     
        } else {
            echo "Sodium extension not available. Please make sure you are using PHP 7.2 or later.";
            return [];
        }
    }
}
    