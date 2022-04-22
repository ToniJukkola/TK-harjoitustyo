// --- tehtava-muokkaa.php
const DATE_FINISHED_CONTAINER = document.getElementById("date-finished-container");
const DATE_FINISHED_INPUT = document.getElementById("date-finished-input");
const FINISHED_CHECKBOX = document.querySelector('[name="finished"]');

// Jos sivulta löytyvät ao. elementit, asetetaan tapahtumakuuntelija
if (DATE_FINISHED_CONTAINER && DATE_FINISHED_INPUT && FINISHED_CHECKBOX) {
  // Toggletaan date_finished näkyviin tai pois riippuen siitä onko checkbox valittuna vai ei
  FINISHED_CHECKBOX.addEventListener("change", () => {
    DATE_FINISHED_CONTAINER.classList.toggle("hidden");

    // Asetetaan date_finishedille oletusarvoksi tämän hetken päivä
    if (FINISHED_CHECKBOX.checked == true) {
      DATE_FINISHED_INPUT.valueAsDate = new Date();
    } else {
      DATE_FINISHED_INPUT.value = "";
    }
  })
}