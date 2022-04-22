<?php

/**
 * Luo rivit tehtävätaulukkoon
 * $filter = suodatusperuste
 * $order = järjestysperuste
 */
function createTaskRows($filter = NULL, $order = NULL)
{
  require_once(MODULES_DIR . "tehtavat.php");

  // Haetaan tehtävät tietokannasta
  $tasks = getTasks();

  if ($order == "deadline") {
    // Järjestetään tehtävät deadlinen mukaan
    usort($tasks, fn ($a, $b) => strtotime($a["due_date"]) - strtotime($b["due_date"]));
  }

  if ($filter == "finished") {
    // Filtteröidään näkyviin vain valmistuneet tehtävät
    $tasks = array_filter($tasks, fn ($task) => !is_null($task["date_finished"]));
  }

  if ($filter == "not_finished") {
    // Filtteröidään näkyviin vain keskeneräiset tehtävät
    $tasks = array_filter($tasks, fn ($task) => is_null($task["date_finished"]));
  }

  // Loopataan järjestetyn tehtävälistan läpi ja luodaan taulurivit
  foreach ($tasks as $task) {
    $assignees = getTaskPeople($task["task_id"]);
    echo '<tr>';
    echo '<td>' . $task["task_name"] . '</td>';
    echo '<td>' . $task["due_date_local"] . '</td>';
    echo '<td>' . $task["project_name"] . '</td>';
    echo '<td><ul>';
    foreach ($assignees as $assignee) {
      echo '<li>' . $assignee["firstname"] . ' ' . $assignee["lastname"][0] . '.</li>';
    }
    echo '</ul></td>';
    if (!isset($_SESSION["username"])) {
      echo '<td class="task-edit" style="color: rgba(0,0,0,.4);font-size:.9em;">';
      echo '<em>Vain kirjautuneille</em>';
    } else {
      echo '<td class="task-edit">';
      echo '<form action="tehtava-muokkaa.php?id=' . $task["task_id"] . '&state=edit" method="post">
    <input type="submit" name="submit" value="Muokkaa">
    </form>
    <form action="tehtava-poista.php?id=' . $task["task_id"] . '" method="post">
    <input type="submit" name="submit" value="Poista">
    </form>';
    }
    echo '</td></tr>';
  }
}
