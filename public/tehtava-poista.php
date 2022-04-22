<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tehtavat.php");

if (isset($_GET["id"])) {
$task_id = $_GET["id"];
$task = getSingleTask($task_id);
}
?>

<main>

<h2>Tehtävän poisto</h2>
  <?php
  // Tarkistetaan onko käyttäjä kirjautunut
  // Jos ei, ohjataan kirjautumaan
  if (!isset($_SESSION["username"])) {
    echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> lisätäksesi ja hallinnoidaksesi tehtäviä.</div>';
    // Jos kyllä, suoritetaan loppu koodi
  } else {

    if (!empty($task)) {
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
    } else {
      echo '<div class="alert alert-fail">Valitsemaasi tehtävää ei löydy tietokannasta.</div>';
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