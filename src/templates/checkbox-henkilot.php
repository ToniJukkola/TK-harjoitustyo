<?php
function createPeopleCheckboxList($taskpeople)
{
  require_once(MODULES_DIR . "tyypit.php");

  // Haetaan tyyppit taulukkoon
  $people = getPerson();

  // Tulostetaan lista 
  echo '<ul>';
  // Loopataan tyyppitaulukon läpi
  foreach ($people as $person) {
    // Loopataan tehtävään kiinnitettyjen tyyppien läpi
    // -> jos kiinnitetty id mätsää tyyppiin, asetetaan tyyppi kiinnitetyksi
    foreach ($taskpeople as $taskperson) {
      if ($taskperson["id"] == $person["id"]) {
        $assigned = true;
        break;
      } else {
        $assigned = false;
      }
    }
    echo '<li>'
      . '<input style="margin-right: .5em;" type="checkbox" name="person' . $person["id"] . '"' 
      . ' value="' . $person["id"] . '"' 
      . (isset($assigned) ? ($assigned == $person["id"] ? ' checked' : '') : '') // jos kiinnitetty tehtävään, checkbox = checked
      . '>'
      . '<label for="person' . $person["id"] . '">' . $person["firstname"] . ' ' . $person["lastname"] . '</label>'
      . '</li>';
  }
  echo '</ul>';
}
