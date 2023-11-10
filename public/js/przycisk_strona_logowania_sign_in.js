document.addEventListener("DOMContentLoaded", function () {
    const przycisk = document.getElementById("przycisk_sign_in");
    
    if (przycisk) {
      przycisk.addEventListener("click", function (event) {
        event.preventDefault(); // Zapobiegnij domyślnej akcji przycisku
        window.location.href = "../panel_logowania/panel_logowania.html";
      });
    }
});