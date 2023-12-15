<?php
    function encryptData($data, $key, $iv) {
        $encryptedData = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encryptedData);
    }

    function decryptData($encryptedData, $key, $iv) {
        $decryptedData = openssl_decrypt(base64_decode($encryptedData), 'aes-256-cbc', $key, 0, $iv);
        return $decryptedData;
    }
?>