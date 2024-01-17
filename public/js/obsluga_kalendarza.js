document.addEventListener('DOMContentLoaded', function () {
    var selectedDateInput = document.getElementById('selectedDate');
    var displayDate = document.getElementById('displayDate');

    // Sprawdź, czy w localStorage jest już zapisana data
    var storedDate = localStorage.getItem('selectedDate');

    if (storedDate) {
        selectedDateInput.value = storedDate;
        displayDate.textContent = storedDate;
    }

    // Dodajmy nasłuchiwanie na zmianę daty w polu input
    selectedDateInput.addEventListener('input', function () {
        // Ustaw wartość w localStorage
        localStorage.setItem('selectedDate', selectedDateInput.value);

        // Ustaw wartość w elemencie wyświetlającym datę
        displayDate.textContent = selectedDateInput.value;

        // Automatyczne przesłanie formularza po zmianie daty
        document.getElementById('filterForm').submit();
    });

    console.log(storedDate);
});