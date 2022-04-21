<?php

function getPerson(){
    require_once CONFIG_DIR.'dbconn.php';

    try{
        $pdo = connectToDatabase();
        // Create SQL query 
        $sql = "SELECT id, username, firstname, lastname FROM person";
        // Execute the query
        $person = $pdo->query($sql);

        return $person->fetchAll();
    }catch(PDOException $e){
        throw $e;
    }

}