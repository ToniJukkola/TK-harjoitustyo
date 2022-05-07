// --- tehtava-muokkaa.php elementit vakioihin
const DATE_FINISHED_CONTAINER = document.getElementById("date-finished-container");
const DATE_FINISHED_INPUT = document.getElementById("date-finished-input");
const FINISHED_CHECKBOX = document.querySelector('[name="finished"]');

if (FINISHED_CHECKBOX) {
  // Tarkistetaan checkboxin arvo
  if (FINISHED_CHECKBOX.checked == true) {
    DATE_FINISHED_CONTAINER.classList.remove("hidden");
  }

  // Toggletaan date_finished näkyviin tai pois riippuen siitä onko checkbox valittuna vai ei
  FINISHED_CHECKBOX.addEventListener("change", () => {
    DATE_FINISHED_CONTAINER.classList.toggle("hidden");
    // Jos checkbox on valittu ja valmistumisaikaa ei ole asetettu, asetetaan oletusajaksi nykyinen päivä. Jos checbox ei valittu, tyhjennetään valmistusmispäivän arvo
    if (FINISHED_CHECKBOX.checked && DATE_FINISHED_INPUT.value == "") {
      DATE_FINISHED_INPUT.valueAsDate = new Date();
    } else {
      DATE_FINISHED_INPUT.value = "";
    }
  })
}