<?php

$hash_pw = password_hash($orig_pw, PASSWORD_DEFAULT,['cost' => 16]);



if(password_verify($orig_pw, $hash_pw)) {
    echo "Jee";
}

