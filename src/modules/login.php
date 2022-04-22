<?php

function login($username, $password) {
    require_once CONFIG_DIR.'dbconn.php';
    $pdo = connectToDatabase();

    if( !isset($username) || !isset($password) ){
        throw new Exception("Käyttäjätunnusta tai salasanaa ei asetettu");
    }

    if( empty($username) || empty($password) ){
        throw new Exception("Käyttäjätunnus tai salasana on tyhjä");
    }

    try{
        $sql = "SELECT * FROM person WHERE email=:username";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":username", $username);
        $statement->execute();

        if($statement->rowCount() <=0){
            throw new Exception("Kyseistä käyttäjää ei löydy. Tarkista käyttäjätunnus");
        }

        $row = $statement->fetch();

        if(!password_verify($password, $row["password"] )){
            throw new Exception("Väärä salasana. Olkaa hyvä ja yrittäkää uudelleen");
        }

        $_SESSION["username"] = $username;
        $_SESSION["firstname"] = $row["firstname"];
        $_SESSION["lastname"] = $row["lastname"];

    }catch(PDOException $e){
        throw $e;
    }
}

function logout(){
    try{
        session_unset();
        session_destroy();
    }catch(Exception $e){
        throw $e;
    }
}