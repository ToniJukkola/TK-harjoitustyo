<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(MODULES_DIR . "tyypit.php");
?>

<main>

  <h2>Lisää uusi henkilö</h2>

  <?php

  // Tarkistetaan onko käyttäjä kirjautunut
  // Jos ei, ohjataan kirjautumaan
  //if (!isset($_SESSION["username"])) {
   // echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> lisätäksesi ja hallinnoidaksesi tehtäviä.</div>';
    // Jos kyllä, näytetään lomake
  //} else {

    // Haetaan lomakkeen inputien arvot muuttujiin
    $username = filter_input(INPUT_POST, "username");
    $email = filter_input(INPUT_POST, "email");
    $firstname = filter_input(INPUT_POST, "firstname");
    $lastname = filter_input(INPUT_POST, "lastname");

    // Jos arvot asetettu, kutsutaan muokkausfunktiota
    if (isset($username) && ($email) && isset($firstname) && isset($lastname)) {

      try {
        addPerson($username, $email, $firstname, $lastname);
        echo '<div class="alert alert-success">';
        echo 'Henkilö lisätty!';
        echo '</div>';
      } catch (Exception $pdoex) {
        echo '<div class="alert alert-fail">' . $pdoex->getMessage() . '</div>';
      }
    }
  ?>

    <form class="form-task" action="tyypit-uusi.php" method="post">
      <div>
        <label for="username">Käyttäjänimi:</label>
        <input type="text" name="username">
      </div>
      <div>
        <label for="email">Sähköposti:</label>
        <input type="text" name="email">
      </div>
      <div>
        <label for="firstname">Etunimi:</label>
        <input type="text" name="firstname">
      </div>
      <div>
        <label for="lastname">Sukunimi:</label>
        <input type="text" name="lastname">
      </div>
      <input type="submit" value="Lisää uusi henkilö">
    </form>

  <?php /*}*/ ?>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>