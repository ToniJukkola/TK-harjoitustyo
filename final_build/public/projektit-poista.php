<?php
include_once TEMPLATES_DIR.'head.php';
include_once MODULES_DIR.'projektit.php';

if (isset($_GET["id"])){
    $project_id = $_GET["id"];
    $project = getSingleProject($project_id);
}
?>

<main>
<h2>Poista projekti</h2>
<?php
if (!isset($_SESSION["username"])) {
    echo '<div class="alert alert-fail"><a href="kirjaudu.php">Kirjaudu sisään</a> että voit poistaa projekteja</div>';
}else{
    if (!empty($project)) {
        if (isset($project_id)) {
          try {
            deleteProject($project_id);
            echo '<div class="alert alert-success">';
            echo "Poistettu projekti #" . $project_id;
            echo '</div>';
          } catch (Exception $pdoex) {
            echo '<div class="alert alert-fail">' . $pdoex->getMessage() . '</div>';
          }
        }
       } else {
        echo '<div class="alert alert-fail">Valitsemaasi projektia ei löydy tietokannasta.</div>';
      }   
}
?>
</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>