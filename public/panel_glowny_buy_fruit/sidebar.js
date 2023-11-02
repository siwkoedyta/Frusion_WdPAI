// Pobieranie wszystkich linków w bocznym pasku nawigacji
const sidebarLinks = document.querySelectorAll('.menu li a');

// Dodawanie obsługi zdarzeń dla każdego linka
sidebarLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        // Przerwij domyślną nawigację (przeładowanie strony)
        e.preventDefault();

        // Usuń klasę .active z aktualnego aktywnego elementu
        document.querySelector('.menu li.active')?.classList.remove('active');

        // Dodaj klasę .active do klikniętego elementu
        link.parentElement.classList.add('active');

        // Pobierz URL z atrybutu 'href' klikniętego linka
        const targetURL = link.getAttribute('href');

        // Przejdź do wybranego pliku HTML
        window.location.href = targetURL;
    });
});
