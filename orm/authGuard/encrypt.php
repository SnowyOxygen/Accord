<?php

function encrypt($string){
    $ciphering = "AES-128-CTR";
  
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    
    // Non-NULL Initialization Vector for encryption
    $encryption_iv = file_get_contents(__DIR__."/encryption_vector.txt");
    
    // Store the encryption key
    $encryption_key = file_get_contents(__DIR__."/key.txt");
    $encryption = openssl_encrypt($string, $ciphering,
            $encryption_key, $options, $encryption_iv);
    return $encryption;        
}




?>