document.addEventListener("DOMContentLoaded", function() {
    // Elementy formularza modalnego
    const modal = document.getElementById("myModal");
    const buyFruitBtn = document.getElementById("buy_fruit");
    const addBtn = document.querySelector(".przycisk_add");

    // Elementy formularza
    const usernameInput = document.getElementById("username");
    const fruitSelect = document.getElementById("fruit");
    const weightInput = document.getElementById("weight");
    const boxSelect = document.getElementById("box");
    const numOfBoxesInput = document.getElementById("Number of boxes");

    // Obsługa przycisku "Buy fruit"
    buyFruitBtn.addEventListener("click", function() {
        // Otwarcie okna modalnego
        modal.style.display = "flex";
        // Wyczyszczenie pól formularza
        clearFormFields();
    });

    // Obsługa przycisku "Add"
    addBtn.addEventListener("click", function() {
        // Tutaj możesz dodać logikę obsługi przycisku "Add"
        // Po dodaniu danych zamknij okno modalne
        modal.style.display = "none";
    });

    // Funkcja do czyszczenia pól formularza
    function clearFormFields() {
        usernameInput.value = "";
        fruitSelect.value = "";
        weightInput.value = "";
        boxSelect.value = "";
        numOfBoxesInput.value = "";
    }

    // Funkcja do zamykania okna modalnego
    function closeModal() {
        modal.style.display = "none";
    }

    // Obsługa przycisku "Cancel"
    const cancelBtn = document.querySelector(".przycisk_cancel");
    cancelBtn.addEventListener("click", closeModal);

    // Obsługa kliknięcia poza oknem modalnym
    window.addEventListener("click", function(event) {
        if (event.target === modal) {
            closeModal();
        }
    });
});
