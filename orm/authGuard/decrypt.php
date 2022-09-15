<?php

function decrypt($string){
    $ciphering = "AES-128-CTR";
  
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    
    // Non-NULL Initialization Vector for encryption
    $decryption_iv = file_get_contents(__DIR__."/encryption_vector.txt");
    
    // Store the encryption key
    $decryption_key = file_get_contents(__DIR__."/key.txt");


    $decryption=openssl_decrypt ($string, $ciphering, 
    $decryption_key, $options, $decryption_iv);

    return $decryption;
}

?>