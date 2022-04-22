<?php

/**
 * Luo rivit valmistuneiden tehtävien listaan
 */
function createFinishedTaskList()
{
  require_once(MODULES_DIR . "tehtavat.php");

  // Haetaan tehtävät tietokannasta
  $tasks = getTasks();

  // Filtteröidään näkyviin vain valmistuneet tehtävät
  $tasks = array_filter($tasks, fn ($task) => !is_null($task["date_finished"]));

  // Järjestetään tehtävät valmistumispäivän mukaan
  usort($tasks, fn ($a, $b) => strtotime($b["date_finished"]) - strtotime($a["date_finished"]));

  // Loopataan järjestetyn tehtävälistan läpi ja luodaan listarivit
  foreach ($tasks as $task) {
    $assignees = getTaskPeople($task["task_id"]);
    echo '<li>';
    echo $task["date_finished_local"] . ' ' . $task["task_name"];
    echo ' (' . $task["project_name"] . ')';
    if (count($assignees) > 0) {
    echo '<br>– tekijät: ';
      foreach ($assignees as $assignee) {
        echo ' <span>' . $assignee["firstname"] . ' ' . $assignee["lastname"][0] . '.</span>';
        if (end($assignees)["id"] != $assignee["id"] && count($assignees) > 1) {
          echo ', ';
        }
      }
    }
    echo '</li>';
  }
}
