<?php
namespace App\Utils\Auth;

class Crypto {

 /**
  * @param mixed $data
  * @param mixed $privateAKey the private key of sending
  * @param mixed $publicBKey
  * 
  * @return [type]
  */
    static public function encrypt($data, $privateAKey, $publicBKey) {
        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
        $encryption_key = sodium_crypto_box_keypair_from_secretkey_and_publickey($privateAKey, $publicBKey);
        $encrypted = sodium_crypto_box($data, $nonce, $encryption_key);
        return $encrypted;
    }
      
    

    static public function decrypt($encryptedData,$privateBKey, $publicAKey) {
        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);

        $decryption_key = sodium_crypto_box_keypair_from_secretkey_and_publickey($privateBKey, $publicAKey);
        $decrypted = sodium_crypto_box_open($encryptedData, $nonce, $decryption_key);
        return $decrypted;
    }
}



