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
        <li>Jos tehtävään ei ole kiinnitetty henkilöitä -> muokkaussivu herjaa. 
            <ul><li>Tälle joko checkit tms. TAI pidetään sääntönä että tehtävällä on aina oltava vähintään yksi kiinnitetty tekijä</li></ul>
        </li>
        <li>Uuden tehtävän lisääminen</li>
    </ul>

</main>

<?php

include_once(TEMPLATES_DIR . "foot.php");
?>