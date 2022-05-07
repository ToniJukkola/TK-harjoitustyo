<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SETUP -> Ryhmätyömanageri</title>
  <link rel="icon" href="../../public/images/favicon-setup.png" type="image/png">
  <style>
    body {
      margin: 1em;
    }

    div {
      margin-bottom: 1em;
      border: 1px solid;
      padding: 1em;
    }

    button {
      padding: 1em;
      font-size: 2rem;
      cursor: pointer;
    }

    .ok {
      border-color: green;
    }

    .fail {
      border-color: red;
    }
  </style>
</head>

<body>

  <a href="setup.php?setup=run"><button>Nollaa tietokanta</button></a>
  <?php
  if (isset($_GET["setup"]) && $_GET["setup"] == "run") {
    require_once("dbconn.php");
    require_once("sql-variables.php");

    // TIETOKANTA
    echo "<h3>Luodaan tietokanta</h3><br>";
    try {
      // Yhdistää localhostiin
      $pdo = connectToLocalhost();

      // Luo tietokannan
      $sql = "DROP DATABASE IF EXISTS todo; CREATE DATABASE todo;";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();
      echo "<div class='ok'>OK!</div>";
    } catch (PDOException $pdoex) {
      throw $pdoex;
      echo $pdoex;
    }

    // TAULUT
    echo "<h3>Luodaan taulut</h3><br>";
    try {
      // Yhdistää yllä luotuun tietokantaan
      $pdo = connectToDatabase();

      // Luodaan taulut kantaan
      $stmt = $pdo->prepare($tablesSQL);
      $stmt->execute();

      echo "<div class='ok'>OK!</div>";
    } catch (PDOException $pdoex) {
      throw $pdoex;
      echo $pdoex;
    }

    // TESTITYYPIT
    echo "<h3>Lisätään testityypit</h3><br>";
    try {
      $pdo = connectToDatabase();

      // Lisätään testityypit kantaan
      $sql = 'INSERT INTO person (username, email, firstname, lastname, password) VALUES 
    (?, ?, ?, ?, ?), (?, ?, ?, ?, ?), (?, ?, ?, ?, ?);';
      $statement = $pdo->prepare($sql);
      $statement->bindParam(1, $p1uname, PDO::PARAM_STR_CHAR);
      $statement->bindParam(2, $p1email, PDO::PARAM_STR);
      $statement->bindParam(3, $p1fname, PDO::PARAM_STR_CHAR);
      $statement->bindParam(4, $p1lname, PDO::PARAM_STR_CHAR);
      $hash_pw1 = password_hash($p1pw, PASSWORD_DEFAULT);
      $statement->bindParam(5, $hash_pw1);
      $statement->bindParam(6, $p2uname, PDO::PARAM_STR_CHAR);
      $statement->bindParam(7, $p2email, PDO::PARAM_STR);
      $statement->bindParam(8, $p2fname, PDO::PARAM_STR_CHAR);
      $statement->bindParam(9, $p2lname, PDO::PARAM_STR_CHAR);
      $hash_pw2 = password_hash($p2pw, PASSWORD_DEFAULT);
      $statement->bindParam(10, $hash_pw2);
      $statement->bindParam(11, $p3uname, PDO::PARAM_STR_CHAR);
      $statement->bindParam(12, $p3email, PDO::PARAM_STR);
      $statement->bindParam(13, $p3fname, PDO::PARAM_STR_CHAR);
      $statement->bindParam(14, $p3lname, PDO::PARAM_STR_CHAR);
      $hash_pw3 = password_hash($p3pw, PASSWORD_DEFAULT);
      $statement->bindParam(15, $hash_pw3);
      $statement->execute();

      echo "<div class='ok'>OK!</div>";
    } catch (PDOException $pdoex) {
      throw $pdoex;
    }

    // MUU ALOITUSDATA
    echo "<h3>Lisätään loppu aloitusdata</h3><br>";
    try {
      $pdo = connectToDatabase();
      $stmt = $pdo->prepare($dummydata);
      $stmt->execute();

      echo "<div class='ok'>OK!</div>";
    } catch (PDOException $pdoex) {
      throw $pdoex;
    }
  }

  ?>

</body>

</html>