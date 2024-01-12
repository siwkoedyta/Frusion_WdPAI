document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filterForm');
    const startDateInput = document.getElementById('selectedDateStarting');
    const endDateInput = document.getElementById('selectedDateEnd');
    const datesSelectedInput = document.getElementById('datesSelected');

    // Function to check if both dates are selected
    function checkDatesSelected() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        if (startDate && endDate) {
            if (new Date(startDate) > new Date(endDate)) {
                alert("Starting date cannot be later than End date!");
                startDateInput.value = '';  // Clear the starting date input
                datesSelectedInput.value = '0';
            } else {
                datesSelectedInput.value = '1';
            }
        } else {
            datesSelectedInput.value = '0';
        }
    }

    function submitForm() {
        checkDatesSelected();

        if (datesSelectedInput.value === '1') {
            filterForm.submit();
        }
    }

    startDateInput.addEventListener('change', submitForm);
    endDateInput.addEventListener('change', submitForm);
});