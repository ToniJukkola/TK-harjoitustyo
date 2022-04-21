<?php
include_once TEMPLATES_DIR.'head.php';
require_once MODULES_DIR.'tyypit.php';
?>

<main>
<?php
// Get all people from database
$person = getPerson();
// Print person list
echo "<table>";
echo "<h2>Henkilöt</h2>";
echo "<thead><th>ID</th><th>Käyttäjänimi</th><th>Etunimi</th><th>Sukunimi</th><th>Muokkaa/Poista</th></thead>";
foreach($person as $p){
    echo "<tbody><tr><td>".$p["id"]." </td><td>".$p["username"]." </td><td>".$p["firstname"]." </td><td>".$p["lastname"]."</td><td><button>Poista</button><button>Muokkaa</button></td></tr></tbody>";
}
    echo "</table>";
?>
</main>

<?php
include_once("../src/templates/foot.php");
?>
