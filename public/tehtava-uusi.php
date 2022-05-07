<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tehtavat.php");
require_once(TEMPLATES_DIR . "dropdown-projektit.php");
require_once(TEMPLATES_DIR . "checkbox-henkilot.php");
?>

<main>

  <h2>Lisää uusi tehtävä</h2>

  <?php

  // Tarkistetaan onko käyttäjä kirjautunut
  // Jos ei, ohjataan kirjautumaan
  if (!isset($_SESSION["username"])) {
    echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> lisätäksesi ja hallinnoidaksesi tehtäviä.</div>';
    // Jos kyllä, näytetään lomake
  } else {

    // Haetaan lomakkeen inputien arvot muuttujiin
    $task_name = filter_input(INPUT_POST, "task_name");
    $due_date = filter_input(INPUT_POST, "due_date");
    $project_id = filter_input(INPUT_POST, "project");

    // Jos arvot asetettu, kutsutaan muokkausfunktiota
    if (isset($task_name) && isset($due_date) && isset($project_id)) {

      try {
        addTask($task_name, $due_date, $project_id);
        echo '<div class="alert alert-success">';
        echo 'Lisätty tehtävä onnistuneesti!';
        echo '</div>';
      } catch (Exception $pdoex) {
        echo '<div class="alert alert-fail">' . $pdoex->getMessage() . '</div>';
      }
    }
  ?>

    <form class="form-task" action="tehtava-uusi.php" method="post">
      <div>
        <label for="task_name">Tehtävän nimi:</label>
        <input type="text" name="task_name">
      </div>
      <div>
        <label for="due_date">Deadline:</label>
        <input type="date" name="due_date">
      </div>
      <div>
        <label for="project">Projekti:</label>
        <?php createProjectsDropdown() ?>
      </div>
      <div>
        <label for="people">Henkilöt:</label>
        <?php createPeopleCheckboxList() ?>
      </div>
      <input type="submit" value="Lisää uusi tehtävä">
    </form>

  <?php } ?>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>