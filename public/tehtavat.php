<?php
include_once(TEMPLATES_DIR . "head.php");
include_once(TEMPLATES_DIR . "tehtavarivit-tauluun.php");
?>

<main>

<h2>Tehtävälista</h2>

    <table>
        <thead>
            <th>Tehtävä</th>
            <th>Deadline</th>
            <th>Projekti</th>
            <th>Tyypit</th>
            <th>Hallitse</th>
        </thead>
        <tbody>
            <?php
            createTaskRows();
            ?>
        </tbody>
    </table>

</main>

<?php

include_once(TEMPLATES_DIR . "foot.php");
?>