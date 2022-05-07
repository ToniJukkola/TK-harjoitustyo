<?php
include_once TEMPLATES_DIR.'head.php';
include_once MODULES_DIR.'projektit.php';

echo "<main>";

echo "<h2> PROJEKTIT </h2>";
$projects = getProjects();
echo "<ul>";
foreach($projects as $p){
    echo "<li>".$p["id"]." ".$p["project_name"]."</li>";
}
echo "</ul>";
echo "</main>";

include_once TEMPLATES_DIR.'foot.php';