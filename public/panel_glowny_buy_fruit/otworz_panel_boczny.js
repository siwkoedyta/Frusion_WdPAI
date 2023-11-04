// Funkcja do otwierania sidebaru
function openSidebar() {
    document.getElementById("mySidebar").style.width = "250px";
}

// Funkcja do zamykania sidebaru
function closeSidebar() {
    document.getElementById("mySidebar").style.width = "0";
}

// Funkcja do przełączania sidebaru
function toggleSidebar() {
    var sidebar = document.getElementById("mySidebar");
    if (sidebar.style.width === "250px") {
        closeSidebar();
    } else {
        openSidebar();
    }
}