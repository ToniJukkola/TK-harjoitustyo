<?php
include_once(TEMPLATES_DIR . "head.php");
include_once(MODULES_DIR . "tehtavat.php");

$task_id = $_GET["id"];
$task = getSingleTask($task_id);
$showForm = $_GET["state"];
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
    <!-- <div>
      <label for="project">Projekti:</label>
      <select name="project">
        <option value="">Vaihtoehto</option>
        <option value="">Vaihtoehto</option>
        <option value="">Vaihtoehto</option>
      </select>
    </div>
    <div>
      <label for="task_persons">Tyypit:</label>
    </div> -->
    <input type="submit" value="Hyväksy muutokset">
  </form>

  <?php } ?>

  <?php
  $task_name = filter_input(INPUT_POST, "task_name");
  $due_date = filter_input(INPUT_POST, "due_date");
  
  if (isset($task_name) && isset($due_date)) {
  
    try {
      editTask($task_id, $task_name, $due_date);
      echo ("Success!");
      echo '
          <div style="margin-top: 2em;">
            <a href="tehtavat.php"><button>Takaisin tehtävälistaukseen</button></a>
          </div>';
    } catch (Exception $pdoex) {
      echo '<div class="alert">' . $pdoex->getMessage() . '</div>';
    }
  }
  ?>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>