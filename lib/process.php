<?php
require_once './config/config.php';
//require_once '../authenticate.php';

//generate random string
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

//getdate
$transaksi_id = generate_string($permitted_chars, 7);
$date=date('Y-m-d');
$hour=date('H:i');
$updatetime=date('Y-m-d H:i:s');

$db=getDbInstance();
?>
