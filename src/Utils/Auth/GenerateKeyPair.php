<?php
namespace App\Utils\Auth;
class generateKeyPair
{

    static function create(): array
    {
        $privateKeyConfig = array(
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        );

        $privateKeyResource = openssl_pkey_new($privateKeyConfig);

        openssl_pkey_export($privateKeyResource, $privateKey);

        $publicKey = openssl_pkey_get_details($privateKeyResource)['key'];

        return array(
            'private_key' => $privateKey,
            'public_key' => $publicKey,
        );
    }
}
