document.addEventListener("DOMContentLoaded", function() {
    const hamburgerButton = document.getElementById("hamburgerL");
    const sidebar = document.getElementById("mySidebar");
    const overlay = document.getElementById("overlay");
  
    if (hamburgerButton && sidebar && overlay) {
      hamburgerButton.addEventListener("click", function() {
        if (sidebar.classList.contains("active")) {
          sidebar.classList.remove("active");
          overlay.classList.remove("active");
        } else {
          sidebar.classList.add("active");
          overlay.classList.add("active");
        }
      });
    }
  });
  