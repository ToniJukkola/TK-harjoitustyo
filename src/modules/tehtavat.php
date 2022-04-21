<?php

function getTasks()
{
    require_once CONFIG_DIR . 'dbconn.php';

    try {
        $pdo = connectToDatabase();
        $sql = "SELECT task.id, task_name, CONCAT(SUBSTRING(due_date, 9, 2), '.', SUBSTRING(due_date, 6, 2), '.', YEAR(due_date)) as due_date, date_created, date_finished, priority_level, project_name FROM task
        LEFT JOIN project ON project.id = task.project_id";
        $tasks = $pdo->query($sql);
        return $tasks->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}
