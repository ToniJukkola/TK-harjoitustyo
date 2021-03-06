<?php
include_once(TEMPLATES_DIR . "head.php");
require_once(TEMPLATES_DIR . "taulurivi-tehtava.php");
require_once(TEMPLATES_DIR . "lista-tehtava.php");
?>

<main>

    <h2>Tehtävälista</h2>
    <?php
    if (!isset($_SESSION["username"])) {
        echo '<div class="alert"><a href="kirjaudu.php">Kirjaudu sisään</a> lisätäksesi ja hallinnoidaksesi tehtäviä.</div>';
    } else {
        echo '<div style="display: flex; justify-content: flex-end;">
        <a href="tehtava-uusi.php"><button>Lisää tehtävä</button></a>
    </div>';
    }
    ?>

    <h3>Keskeneräiset tehtävät</h3>

    <table class="task-table">
        <thead>
            <th>Tehtävä</th>
            <th>Deadline</th>
            <th>Projekti</th>
            <th>Henkilöt</th>
            <th class="task-edit">Hallitse</th>
        </thead>
        <tbody>
            <?php
            createTaskRows("not_finished", "deadline");
            ?>
        </tbody>
    </table>

    <h3>Valmistuneet tehtävät</h3>

    <?php
    createFinishedTaskList();
    ?>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>
