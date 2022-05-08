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
//yhden projektin haku
function getSingleProject($project_id){
    require_once CONFIG_DIR.'dbconn.php';

    try{
        $pdo = connectToDatabase();
        // Create SQL query 
        $sql = "SELECT project.id AS project_id, project_name FROM project 
        WHERE project.id = ?";
        // Execute the query
        $project = $pdo->prepare($sql);
        $project->bindParam(1, $project_id, PDO::PARAM_INT);
        $project->execute();

        return $project->fetchAll();
    }catch(PDOException $e){
        throw $e;
    }

}
//projketin poisto
function deleteProject($project_id) {

    require_once CONFIG_DIR . 'dbconn.php';
    require_once MODULES_DIR . 'account-control.php';


      checkIfLoggedIn();

    
    if (!isset($project_id)) {
        throw new Exception("Virhe virhe virhe virhe!!! ei projektiaaaaa");
    }

    try {
        $pdo = connectToDatabase();
        

        //poistetaan yhteys task-taulusta
        $sql = "DELETE task_persons
         FROM task_persons 
         LEFT JOIN task ON task_persons.task_id = task.id
          WHERE task.project_id = ?";
          
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $project_id, PDO::PARAM_INT);
        $statement->execute();

        //poisto projekti-taulusta
        $sql = "DELETE FROM project WHERE project.id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $project_id, PDO::PARAM_INT);
        $statement->execute();
       
        
    } catch (PDOException $e) {
        throw $e;
    }
}