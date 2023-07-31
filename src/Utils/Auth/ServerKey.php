<?php
$keyPair = openssl_pkey_new(array(
    'private_key_bits' => 2048,
    'private_key_type' => OPENSSL_KEYTYPE_RSA,
));

openssl_pkey_export($keyPair, $privateKey);
$publicKey = openssl_pkey_get_details($keyPair)['key'];

file_put_contents('/env/public_key.pem', $publicKey);

function encryptWithPublicKey($data, $publicKey)
{
    openssl_public_encrypt($data, $encrypted, $publicKey);
    return base64_encode($encrypted);
}
function decryptWithPrivateKey($encryptedData, $privateKey)
{
    openssl_private_decrypt(base64_decode($encryptedData), $decrypted, $privateKey);
    return $decrypted;
}

$dataToEncrypt = 'Hello, this is a secret message!';
$encryptedData = encryptWithPublicKey($dataToEncrypt, $publicKey);
echo "Encrypted data: " . $encryptedData . "\n";

$decryptedData = decryptWithPrivateKey($encryptedData, $privateKey);
echo "Decrypted data: " . $decryptedData . "\n";




//decrypt 

$privateKey = openssl_pkey_get_private(file_get_contents('private_key.pem'));

// Retrieve the encrypted symmetric key from the client
$encryptedSymmetricKey = base64_decode($_POST['encryptedSymmetricKey']);

// Decrypt the symmetric key using the server's private key
openssl_private_decrypt($encryptedSymmetricKey, $symmetricKey, $privateKey);

// Retrieve the encrypted message from the client
$encryptedMessage = base64_decode($_POST['encryptedMessage']);

// Decrypt the message using the symmetric key
$decryptedMessage = openssl_decrypt($encryptedMessage, 'aes-256-ecb', $symmetricKey);

// Now $decryptedMessage contains the original message
echo $decryptedMessage;