<?php

declare(strict_types=1);

namespace App\Utils\Auth;

use App\Models\User;

class GenerateSharedKey
{
    private static int $keyLength = 32;
    public static function create(User $userA, User $userB)
    {
        $sharedkey = random_bytes(self::$keyLength);
        return [
            'sharedKeyA' => bin2hex(sodium_crypto_box_seal($sharedkey, hex2bin($userA->public_key))),
            'sharedKeyB' => bin2hex(sodium_crypto_box_seal($sharedkey, hex2bin($userB->public_key))),

        ];
    }
}
