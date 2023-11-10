// Pobierz bieżącą datę i przekształć ją na format yyyy-MM-dd
const today = new Date();
const year = today.getFullYear();
const month = (today.getMonth() + 1).toString().padStart(2, "0");
const day = today.getDate().toString().padStart(2, "0");
const currentDate = `${year}-${month}-${day}`;

// Ustaw wartość pola daty na bieżącą datę
const selectedDateInput = document.getElementById("selectedDate");
selectedDateInput.value = currentDate;