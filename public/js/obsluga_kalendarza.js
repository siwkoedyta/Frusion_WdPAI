document.addEventListener('DOMContentLoaded', function () {
    var selectedDateInput = document.getElementById('selectedDate');

    if(!selectedDateInput.value) {
        const dateValue =  new Date().toISOString().split('T')[0];
        document.getElementById("selectedDate").value = dateValue;
    }


    // Dodajmy nasłuchiwanie na zmianę daty w polu input
    selectedDateInput.addEventListener('input', function () {
        // Automatyczne przesłanie formularza po zmianie daty
        document.getElementById('filterForm').submit();
    });
});