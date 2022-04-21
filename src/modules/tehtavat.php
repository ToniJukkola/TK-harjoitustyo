<?php

function getTasks()
{
    require_once CONFIG_DIR . 'dbconn.php';

    try {
        $pdo = connectToDatabase();
        $sql = "SELECT task.id AS task_id, task_name, CONCAT(SUBSTRING(due_date, 9, 2), '.', SUBSTRING(due_date, 6, 2), '.', YEAR(due_date)) as due_date, date_created, date_finished, priority_level, project_name, is_completed FROM task
        LEFT JOIN project ON project.id = task.project_id";
        $tasks = $pdo->query($sql);
        return $tasks->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function getTaskPeople($task_id)
{
    require_once CONFIG_DIR . 'dbconn.php';

    try {
        $pdo = connectToDatabase();
        $sql = "SELECT person.id, firstname, lastname FROM person
        LEFT JOIN task_persons ON task_persons.person_id = person.id
        LEFT JOIN task ON task.id = task_persons.task_id
        WHERE task.id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $task_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

function deleteTask($task_id)
{
    require_once CONFIG_DIR . 'dbconn.php';

    // if (!isset($is_completed)) {
    //     throw new Exception("Tehtävää ei ole merkitty tehdyksi");
    // }

    try {
        $pdo = connectToDatabase();
        $pdo->beginTransaction();

        // Poistetaan yhteys task_persons-taulusta
        $sql = "DELETE FROM task_persons WHERE task_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $task_id, PDO::PARAM_INT);
        $statement->execute();

        // Poistetaan task-taulusta
        $sql = "DELETE FROM task WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $task_id, PDO::PARAM_INT);
        $statement->execute();

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}
