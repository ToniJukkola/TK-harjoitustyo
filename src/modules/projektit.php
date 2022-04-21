<?php

function getProjects(){
    require_once CONFIG_DIR.'dbconn.php';

    try{
        $pdo = connectToDatabase();

        $sql = "SELECT * FROM project";

        $projects = $pdo->query($sql);

        return $projects->fetchAll();
     }catch(PDOException $e){
        throw $e;
     }
}

function addProject($id, $name){

    require_once CONFIG_DIR.'dbconn.php';
    
}