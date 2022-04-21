<?php

/**
 * Yhdistää tietokantaan
 */
function connectToDatabase(): object {
    $init = parse_ini_file("config.ini");
    $host = $init["host"];
    $dbname = $init["database"];
    $user = $init["username"];
    $password = $init["password"];
    try {
      $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $user, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $pdoex) {
      echo $pdoex->getMessage();
    }  
    return $pdo;
}

/**
 * Yhdistää localhostiin (setup.php:tä varten)
 */
function connectToLocalhost(): object {
    $init = parse_ini_file("config.ini");
    $host = $init["host"];
    $user = $init["username"];
    $password = $init["password"];
    try {
      $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $pdoex) {
      echo $pdoex->getMessage();
    }  
    return $pdo;
}