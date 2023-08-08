<?php
namespace App\Utils\Auth;

/**
 * Class Crypto
 * Provides encryption and decryption using Sodium cryptographic library.
 */
class Crypto {

    /**
     * Encrypts data using Sodium's crypto_box.
     *
     * @param string $data The data to be encrypted.
     * @param string $privateAKey The private key of party A.
     * @param string $publicBKey The public key of party B.
     *
     * @return string The encrypted data.
     */
    static public function encrypt(string $data, string $privateAKey, string $publicBKey): string {
        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
        $encryption_key = sodium_crypto_box_keypair_from_secretkey_and_publickey($privateAKey, $publicBKey);
        $encrypted = sodium_crypto_box($data, $nonce, $encryption_key);
        return $encrypted;
    }

    /**
     * Decrypts encrypted data using Sodium's crypto_box_open.
     *
     * @param string $encryptedData The encrypted data to be decrypted.
     * @param string $privateBKey The private key of party B.
     * @param string $publicAKey The public key of party A.
     *
     * @return string|false The decrypted data, or false on failure.
     */
    static public function decrypt(string $encryptedData, string $privateBKey, string $publicAKey): string|false {
        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
        $decryption_key = sodium_crypto_box_keypair_from_secretkey_and_publickey($privateBKey, $publicAKey);
        $decrypted = sodium_crypto_box_open($encryptedData, $nonce, $decryption_key);
        return $decrypted !== false ? $decrypted : false;
    }
}
