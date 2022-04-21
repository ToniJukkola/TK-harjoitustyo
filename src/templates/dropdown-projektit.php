<?php
function createProjectsDropdown($project_id = -1)
{
  require_once(MODULES_DIR . "projektit.php");

  $projects = getProjects();

  echo '<select name="project">';
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