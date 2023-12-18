const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const passwordInput = form.querySelector('input[name="password"]');
const confirmedPasswordInput = form.querySelector('input[name="repeat_password"]');
const phoneNumberInput = form.querySelector('input[name="mobile"]');
var prefixAdded = false; // Dodajemy prefiks tylko raz

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}
function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword;
}

//w momencie gdy ściągniemy przycisk z klawiatury to będzie walidować nasze pole
function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid')
}
function validateEmail() {
    setTimeout(function () {
        const isValidEmail = isEmail(emailInput.value);

        markValidation(emailInput, isValidEmail);

        // Dodaj warunek sprawdzający, czy e-mail ma poprawny format
        if (!isValidEmail) {
            document.getElementById("emailFormatMessage").innerText = 'The email address has an incorrect format.';
        } else {
            document.getElementById("emailFormatMessage").innerText = ''; // Wyczyść komunikat
        }
    }, 500);
}
emailInput.addEventListener('keyup', validateEmail);

function validatePasswordRequirements() {
    const password = passwordInput.value;
    const isValidLength = password.length >= 4;
    const hasNumber = /\d/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

    // Dodaj warunek sprawdzający wymagania dla hasła
    if (!isValidLength || !hasNumber || !hasSpecialChar) {
        markValidation(passwordInput, false);

        let errorMessage = '';

        if (!isValidLength || !hasNumber || !hasSpecialChar) {
            errorMessage = 'Min 4 characters, a number, and a special character.';
        }

        document.getElementById("passwordFormatMessage").innerText = errorMessage;
    } else {
        markValidation(passwordInput, true);
        document.getElementById("passwordFormatMessage").innerText = ''; // Wyczyść komunikat o formacie hasła
    }
}

function validatePasswordMatch() {
    setTimeout(function () {
        const password = passwordInput.value;
        const condition = arePasswordsSame(confirmedPasswordInput.value, password);

        if (!condition) {
            markValidation(confirmedPasswordInput, false);
            document.getElementById("passwordMismatchMessage").innerText = 'The passwords are not identical.';
        } else {
            markValidation(confirmedPasswordInput, true);
            document.getElementById("passwordMismatchMessage").innerText = ''; // Wyczyść komunikat o niezgodności haseł
        }
    }, 500);
}

passwordInput.addEventListener('keyup', validatePasswordRequirements);
confirmedPasswordInput.addEventListener('keyup', validatePasswordMatch);
form.addEventListener("submit", e => {
    e.preventDefault();
    //TODO check again if form is valid after submitting it
});

phoneNumberInput.addEventListener('input', function () {
    formatPhoneNumber();
});

function formatPhoneNumber() {
    var phoneNumberValue = phoneNumberInput.value.replace(/[^0-9]/g, ''); // Usunięcie niecyfrowych znaków

    if (phoneNumberValue.length === 0) {
        phoneNumberInput.value = ''; // Pozostawienie pola pustego, gdy brak cyfr
        prefixAdded = false; // Resetowanie flagi, aby prefiks mógł być dodany ponownie
        return;
    }

    if (!prefixAdded) {
        phoneNumberValue = phoneNumberValue.substring(0, 9); // Ograniczenie do 9 cyfr
        phoneNumberInput.value = '+48' + phoneNumberValue;
        prefixAdded = true; // Ustawienie flagi, aby prefiks nie był dodawany ponownie
    } else {
        phoneNumberValue = phoneNumberValue.substring(0, 9); // Ograniczenie do 9 cyfr
        phoneNumberInput.value = phoneNumberValue;
    }

    // Dodanie znaku "-" co trzy cyfry
    var formattedPhoneNumber = '';

    for (var i = 0; i < phoneNumberValue.length; i++) {
        formattedPhoneNumber += phoneNumberValue[i];
        if ((i + 1) % 3 === 0 && i + 1 < phoneNumberValue.length) {
            formattedPhoneNumber += '-';
        }
    }
    phoneNumberInput.value = formattedPhoneNumber; // Ustawienie sformatowanego numeru w polu input
}

