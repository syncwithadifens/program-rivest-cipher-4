<?php
function rc4($key, $str)
{
    $s = array();
    for ($i = 0; $i < 256; $i++) {
        $s[$i] = $i;
    }
    $j = 0;
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
        $x = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $x;
    }
    $i = 0;
    $j = 0;
    $res = '';
    for ($y = 0; $y < strlen($str); $y++) {
        $i = ($i + 1) % 256;
        $j = ($j + $s[$i]) % 256;
        $x = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $x;
        $res .= $str[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
    }
    return $res;
}

if (isset($_POST['btn-encrypt'])) {
    $plaintext = $_POST['plaintext'];
    $key = $_POST['key'];
    if ($plaintext != '' && $key != '') {
        $ciphertext = rc4($key, $plaintext);
        $encodedCipher = base64_encode($ciphertext);
    } else {
        $encodedCipher = 'Plaintext & Key is required';
    }
}
if (isset($_POST['btn-decrypt'])) {
    $encodedCipher = $_POST['ciphertext'];
    $key = $_POST['key'];
    if ($encodedCipher != '' && $key != '') {
        $decrypted = rc4($key, base64_decode($encodedCipher));
    } else {
        $decrypted = 'Ciphertext & Key is required';
    }
}
if (isset($_POST['btn-reset'])) {
    $ciphertext = '';
}
