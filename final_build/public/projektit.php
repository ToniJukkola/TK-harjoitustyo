<?php
include_once TEMPLATES_DIR.'head.php';
include_once MODULES_DIR.'projektit.php';

echo "<main>";

echo "<h2> PROJEKTIT </h2>";
$projects = getProjects();
echo "<ul>";
foreach($projects as $p){
    echo "<li>".$p["id"]." ".$p["project_name"].
    "<a href='projektit-poista.php?id=".$p["id"]."'>Poista</a></li>";
}
echo "</ul>";

if (!isset($_SESSION["username"])) {
    echo '<div><a href="kirjaudu.php">Kirjaudu sisään</a></div>';
} else {
    echo '<div>
    <a href="projektit-uusi.php"><button>Lisää projekti</button></a>
</div>';
echo "</main>";


}

include_once TEMPLATES_DIR.'foot.php';