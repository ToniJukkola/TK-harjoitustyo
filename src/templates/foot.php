<footer>&copy; Tiina Pelimanni, Toni Jukkola, Aleksi Viitanen, Kasperi Vaarala 2022</footer>

<?php
$url = $_SERVER['REQUEST_URI'];
if (str_contains($url, "tehtava")) {
  echo '<script src="../public/js/tasks.js"></script>';
}
?>
</body>

</html>