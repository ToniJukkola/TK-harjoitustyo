<?php
function createProjectsDropdown($project_id = -1)
{
  require_once(MODULES_DIR . "tehtavat.php");
  require_once(MODULES_DIR . "projektit.php");

  $projects = getProjects();

  echo '<select name="project">';
  if ($project_id < 0) {
    echo '<option value=0>-- VALITSE PROJEKTI</option>';
  }
  foreach ($projects as $project) {
    echo '<option value="'
      . $project["id"]
      . '"'
      . ($project["id"] == $project_id ? ' selected' : '') . '>'
      . $project["project_name"]
      . '</option>';
  }
  echo '</select>';
}
