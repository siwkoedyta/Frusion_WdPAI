// document.addEventListener("DOMContentLoaded", function() {
//     // Nasłuchuj na zdarzenie kliknięcia przycisku "Add"
//     document.getElementById("addBoxButton").addEventListener("click", function(event) {
//         // Przerywaj domyślne zachowanie przycisku (przesłanie formularza)
//         event.preventDefault();
//
//         // Odczytaj dane z formularza
//         let boxName = document.getElementById("box_name").value;
//         let boxWeight = document.getElementById("box_weight").value;
//
//         fetch("/add_boxes_form", {
//             method: "POST",
//             headers: {
//                 "Content-Type": "application/x-www-form-urlencoded",
//             },
//             body: new URLSearchParams({
//                 box_name: boxName,
//                 box_weight: boxWeight
//             }),
//         })
//             .then(response => response.json())
//             .then(data => {
//                 // Przetwórz odpowiedź lub wykonaj odpowiednie działania po udanej operacji
//                 console.log(data);
//
//                 // Wyświetl komunikat na stronie
//                 document.getElementById("message").innerHTML = '<p>' + data.message + '</p>';
//
//                 // Przekieruj lub wyświetl odpowiednią wiadomość po dodaniu użytkownika
//                 if (data.status === 'success') {
//                     document.getElementById("addBoxForm").reset();
//                     console.log("The box has been successfully added.")
//                 } else {
//                     // Handle error
//                     console.error('Error:', data.message);
//                 }
//             })
//             .catch(error => {
//                 console.error('Error:', error);
//             });
//     });
// });