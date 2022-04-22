<?php

/**
 * Hakee kaikki tehtävät
 */
function getTasks()
{
    require_once CONFIG_DIR . 'dbconn.php';

    try {
        $pdo = connectToDatabase();
        $sql = "SELECT task.id AS task_id, task_name, due_date, CONCAT(SUBSTRING(due_date, 9, 2), '.', SUBSTRING(due_date, 6, 2), '.', YEAR(due_date)) as due_date_local, date_created, date_finished, CONCAT(SUBSTRING(date_finished, 9, 2), '.', SUBSTRING(date_finished, 6, 2), '.', YEAR(date_finished)) as date_finished_local, priority_level, project_name FROM task
        LEFT JOIN project ON project.id = task.project_id";
        $tasks = $pdo->query($sql);
        return $tasks->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Hakee yksittäisen tehtävän tehtävän id:n perusteella
 */
function getSingleTask($task_id)
{
    require_once CONFIG_DIR . 'dbconn.php';

    try {
        $pdo = connectToDatabase();
        $sql = "SELECT task.id AS task_id, task_name, due_date, CONCAT(SUBSTRING(due_date, 9, 2), '.', SUBSTRING(due_date, 6, 2), '.', YEAR(due_date)) as due_date_local, date_created, date_finished, CONCAT(SUBSTRING(date_finished, 9, 2), '.', SUBSTRING(date_finished, 6, 2), '.', YEAR(date_finished)) as date_finished_local, priority_level, project_name, project_id FROM task
        LEFT JOIN project ON project.id = task.project_id
        WHERE task.id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $task_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch();
    } catch (PDOException $e) {
        throw $e;
    }
}

/**
 * Hakee tehtävään kiinnitetyt henkilöt tehtävän id:n perusteella
 */
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

/**
 * Hakee task_persons-taulusta rivin, joka vastaa parametreina annettua henkilön id:tä ja tehtävän id:tä
 */
function getTaskPersonsRowByPersonAndTask($person_id, $task_id)
{
    require_once CONFIG_DIR . 'dbconn.php';

    try {
        $pdo = connectToDatabase();
        $sql = "SELECT * FROM task_persons WHERE person_id = ? AND task_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $person_id, PDO::PARAM_INT);
        $statement->bindParam(2, $task_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    } catch (PDOException $e) {
        throw $e;
    }
}

/** 
 * Poistaa tehtävän
 */
function deleteTask($task_id)
{
    require_once CONFIG_DIR . 'dbconn.php';

    if (!isset($task_id)) {
        throw new Exception("Virhe poistettavan tehtävän id:n noutamisessa.");
    }

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

/**
 * Muokkaa tehtävää
 */
function editTask($task_id, $task_name, $due_date, $project_id)
{
    require_once CONFIG_DIR . 'dbconn.php';
    require_once MODULES_DIR . 'tyypit.php';
    
    // Tarkistetaan, että arvot on asetettu
    if (!isset($task_name) || !isset($due_date) || !isset($project_id)) {
        throw new Exception("Et voi lisätä tyhjiä arvoja. Tehtävällä täytyy olla vähintään<ol>
        <li>nimi</li><li>deadline</li><li>projekti, johon tehtävä liittyy</li></ol>");
    }

    // Tarkistetaan, etteivät arvot ole tyhjiä
    if (empty($task_name) || empty($due_date) || empty($project_id)) {
        throw new Exception("Et voi lisätä tyhjiä arvoja. Tehtävällä täytyy olla vähintään
        <ol>
        <li>nimi</li><li>deadline</li><li>projekti, johon tehtävä liittyy</li></ol>");
    }

    try {
        $pdo = connectToDatabase();

        // Päivitetään nimi, deadline ja projekti
        $sql = "UPDATE task
        SET task_name = ?, due_date = ?, project_id = ?
        WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $task_name, PDO::PARAM_STR);
        $statement->bindParam(2, $due_date, PDO::PARAM_STR);
        $statement->bindParam(3, $project_id, PDO::PARAM_INT);
        $statement->bindParam(4, $task_id, PDO::PARAM_INT);
        $statement->execute();

        // Haetaan kaikki henkilöt ja loopataan läpi
        $people = getPerson();
        foreach ($people as $person) {
            // Jos henkilö vastaava checkbox ei ole checked -> poistetaan henkilöä vastaava tehtävärivi task_personsista
            $checkboxname = "person" . $person["id"]; // loopilla lomakkeelle tuotetun checkboxin (templates/checkbox-henkilot.php) namea vastaavan muuttuja luominen
            if (!isset($_POST[$checkboxname])) {
                $sql = "DELETE FROM task_persons WHERE task_id = ? AND person_id = ?;";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(1, $task_id, PDO::PARAM_INT);
                $statement->bindParam(2, $person["id"], PDO::PARAM_INT);
                $statement->execute();
            } else { // Jos checkbox on valittu
                // Haetaan task_persons-taulun rivit, jotka vastaavat tehtävän ja henkilön id:tä
                $taskrows = getTaskPersonsRowByPersonAndTask($person["id"], $task_id);
                // Jos ei vielä ole olemassa tehtävän ja henkilön muodostamaa riviä, luodaan sellainen
                if (count($taskrows) <= 0) {
                    $sql = "INSERT INTO task_persons VALUES (?, ?);";
                    $statement = $pdo->prepare($sql);
                    $statement->bindParam(1, $_POST[$checkboxname], PDO::PARAM_INT);
                    $statement->bindParam(2, $task_id, PDO::PARAM_INT);
                    $statement->execute();
                }
            }
        }

        // Jos tehtävä on merkitty valmiiksi, asetetaan sille valmistumispäivä
        if (isset($_POST["finished"]) && $_POST["date_finished"]) {
            $sql = "UPDATE task
            SET date_finished = ?
            WHERE id = ?";
            $statement = $pdo->prepare($sql);
            $statement->bindParam(1, $_POST["date_finished"], PDO::PARAM_STR);
            $statement->bindParam(2, $task_id, PDO::PARAM_INT);
            $statement->execute();
        }
    } catch (PDOException $e) {
        throw $e;
    }
}

/** 
 * Lisää uuden tehtävän
 */
function addTask($task_name, $due_date, $project_id)
{
    require_once CONFIG_DIR . 'dbconn.php';
    require_once MODULES_DIR . 'projektit.php';
    require_once MODULES_DIR . 'tyypit.php';

    // Tarkistetaan, että arvot on asetettu
    if (!isset($task_name) || !isset($due_date) || !isset($project_id)) {
        throw new Exception("Et voi lisätä tyhjiä arvoja. Tehtävällä täytyy olla vähintään<ol>
        <li>nimi</li><li>deadline</li><li>projekti, johon tehtävä liittyy</li></ol>");
    }

    // Tarkistetaan, etteivät arvot ole tyhjiä
    if (empty($task_name) || empty($due_date) || empty($project_id)) {
        throw new Exception("Et voi lisätä tyhjiä arvoja. Tehtävällä täytyy olla vähintään
        <ol>
        <li>nimi</li><li>deadline</li><li>projekti, johon tehtävä liittyy</li></ol>");
    }

    // Lisätään uusi tehtävä kantaan
    try {
        $pdo = connectToDatabase();
        $pdo->beginTransaction();

        // Lisätään tehtävän nimi, deadline ja projekti
        $sql = "INSERT INTO task (task_name, due_date, project_id) VALUES (?, ?, ?);";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $task_name, PDO::PARAM_STR);
        $statement->bindParam(2, $due_date, PDO::PARAM_STR);
        $statement->bindParam(3, $project_id, PDO::PARAM_INT);
        $statement->execute();
        $task_id = $pdo->lastInsertId(); // task_id seuraavaan vaiheeseen

        // Tarkistetaan onko tehtävään liitetty henkilöitä
        // Haetaan kaikki henkilöt ja loopataan läpi
        $people = getPerson();
        foreach ($people as $person) {
            // Jos henkilö vastaava checkbox on checked, lisätään tehtävärivi task_persons-tauluun
            $checkboxname = "person" . $person["id"]; // loopilla lomakkeelle tuotetun checkboxin (templates/checkbox-henkilot.php) namea vastaavan muuttuja luominen
            if (isset($_POST[$checkboxname])) {
                $sql = "INSERT INTO task_persons (task_id, person_id) VALUES (?, ?);";
                $statement = $pdo->prepare($sql);
                $statement->bindParam(1, $task_id, PDO::PARAM_INT);
                $statement->bindParam(2, $person["id"], PDO::PARAM_INT);
                $statement->execute();
            }
        }

        $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        throw $e;
    }
}
