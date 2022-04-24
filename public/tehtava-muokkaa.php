<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tehtavat.php");
require_once(TEMPLATES_DIR . "dropdown-projektit.php");
require_once(TEMPLATES_DIR . "checkbox-henkilot.php");

if (isset($_GET["state"])) {
  $showForm = $_GET["state"];
}
if (isset($_GET["id"])) {
  $task_id = $_GET["id"];
  $task = getSingleTask($task_id);
  $project_id = $task["project_id"];
  $taskpeople = getTaskPeople($task_id);
}
?>

<main>
  <?php
  if (!isset($_GET["id"])) {
    echo '<h2>Tehtävä #</h2><div class="alert alert-fail">Ei valittua tehtävää.</div>';
  } else {

  ?>
    <h2>Muokkaa tehtävää #<?php echo $task_id ?></h2>

    <?php
    // Tarkistetaan onko käyttäjä kirjautunut
    // Jos ei, ohjataan kirjautumaan
    if (!isset($_SESSION["username"])) {
      echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> lisätäksesi ja hallinnoidaksesi tehtäviä.</div>';
      // Jos kyllä, näytetään lomake
    } else {
      if (!isset($showForm) || $showForm != "result") { ?>

        <form class="form-task" action="tehtava-muokkaa.php?id=<?php echo $task_id ?>&state=result" method="post">
          <div>
            <label for="task_name">Tehtävän nimi:</label>
            <input type="text" name="task_name" value="<?php echo $task['task_name'] ?>">
          </div>
          <div>
            <label for="due_date">Deadline:</label>
            <input type="date" name="due_date" value="<?php echo $task['due_date'] ?>">
          </div>
          <div>
            <label for="project">Projekti:</label>
            <?php createProjectsDropdown($project_id) ?>
          </div>
          <div>
            <label for="people">Henkilöt:</label>
            <?php createPeopleCheckboxList($taskpeople) ?>
          </div>
          <div class="alert" style="margin-top: 0em;">
            <label for="finished">Valmis?</label>
            <?php
            echo '<input type="checkbox" name="finished"';
            if (!is_null($task["date_finished"])) {
              echo ' checked';
            }
            echo '>';
            ?>
            <div class="hidden" style="margin-top: .5em;" id="date-finished-container">
              <label for="date_finished">Valmistui:</label>
              <?php
              echo '<input type="date" name="date_finished" id="date-finished-input"';
              if (!is_null($task["date_finished"])) {
                echo ' value="' . $task["date_finished"] . '"';
              }
              echo '>';
              ?>
            </div>
          </div>
          <input type="submit" value="Hyväksy muutokset">
        </form>

      <?php } ?>

  <?php

      // Haetaan lomakkeen inputien arvot muuttujiin
      $task_name = filter_input(INPUT_POST, "task_name");
      $due_date = filter_input(INPUT_POST, "due_date");
      $project_id = filter_input(INPUT_POST, "project");

      // Tarkistetaan, että arvot on asetettu
      if (isset($task_name) && isset($due_date) && isset($project_id)) {

        try {
          $old_status = (is_null($task["date_finished"]) ? 'kesken' : 'valmis');
          editTask($task_id, $task_name, $due_date, $project_id);
          $new_data = getSingleTask($task_id);
          $new_status = (is_null($new_data["date_finished"]) ? 'kesken' : 'valmis');
          echo '<div class="alert alert-success">';
          echo 'Muokattu onnistuneesti tehtävää <strong>#' . $task_id . '</strong><br><br>';
          echo 'Tehtävän nimi: ' . $task["task_name"] . ' -> ' . $task_name;
          echo '<br>Deadline: ' .  $task["due_date"] . ' -> ' . $due_date;
          echo '<br>Tila: ' . $old_status . ' -> ' . $new_status;
          echo '</div>';
        } catch (Exception $pdoex) {
          $showForm = "";
          echo '<div class="alert alert-fail">Tehtävän <strong>#' . $task_id . '</strong> muokkaaminen epäonnistui.<br><br>' . $pdoex->getMessage() . '</div>';
          echo '
      <div style="margin-top: 2em;">
        <a href="tehtava-muokkaa.php?id=' . $task_id . '&state=edit"><button>Takaisin tehtävän #' . $task_id . ' muokkaukseen</button></a>
      </div>';
        }
      }
    }
  }
  ?>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>