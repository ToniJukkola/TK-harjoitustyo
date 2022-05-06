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

echo "<thead><th>ID</th><th>Käyttäjänimi</th><th>Sähköposti</th><th>Etunimi</th><th>Sukunimi</th><th>Muokkaa/Poista</th></thead>";
foreach($person as $p){
    echo "<tbody><tr><td>".$p["id"]." </td><td>".$p["username"]." </td><td>".$p["email"]." </td><td>".$p["firstname"]." </td><td>".$p["lastname"];
    echo " </td><td><a href='tyypit-poista.php'>Poista</a><button>Muokkaa</button></td></tr></tbody>";
}
    echo "</table>";
    echo "<br><a href='tyypit-uusi.php'>Lisää Tyyppi</a></br>";
?>
</main>

<?php
include_once("../src/templates/foot.php");
?>
