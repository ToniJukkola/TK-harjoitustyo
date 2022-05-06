<?php 
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tyypit.php");

if (isset($_GET["person_id"])) {
    $person_id = $_GET["person_id"];
    $person = getOnePerson($person_id);
    }
?>
<main>

<h2>Henkilön poistaminen</h2>

<?php
  // Tarkistetaan onko käyttäjä kirjautunut
  // Jos ei, ohjataan kirjautumaan
  /*if (!isset($_SESSION["username"])) {
    echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> lisätäksesi ja hallinnoidaksesi tehtäviä.</div>';
    // Jos kyllä, suoritetaan loppu koodi
  } else {*/

    if (!empty($person)) {
      if (isset($person_id)) {
        try {
          deletePerson($person_id);
          echo '<div class="alert alert-success">';
          echo "Poistettu henkilö #" . $person_id . " " . $person["username"];
          echo '</div>';
        } catch (Exception $pdoex) {
          echo '<div class="alert alert-fail">' . $pdoex->getMessage() . '</div>';
        }
      }
    } else {
      echo '<div class="alert alert-fail">Valitsemaasi henkilöä ei löydy tietokannasta.</div>';
    }
    
  /*}*/
  ?>
    <a href='tyypit.php'><- Takaisin</a>
</main>
<?php
include_once(TEMPLATES_DIR . "foot.php");
?>