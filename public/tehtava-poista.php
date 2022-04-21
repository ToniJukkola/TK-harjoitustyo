<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tehtavat.php");

$task_id = $_GET["id"];
?>

<main>
  <div class="alert">
    <?php
    try {
      deleteTask($task_id);
      echo "Poistettu tehtävä #" . $task_id;
    } catch (PDOException $e) {
      throw $e;
    }
    ?>
  </div>

  <div style="margin-top: 2em;">
    <a href="tehtavat.php"><button>Takaisin tehtävälistaukseen</button></a>
  </div>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>