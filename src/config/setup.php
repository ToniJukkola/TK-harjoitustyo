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