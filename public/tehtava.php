<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tehtavat.php");
?>

<main>

  <?php
  if (!isset($_GET["id"])) {
    echo '<h2>Tehtävä #</h2><div class="alert alert-fail">Ei valittua tehtävää.</div>';
  } else {
    $task_id = $_GET["id"];
    $task = getSingleTask($task_id);

  ?>
    <h2>Tehtävä #<?php echo $task["task_id"] . ' ' . $task["task_name"]; ?></h2>

    <table class="task-table" style="width:auto;">

      <tbody>
        <tr>
          <th>Tehtävän nimi</th>
          <td><?php echo $task["task_name"]; ?></td>
        </tr>
        <tr>
          <th>Deadline</th>
          <td><?php echo $task["due_date_local"]; ?></td>
        </tr>
        <tr>
          <th>Projekti</th>
          <td><?php echo $task["project_name"]; ?></td>
        </tr>
        <tr>
          <th>Henkilöt</th>
          <td>
            <?php
            $assignees = getTaskPeople($task["task_id"]);
            if (count($assignees) > 0) {
              echo '<ul>';
              foreach ($assignees as $assignee) {
                echo '<li>' . $assignee["firstname"] . ' ' . $assignee["lastname"] . '</li>';
              }
              echo '</ul>';
            } else {
              echo '–';
            }
            ?>
          </td>
        </tr>
        <tr>
          <th>Valmistunut</th>
          <td><?php echo ($task["date_finished"] != NULL ? $task["date_finished_local"] : '<span style="color:brown;">Kesken</span>'); ?></td>
        </tr>
        <tr>
          <td colspan="2" style="border:0;"></td>
        </tr>
        <tr>
          <th>Lisätty</th>
          <td><?php echo $task["date_created_local"]; ?></td>
        </tr>
        <tr>
          <th>Lisääjä</th>
          <td><?php echo $task["creator_firstname"] . " " . $task["creator_lastname"]; ?></td>
        </tr>
      </tbody>
    </table>

    
    <?php
    if (isset($_SESSION["username"])) { ?>

      <div style="display: flex; gap: 1em; margin-top: 2em;">
        <form action="tehtava-muokkaa.php?id=<?php echo $task["task_id"]; ?>&state=edit" method="post">
          <input type="submit" name="submit" value="Muokkaa">
        </form>
        <form action="tehtava-poista.php?id=<?php echo $task["task_id"]; ?>" method="post">
          <input type="submit" name="submit" value="Poista">
        </form>
      </div>

    <?php } else {
      echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> muokataksesi tehtävää.</div>';
    }
    ?>

  <?php } ?>
</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>