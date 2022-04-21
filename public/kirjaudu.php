<?php
include_once("../src/templates/head.php")




?>

<main>
    <form action="">
        <label for="loginUName">Käyttäjätunnus: </label><input id="loginUName" type="text">
        <label for="loginPassword">Salasana: </label><input id="loginPassword" type="text">
        <button>Kirjau-u</button>
        
    </form>

    <form>
        Ei tunnuksii?
        <div>
            <label for="regUName">Käyttäjätunnus: </label><input id="regUName" type="text">
        </div>
        <div>
            <label for="regPassword">Salasana: </label><input id="regPassword" type="text">
        </div>
        <div>
            <label for="regPasswordAgain">Salasana uudestaan:DDD : </label><input id="regPasswordAgain" type="text">
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

<?php
include_once("../src/templates/foot.php")
?>