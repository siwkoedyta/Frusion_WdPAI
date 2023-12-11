document.addEventListener("DOMContentLoaded", function() {
    // Nasłuchuj na zdarzenie kliknięcia przycisku "Add"
    document.getElementById("addUserButton").addEventListener("click", function(event) {
        // Przerywaj domyślne zachowanie przycisku (przesłanie formularza)
        event.preventDefault();

        // Odczytaj dane z formularza
        let name = document.getElementById("name").value;
        let lastName = document.getElementById("last_name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;

        // Wywołaj odpowiednią akcję, na przykład, wysłanie żądania do "/add_client_form"
        fetch("/add_client_form", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                name: name,
                last_name: lastName,
                email: email,
                password: password
            }),
        })
            .then(response => response.json())
            .then(data => {
                // Przetwórz odpowiedź lub wykonaj odpowiednie działania po udanej operacji
                console.log(data);

                // Przekieruj lub wyświetl odpowiednią wiadomość po dodaniu użytkownika
                if (data.status === 'success') {
                    document.getElementById("addUserForm").reset();
                    console.log("User został prawidłowo dodany.")
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