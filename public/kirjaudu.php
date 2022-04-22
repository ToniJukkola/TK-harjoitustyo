<?php
include_once TEMPLATES_DIR.'head.php';
include MODULES_DIR.'login.php';

$username = filter_input(INPUT_POST, "email");
$password = filter_input(INPUT_POST, "password");

if(!isset($_SESSION["username"]) && isset($username)) {

    try {
        login($username, $password);
        header("Location: index.php");
        exit;
    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
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
        </form>

        <form action="">
        <div>Ei tunnuksii?</div>
        <div>
            <label for="regPasswordAgain">Salasana uudestaan:DDD : </label><input id="regPasswordAgain" type="password">
        </div>
        <div>
            <label for="firstName">Etunimi: </label><input id="firstName" type="text">
        </div>
        <div>
            <label for="lastName">Sukuloimisnimi: </label><input id="lastName" type="text">
        </div>
        <div>
            <button>Reggaroi</button>
        </div>
    </form>
</main>

<?php }
include_once TEMPLATES_DIR.'foot.php';
?>