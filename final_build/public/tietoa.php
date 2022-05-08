<?php
include_once(TEMPLATES_DIR . "head.php");
?>

<main>

<h2>Tietoa työnjaosta</h2>

<table class="task-table" style="width:auto;">
        <thead>
            <th>Homma</th>
            <th>Päävastuussa</th>
            <th>Myötävaikuttaja(t)</th>
        </thead>
        <tbody>
          <tr>
            <td>Github-repon luonti</td>
            <td>Toni</td>
          </tr>
          <tr>
            <td>Tietokannan suunnittelu ja SQL-lauseet</td>
            <td>Tiina, Toni, Aleksi, Kasperi</td>
          </tr>
          <tr>
            <td>"Pohjatyö" (tietokantayhteys, setup.php jne.)</td>
            <td>Tiina</td>
          </tr>
          <tr>
            <td>Henkilöt: lue, lisää, poista, muokkaa</td>
            <td>Toni</td>
          </tr>
          <tr>
            <td>Projektit: lue, lisää, poista, muokkaa</td>
            <td>Kasperi</td>
          </tr>
          <tr>
            <td>Tehtävät: lue, lisää, poista, muokkaa</td>
            <td>Tiina</td>
          </tr>
          <tr>
            <td>Rekisteröityminen, kirjautuminen</td>
            <td>Aleksi</td>
          </tr>
          <tr>
            <td>Turha ja ylimääräinen CSS<br>(vaikka selaimen oletusmuotoilut olisi fine)</td>
            <td>Tiina<br>>: )</td>
            <td>Tärkeämpien hommien välttely</td>
          </tr>
        </tbody>
    </table>

</main>

<?php
include_once(TEMPLATES_DIR . "foot.php");
?>
