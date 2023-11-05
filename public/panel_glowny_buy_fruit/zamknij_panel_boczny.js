document.addEventListener("DOMContentLoaded", function() {
    const hamburgerButton = document.getElementById("hamburgerL");
    const sidebar = document.getElementById("mySidebar");
    const overlay = document.getElementById("overlay");
    const closeSidebarButton = document.getElementById("closeSidebar"); // Nowy przycisk "x"
  
    if (hamburgerButton && sidebar && overlay && closeSidebarButton) {
      hamburgerButton.addEventListener("click", function() {
        sidebar.classList.add("active");
        overlay.classList.add("active");
      });
  
      closeSidebarButton.addEventListener("click", function() {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
      });
    }
  });