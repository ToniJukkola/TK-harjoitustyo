<?php
include_once TEMPLATES_DIR.'head.php';
include_once MODULES_DIR.'projektit.php';
?>

<main>

<h2>Lisää projekti </h2>

<?php

if (!isset($_SESSION["username"])) {
    echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> että voit lisäillä projekteja:)</div>';

} else {
   // $id = filter_input(INPUT_POST, "id");
    $project_name = filter_input(INPUT_POST, "project_name"); 

    if (isset($project_name)){
        
        try{
            addProject( $project_name);
            echo '<div class="alert alert-success">';
            echo 'Projekti lisätty!';
            echo '</div>';
     } catch (Exception $pdoex) {
        echo '<div class="alert alert-fail">' . $pdoex->getMessage() . '</div>';
    }
}

?>
 <form class="form-task" action="projektit-uusi.php" method="post">
      <div>
        <label for="project_name">Projektin nimi</label>
        <input type="text" name="project_name">
      </div>
      <input type="submit" value="Lisää uusi projekti">
    </form>
    <?php } ?>
</main>
<?php
include_once(TEMPLATES_DIR . "foot.php");
?>