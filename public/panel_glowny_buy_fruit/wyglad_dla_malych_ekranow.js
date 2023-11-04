// Pobierz referencje do elementów HTML
const desktopContainer = document.getElementById('desktopContainer');
const mobileContainer = document.getElementById('mobileContainer');

// Funkcja do zmiany widoczności elementów w zależności od szerokości ekranu
function updateVisibility() {
    if (window.innerWidth > 500) {
        desktopContainer.style.display = 'block';
        mobileContainer.style.display = 'none';
    } else {
        desktopContainer.style.display = 'none';
        mobileContainer.style.display = 'block';
    }
}

// Wywołaj funkcję po załadowaniu strony
updateVisibility();

// Nasłuchuj zmiany szerokości ekranu i aktualizuj widoczność
window.addEventListener('resize', updateVisibility);
