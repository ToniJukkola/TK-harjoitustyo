<?php
include_once(TEMPLATES_DIR . "head.php");
include_once(MODULES_DIR . "tehtavat.php");
?>

<main>

    <table class="task-table">
        <thead>
            <th>Tehtävä</th>
            <th>Deadline</th>
            <th>Projekti</h>
        </thead>
        <tbody>
            <?php
            $tasks = getTasks();
            foreach ($tasks as $task) {
                echo '<tr>';
                echo '<td>' . $task["task_name"] . '</td>';
                echo '<td>' . $task["due_date"] . '</td>';
                echo '<td>' . $task["project_name"] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>