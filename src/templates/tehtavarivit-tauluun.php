<?php
function createTaskRows()
{
  require_once(MODULES_DIR . "tehtavat.php");

  $tasks = getTasks();
  
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
    echo '<td class="task-edit">
    <form action="tehtava-muokkaa.php?id=' . $task["task_id"] . '&state=edit" method="post">
    <input type="submit" name="submit" value="Muokkaa">
    </form>
    <form action="tehtava-poista.php?id=' . $task["task_id"] . '" method="post">
    <input type="submit" name="submit" value="Poista">
    </form></td>';
    echo '</tr>';
  }
}
