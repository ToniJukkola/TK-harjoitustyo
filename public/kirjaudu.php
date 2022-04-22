<?php
include_once TEMPLATES_DIR.'head.php';
include_once MODULES_DIR.'account-control.php';

$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");
$formType = filter_input(INPUT_POST, "formType");
$firstName = filter_input(INPUT_POST, "firstName");
$lastName = filter_input(INPUT_POST, "lastName");

if(isset($_SESSION["username"])) {
    try {
        logout();
    } catch (Exception $e) {
        echo '<div class="alert alert-fail">'.$e->getMessage().'</div>';
    } 
}

if(!isset($_SESSION["username"]) && isset($username) && isset($formType)) {

    if ($formType == 0) {
        try {
            login($username, $password);
            header("Location: index.php");
        } catch (Exception $e) {
            echo '<div class="alert alert-fail">'.$e->getMessage().'</div>';
        }
    } else if ($formType == 1) {
        try {
            register($username, $password, $firstName, $lastName);
            login($username, $password);
            header("Location: index.php");
            exit;
        } catch (Exception $e) {
            echo '<div class="alert alert-fail">'.$e->getMessage().'</div>';
        }
    }
}

if(!isset($_SESSION["username"])) {
?>

<main>
    <form action="kirjaudu.php" method="post">
        <div>
            <input type="radio" name="formType" id="loginRadio" value="0" checked>
            <label for="loginRadio">Kirjaudu</label>
            <input type="radio" name="formType" id="registerRadio" value="1">
            <label for="registerRadio">Rekisteröidy</label>
            
        </div>
        <label for="username">Sähköposti: </label>
        <input id="username" name="username" type="text">
        <label for="password">Salasana: </label>
        <input id="password" name="password" type="password">
        <button type="submit">Kirjau-u</button>
        <div>Ei tunnuksii?</div>
        <div>
            <label for="regPasswordAgain">Salasana uudestaan :DDD </label>
            <input id="regPasswordAgain" type="password">
        </div>
        <div>
            <label for="firstName">Etunimi: </label>
            <input id="firstName" name="firstName" type="text">
        </div>
        <div>
            <label for="lastName">Sukuloimisnimi: </label>
            <input id="lastName" name="lastName" type="text">
        </div>
        <div>
            <button type="submit">Reggaroi</button>
        </div>
    </form>
</main>

<?php }
include_once TEMPLATES_DIR.'foot.php';
?>
