document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("changePasswordButton").addEventListener("click", function(event) {
        event.preventDefault();

        let currentPassword = document.getElementById("current_password").value;
        let newPassword = document.getElementById("new_password").value;
        let repeatNewPassword = document.getElementById("repeat_new_password").value;

        // Dodaj walidację, czy nowe hasło i powtórzone nowe hasło są identyczne

        // Wywołaj odpowiednią akcję, na przykład, wysłanie żądania do "/change_password"
        fetch("/change_password_form", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                current_password: currentPassword,
                new_password: newPassword,
                repeat_new_password: repeatNewPassword
            }),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Wyświetl komunikat na stronie
                document.getElementById("message").innerHTML = '<p>' + data.message + '</p>';

                if (data.status === 'success') {
                    // Wyczyszczenie pól formularza po udanej operacji
                    document.getElementById("changePasswordForm").reset();
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
