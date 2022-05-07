<?php
include_once TEMPLATES_DIR.'head.php';
include_once MODULES_DIR.'account-control.php';

$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$passwordCheck = filter_input(INPUT_POST, "passwordCheck");
$formType = filter_input(INPUT_POST, "formType");
$firstName = filter_input(INPUT_POST, "firstName");
$lastName = filter_input(INPUT_POST, "lastName");
$email = filter_input(INPUT_POST, "email");

if(!isset($_SESSION["username"])) {

    ?>
    <main>
    <?php

    if(isset($username) && isset($formType)) {

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $row = findUserByEmail($username);
            $username = $row["username"];
        }

        if ($formType == 0) {
            try {
                login($username, $password);
                header("Location: index.php");
                exit;
            } catch (Exception $e) {
                echo '<div class="alert alert-fail">'.$e->getMessage().'</div>';
            }
        } else if ($formType == 1 && $passwordCheck === $password) {
            try {
                register($username, $password, $firstName, $lastName, $email);
                login($username, $password);
                header("Location: index.php");
                exit;
            } catch (Exception $e) {
                echo '<div class="alert alert-fail">'.$e->getMessage().'</div>';
            }
        } else if($passwordCheck !== $password) {
            echo '<div class="alert alert-fail">Salasanat eivät täsmää</div>';
        }
    }

    ?>

        <form action="kirjaudu.php" method="post">
            <div>
                <input type="radio" name="formType" id="loginRadio" value="0" onclick="handler('0')" checked>
                <label for="loginRadio">Kirjaudu</label>
                <input type="radio" name="formType" id="registerRadio" value="1" onclick="handler('1')">
                <label for="registerRadio">Rekisteröidy</label>
                
            </div>
            <div>
                <label for="username">Käyttäjätunnus: </label>
                <input id="username" name="username" type="text">
            </div>
            <div>
                <label for="password">Salasana: </label>
                <input id="password" name="password" type="password">
            </div>
            <div>
                <button type="submit" class="register-toggle">Kirjaudu</button>
            </div>
            
            <div class="register-toggle hidden">
                <div>
                    <label for="passwordCheck">Salasana uudelleen: </label>
                    <input id="passwordCheck" name="passwordCheck" type="password">
                </div>
                <div>
                    <label for="email">Sähköposti: </label>
                    <input id="email" name="email" type="email">
                </div>
                <div>
                    <label for="firstName">Etunimi: </label>
                    <input id="firstName" name="firstName" type="text">
                </div>
                <div>
                    <label for="lastName">Sukunimi: </label>
                    <input id="lastName" name="lastName" type="text">
                </div>
                <div>
                    <button type="submit">Rekisteröidy</button>
                </div>
            </div>
        </form>
        <script src="./js/account.js"></script>
    </main>

    <?php 
} else {
    try {
        logout();
        header("Location: kirjaudu.php");
        exit;
    } catch (Exception $e) {
        echo '<div class="alert alert-fail">'.$e->getMessage().'</div>';
    } 
}

include_once TEMPLATES_DIR.'foot.php';
?>
