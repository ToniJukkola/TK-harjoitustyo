<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SETUP -> Ryhmätyömanageri</title>
  <link rel="icon" href="../../public/images/favicon-setup.png" type="image/png">
</head>
<body>
<?php
require_once("dbconn.php");
require_once("sql-variables.php");

try {
  // Yhdistää localhostiin
  $pdo = connectToLocalhost();

  // Luo tietokannan
  $sql = "DROP DATABASE IF EXISTS todo; CREATE DATABASE todo;";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  // Yhdistää juuri luotuun
  $pdo = connectToDatabase();

  // Taulukko sql-lauseille
  $queries = array();

  // Työnnetään sql-variables.php:n sql-lauseet taulukkoon
  array_push($queries, $tablesSQL);
  array_push($queries, $dummydata);

  // Execute queries
  foreach ($queries as $query) {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
  }

  echo "Tietokanta palautettu aloitusdatatilaan.";
} catch (PDOException $pdoex) {
  throw $pdoex;
  echo $pdoex;
}
?>

</body>
</html>