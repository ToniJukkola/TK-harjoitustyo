<?php
function createPeopleDropdown($person_id = -1)
{
  require_once(MODULES_DIR . "tyypit.php");

  $people = getPerson();

  echo '<select name="person">';
  foreach ($people as $person) {
    echo '<option value="' 
    . $person["id"] 
    . '"' 
    . ($person["id"] == $person_id ? ' selected' : '') . '>' 
    . $person["firstname"] . ' ' . $person["lastname"]
    . '</option>';
  }
  echo '</select>';
}