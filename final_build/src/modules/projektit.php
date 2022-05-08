<?php


// hakee projektit
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

//lisää projektin
function addProject($project_name){

    require_once CONFIG_DIR.'dbconn.php';

    if(!isset($project_name) ) {
        throw new Exception("Ei toi ny tollee onnistu"); 
    }

    if( empty($project_name) ){
        throw new Exception("Tyhjää tyhjää tyhjäää tyhjääääää");
    }

    try{
        $pdo = connectToDatabase();

        $sql = "INSERT INTO project(project_name) VALUES (?)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $project_name);

        $statement->execute();
    }catch(PDOException $e){
        throw $e;
    }
}