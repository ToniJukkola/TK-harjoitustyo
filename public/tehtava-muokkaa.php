<?php
include_once(TEMPLATES_DIR . "head.php");
include_once(MODULES_DIR . "tehtavat.php");
include_once(TEMPLATES_DIR . "dropdown-projektit.php");
include_once(TEMPLATES_DIR . "checkbox-henkilot.php");

$task_id = $_GET["id"];
$task = getSingleTask($task_id);
$project_id = $task["project_id"];
$showForm = $_GET["state"];
$taskpeople = getTaskPeople($task_id);
?>

<main>

  <?php if ($showForm != "success") { ?>

    <h2>Muokkaa tehtävää #<?php echo $task_id ?></h2>

    <form class="form-task" action="tehtava-muokkaa.php?id=<?php echo $task_id ?>&state=success" method="post">
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
        <input type="checkbox" name="finished">
        <div class="hidden" style="margin-top: .5em;" id="date-finished-container">
          <label for="date_finished">Valmistui:</label>
          <input type="date" name="date_finished" id="date-finished-input">
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

  // Jos arvot asetettu, kutsutaan muokkausfunktiota
  if (isset($task_name) && isset($due_date) && isset($project_id)) {

    try {
      editTask($task_id, $task_name, $due_date, $project_id);
      echo '<div class="alert alert-success">';
      echo "Muokattu onnistuneesti tehtävää <strong>#" . $task_id . '</strong>';
      echo '</div>';
    } catch (Exception $pdoex) {
      echo '<div class="alert alert-fail">' . $pdoex->getMessage() . '</div>';
    }
  }
  ?>

  <div style="margin-top: 2em;">
    <a href="tehtavat.php"><button>Takaisin tehtävälistaukseen</button></a>
  </div>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>