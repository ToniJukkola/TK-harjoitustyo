<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tehtavat.php");

$task_id = $_GET["id"];
$task = getSingleTask($task_id);
?>

<main>

  <?php
  if (isset($task_id)) {
    try {
      deleteTask($task_id);
      echo '<div class="alert alert-success">';
      echo "Poistettu tehtävä #" . $task_id . " " . $task["task_name"];
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