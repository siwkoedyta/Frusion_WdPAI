// document.addEventListener("DOMContentLoaded", function() {
//     // Listen for the click event on the "Remove" button
//     document.getElementById("removeFruitButton").addEventListener("click", function(event) {
//         // Prevent the default behavior (e.g., form submission)
//         event.preventDefault();
//
//         // Read data from the form or perform any necessary actions
//         let selectedFruit = document.getElementById("type_fruit_to_remove").value;  // Updated key here
//
//         fetch("/remove_fruit_form", {
//             method: "POST", // Assuming you handle removal using a POST request
//             headers: {
//                 "Content-Type": "application/x-www-form-urlencoded",
//             },
//             body: JSON.stringify({
//                 type_fruit: selectedFruit,  // Updated key here
//             }),
//         })
//             .then(response => response.json())
//             .then(data => {
//                 // Process the response or take appropriate actions after a successful operation
//                 console.log(data);
//
//                 // Display a message on the page
//                 document.getElementById("message").innerHTML = '<p>' + data.message + '</p>';
//
//                 // Redirect or display a message after removing the fruit
//                 if (data.status === 'success') {
//                     console.log("The fruit has been successfully removed.");
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