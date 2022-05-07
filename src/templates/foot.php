<footer>&copy; Tiina Pelimanni, Toni Jukkola, Aleksi Viitanen, Kasperi Vaarala 2022</footer>

<?php
// Haetaan url
$url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
// Jos url sisältää 'tehtava-muokkaa', lisätään sivulle js-linkitys
if (strpos($url,'tehtava-muokkaa') !== false) {
  echo '<script src="./js/tasks.js"></script>';
}
?>
</body>

</html>