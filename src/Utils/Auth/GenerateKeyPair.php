<?php

declare(strict_types=1);

namespace App\Utils\Auth;

class generateKeyPair
{
    public static function create(): array
    {
        if (extension_loaded('sodium')) {
            $keyPair = sodium_crypto_box_keypair();

            $publicKey = bin2hex(sodium_crypto_box_publickey($keyPair));
            $privateKey = bin2hex(sodium_crypto_box_secretkey($keyPair));
            return [
                'public_key' => $publicKey,
                'private_key' => $privateKey,
            ];
        }
        echo 'Sodium extension not available. Please make sure you are using PHP 7.2 or later.';
        return [];
    }
}
