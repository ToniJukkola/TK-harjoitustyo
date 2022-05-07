<?php
    require_once CONFIG_DIR.'dbconn.php';

function login($username, $password) {
    $pdo = connectToDatabase();

    if( !isset($username) || !isset($password) ){
        throw new Exception("Käyttäjätunnusta tai salasanaa ei asetettu");
    }

    if( empty($username) || empty($password) ){
        throw new Exception("Käyttäjätunnus tai salasana on tyhjä");
    }

    try{
        $sql = "SELECT * FROM person WHERE username = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $username);
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

function register($username, $password, $firstName, $lastName, $email) {
    if( !isset($firstName) || !isset($lastName) || !isset($username) || !isset($password) ){
        throw new Exception('Tapahtui virhe. Kaikkia tietoja ei saatu. Ole yhteydessä "koodariin".');
    }
    
    if( empty($firstName) || empty($lastName) || empty($username) || empty($password) ){
        throw new Exception("Älä jätä kenttiä tyhjäksi");
    }
    
    try{
        $pdo = connectToDatabase();
        $sql = "INSERT INTO person (firstname, lastname, email, password, username) VALUES (?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $firstName);
        $statement->bindParam(2, $lastName);
        $statement->bindParam(3, $email);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $statement->bindParam(4, $hashed_password);
        $statement->bindParam(5, $username);
        
        $statement->execute();
    }catch(PDOException $e){
        throw $e;
    }
}

function findUserByEmail($email) {
    try{
        $pdo = connectToDatabase();
        $sql = "SELECT * FROM person WHERE email = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $email);
        $statement->execute();

        $row = $statement->fetch();

        return $row;
    }catch(PDOException $e){
        throw $e;
    }
}
