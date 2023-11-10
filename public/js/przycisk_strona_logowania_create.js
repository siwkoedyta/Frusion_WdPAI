document.addEventListener("DOMContentLoaded", function () {
  const przycisk = document.getElementById("przycisk_create");
  
  if (przycisk) {
    przycisk.addEventListener("click", function (event) {
      event.preventDefault(); // Zapobiegnij domyślnej akcji przycisku
      window.location.href = "panel_logowania";
    

    });
  }
});


