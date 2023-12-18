document.addEventListener("DOMContentLoaded", function() {
    // Nasłuchuj na zdarzenie kliknięcia przycisku "Add"
    document.getElementById("addFruitButton").addEventListener("click", function(event) {
        // Przerywaj domyślne zachowanie przycisku (przesłanie formularza)
        event.preventDefault();

        // Odczytaj dane z formularza
        let typeFruit = document.getElementById("type_fruit").value;

        fetch("/add_fruit_form", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                type_fruit: typeFruit
            }),
        })
            .then(response => response.json())
            .then(data => {
                // Przetwórz odpowiedź lub wykonaj odpowiednie działania po udanej operacji
                console.log(data);

                // Wyświetl komunikat na stronie
                document.getElementById("message").innerHTML = '<p>' + data.message + '</p>';

                // Przekieruj lub wyświetl odpowiednią wiadomość po dodaniu użytkownika
                if (data.status === 'success') {
                    console.log("The fruit has been successfully added.")

                } else {
                    // Handle error
                    console.error('Error:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});