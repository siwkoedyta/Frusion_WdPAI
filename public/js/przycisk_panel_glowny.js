document.addEventListener("DOMContentLoaded", function () {
    const przycisk = document.getElementById("przycisk_redirect");
    
    if (przycisk) {
      przycisk.addEventListener("click", function (event) {
        event.preventDefault(); // Zapobiegnij domyślnej akcji przycisku
        window.location.href = "/src/views/panel_glowny.html";

      });
    }
});