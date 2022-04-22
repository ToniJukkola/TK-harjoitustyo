<?php
include_once(TEMPLATES_DIR . "head.php");
include_once(TEMPLATES_DIR . "tehtavarivit-tauluun.php");
?>

<main>

<h2>Tehtävälista</h2>

    <table class="task-table">
        <thead>
            <th>Tehtävä</th>
            <th>Deadline</th>
            <th>Projekti</th>
            <th>Henkilöt</th>
            <th>Hallitse</th>
        </thead>
        <tbody>
            <?php
            createTaskRows();
            ?>
        </tbody>
    </table>

    <h3>To do</h3>
    <ul>
        <li>Validoinnit, checkit, virheilmoitukset</li>
        <li>Uuden tehtävän lisääminen</li>
        <li>EXTRA: date_finished päivittäminen, jos on jo kerran asetettu?</li>
        <li>Priority_level: näytetäänkö, muokataanko, jätetäänkö pos kokonaan?</li>
    </ul>

</main>

<?php

include_once(TEMPLATES_DIR . "foot.php");
?>