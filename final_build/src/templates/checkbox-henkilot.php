<?php
function createPeopleCheckboxList($taskpeople = NULL)
{
  require_once(MODULES_DIR . "tehtavat.php");

  // Haetaan tyyppit taulukkoon
  $people = getPeopleForTask();

  // Tulostetaan lista 
  echo '<ul>';
  // Loopataan tyyppitaulukon läpi
  foreach ($people as $person) {
    // Jos parametrina lähetetty tehtävään asetetut henkilöt
    if (isset($taskpeople)) {
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
