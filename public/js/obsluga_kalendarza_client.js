document.getElementById('searchClient').addEventListener('click', function() {
    const searchForm = document.getElementById('panel_klienta');

    searchForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const dateInput = document.getElementById('dateInput');
        const searchDate = dateInput.value;

        console.log(searchDate);

        fetch('/clientTransactions', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ type: 'searchByDate', search: searchDate }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .catch(error => console.error('Error during fetch:', error));
    });
});