<?php
include_once TEMPLATES_DIR.'head.php';
require_once MODULES_DIR.'tyypit.php';
?>

<main>
    
    <?php
    // Get all people from database
    $person = getPerson();
    // Print person list
    echo "<ul><h2>Henkilöt</h2>";
    foreach($person as $p){
        echo "<li><h3>".$p["id"]." ".$p["firstname"]." ".$p["lastname"]."</h3></li>";
    }
        echo "</ul>";
    ?>
</main>

<?php
include_once("../src/templates/foot.php");
?>
