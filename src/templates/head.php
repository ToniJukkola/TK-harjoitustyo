<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ryhmätyömanageri</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="icon" href="../public/images/favicon-public.png" type="image/png">
</head>

<body>
    <header>
        <h1>Ryhmätyömanageri</h1>
        <nav>
            <ul>
                <li><a href="index.php">Etusivu</a></li>
                <li><a href="tyypit.php">Henkilöt</a></li>
                <li><a href="projektit.php">Projektit</a></li>
                <li><a href="tehtavat.php">Tehtävät</a></li>
                <li><a href="tietoa.php">Tietoa</a></li>
                <?php
                if(!isset($_SESSION["username"])) {
                    echo '<li><a href="kirjaudu.php">Kirjaudu / rekisteröidy</a></li>';
                } else {
                    echo '<li>'.$_SESSION["firstname"] . ' ' . $_SESSION["lastname"] . ' ' . '(<a href="kirjaudu.php">Kirjaudu ulos</a>)</li>';
                }
                ?>
            </ul>
        </nav>
    </header>