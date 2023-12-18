const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const passwordInput = form.querySelector('input[name="password"]');
const confirmedPasswordInput = form.querySelector('input[name="repeat_password"]');
const frusionNameInput = form.querySelector('input[name="frusion_name"]');
const phoneNumberInput = form.querySelector('input[name="mobile"]');
var prefixAdded = false;

function isEmail(email) {
    return /\S+@\S+\.\S+/.test(email);
}

function arePasswordsSame(password, repeat_password) {
    return password === repeat_password;
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function updateErrorMessage(message) {
    document.getElementById("message").innerText = message;
}

emailInput.addEventListener('keyup', validateEmail);
passwordInput.addEventListener('keyup', validatePasswordRequirements);
confirmedPasswordInput.addEventListener('keyup', validatePasswordMatch);
phoneNumberInput.addEventListener('input', formatPhoneNumber);
phoneNumberInput.addEventListener('keyup', validatePhoneNumberLength);
frusionNameInput.addEventListener('keyup', validateFrusionName);

function validateEmail() {
    setTimeout(function () {
        const isValidEmail = isEmail(emailInput.value);

        markValidation(emailInput, isValidEmail);

        if (!isValidEmail) {
            updateErrorMessage('The email address has an incorrect format.');
        } else {
            updateErrorMessage('');
        }
    }, 500);
}

function validatePasswordRequirements() {
    setTimeout(function () {
        const password = passwordInput.value;
        const isValidLength = password.length >= 4;
        const hasNumber = /\d/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        if (!isValidLength || !hasNumber || !hasSpecialChar) {
            markValidation(passwordInput, false);
            updateErrorMessage('Min 4 characters, a number, and a special character.');
        } else {
            markValidation(passwordInput, true);
            updateErrorMessage('');
        }
    }, 1000);
}

function validatePasswordMatch() {
    setTimeout(function () {
        const password = passwordInput.value;
        const condition = arePasswordsSame(confirmedPasswordInput.value, password);

        if (!condition) {
            markValidation(confirmedPasswordInput, false);
            updateErrorMessage('The passwords are not identical.');
        } else {
            markValidation(confirmedPasswordInput, true);
            updateErrorMessage('');
        }
    }, 500);
}

function formatPhoneNumber() {
    var phoneNumberValue = phoneNumberInput.value.replace(/[^0-9]/g, '');

    if (phoneNumberValue.length === 0) {
        phoneNumberInput.value = '';
        prefixAdded = false;
        return;
    }

    if (!prefixAdded) {
        phoneNumberValue = phoneNumberValue.substring(0, 9);
        phoneNumberInput.value = '+48' + phoneNumberValue;
        prefixAdded = true;
    } else {
        phoneNumberValue = phoneNumberValue.substring(0, 9);
        phoneNumberInput.value = phoneNumberValue;
    }

    var formattedPhoneNumber = '';

    for (var i = 0; i < phoneNumberValue.length; i++) {
        formattedPhoneNumber += phoneNumberValue[i];
        if ((i + 1) % 3 === 0 && i + 1 < phoneNumberValue.length) {
            formattedPhoneNumber += '-';
        }
    }
    phoneNumberInput.value = formattedPhoneNumber;
}

function validatePhoneNumberLength() {
    setTimeout(function () {
        var phoneNumberValue = phoneNumberInput.value.replace(/[^0-9]/g, '');

        if (phoneNumberValue.length !== 9) {
            markValidation(phoneNumberInput, false);
            updateErrorMessage('Numer telefonu musi zawierać dokładnie 9 cyfr.');
        } else {
            markValidation(phoneNumberInput, true);
            updateErrorMessage('');
        }
    }, 2000);
}

function validateFrusionName() {
    setTimeout(function () {
        const frusionNameInput = form.querySelector('input[name="frusion_name"]');
        const frusionName = frusionNameInput.value.trim();

        if (frusionName.length < 1) {
            markValidation(frusionNameInput, false);
            updateErrorMessage('Frusion name must have at least 1 character.');
        } else {
            markValidation(frusionNameInput, true);
            updateErrorMessage('');
        }
    }, 1000);
}

function validateAllFields() {
    const fields = [emailInput, passwordInput, confirmedPasswordInput, phoneNumberInput, frusionNameInput];

    for (const field of fields) {
        if (!field.value.trim()) {
            markValidation(field, false);
            updateErrorMessage('All fields must be filled.');
            return false;
        } else {
            markValidation(field, true);
            updateErrorMessage('');
        }
    }

    return true;
}

form.addEventListener("submit", async function (e) {
    e.preventDefault();

    if (!validateAllFields()) {
        return;
    }

    await Promise.all([validateEmail(), validatePasswordRequirements(), validatePasswordMatch(), validateFrusionName()]);

    if (document.querySelectorAll('.no-valid').length === 0) {
        form.submit();
    }
});
