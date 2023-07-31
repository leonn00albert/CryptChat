<?php
namespace App\Utils\Auth;

use App\Models\User;
use Exception;

class GenerateSharedKey
{
    private static int $keyLength = 32;
    static function create(User $userA, User $userB)
    {
        $sharedkey = random_bytes(self::$keyLength);
        return [ 
            "sharedKeyA" => bin2hex(sodium_crypto_box_seal($sharedkey,hex2bin($userA->public_key))),
            "sharedKeyB" => bin2hex(sodium_crypto_box_seal($sharedkey,hex2bin($userB->public_key))),

        ];
    }
}
