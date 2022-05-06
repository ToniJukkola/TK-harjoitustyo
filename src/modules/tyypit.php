<?php

function getPerson(){
    require_once CONFIG_DIR.'dbconn.php';
    
    try{
        $pdo = connectToDatabase();
        // Create SQL query 
        $sql = "SELECT person.id AS person_id, username, email, firstname, lastname FROM person";
        // Execute the query
        $person = $pdo->query($sql);

        return $person->fetchAll();
    }catch(PDOException $e){
        throw $e;
    }

}

function getOnePerson($person_id){
    require_once CONFIG_DIR.'dbconn.php';

    try{
        $pdo = connectToDatabase();
        // Create SQL query 
        $sql = "SELECT person.id AS person_id, username, email, firstname, lastname FROM person 
        WHERE person.id = ?";
        // Execute the query
        $person = $pdo->prepare($sql);
        $person->bindParam(1, $person_id, PDO::PARAM_INT);
        $person->execute();

        return $person->fetchAll();
    }catch(PDOException $e){
        throw $e;
    }

}

function addPerson($username, $email, $firstname, $lastname) {

    require_once CONFIG_DIR . 'dbconn.php';
    require_once MODULES_DIR . 'tyypit.php';

    // Tarkistetaan, että käyttäjä on kirjautunut
    checkIfLoggedIn();

    // Tarkistetaan, että arvot on asetettu
    if (!isset($username) || !isset($email) || !isset($firstname) || !isset($lastname)) {
        throw new Exception("Et voi lisätä tyhjiä arvoja.");
    }
    // Lisätään uusi henkilö kantaan
    try {
        $pdo = connectToDatabase();
        $pdo->beginTransaction();

        // Lisätään henkilön käyttäjänimi, etunimi ja sukunimi
        $sql = "INSERT INTO person (username, email, firstname, lastname) VALUES (?, ?, ?, ?);";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $username, PDO::PARAM_STR);
        $statement->bindParam(2, $email, PDO::PARAM_STR);
        $statement->bindParam(3, $firstname, PDO::PARAM_STR);
        $statement->bindParam(4, $lastname, PDO::PARAM_STR);
        $statement->execute();
        $person_id = $pdo->lastInsertId();

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}

function deletePerson($person_id) {

    require_once CONFIG_DIR . 'dbconn.php';
    require_once MODULES_DIR . 'tyypit.php';

    // Tarkistetaan, että käyttäjä on kirjautunut
      checkIfLoggedIn();

    // Tarkistetaan että henkilön id on tiedossa
    if (!isset($person_id)) {
        throw new Exception("Virhe poistettavan henkilön id:n noutamisessa.");
    }

    try {
        $pdo = connectToDatabase();
        
        // Poistetaan person-taulusta
        $sql = "DELETE FROM person WHERE person.id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $person_id, PDO::PARAM_INT);
        $statement->execute();
       
    } catch (PDOException $e) {
        throw $e;
    }
}

function checkIfLoggedIn()
{
    if (!isset($_SESSION["username"])) {
        throw new Exception("Sinun täytyy kirjautua sisään.");
    }
}