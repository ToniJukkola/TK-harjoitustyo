<?php
require_once("dbconn.php");
require_once("sql-variables.php");

try {
  // Connect to localhost
  $pdo = connectToLocalhost();

  // Create database
  $sql = "DROP DATABASE IF EXISTS todo2022; CREATE DATABASE todo2022;";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();

  // Connect to the newly created database
  $pdo = connectToDatabase();

  // Array for queries
  $queries = array();

  // Create tables
  array_push($queries, $tablesSQL);

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