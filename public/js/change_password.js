const form = document.querySelector("#change_password_form");
const currentPasswordInput = form.querySelector('input[name="current_password"]');
const newPasswordInput = form.querySelector('input[name="new_password"]');
const repeatNewPasswordInput = form.querySelector('input[name="repeat_new_password"]');


function arePasswordsSame(new_password, repeat_new_password) {
    return new_password === repeat_new_password;
}
function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function updateErrorMessage(message) {
    document.getElementById("message").innerText = message;
}

newPasswordInput.addEventListener('keyup', validatePassword);
repeatNewPasswordInput.addEventListener('keyup', validateNewPasswordMatch);
function validatePassword() {
    setTimeout(function () {
        const newPassword = newPasswordInput.value;
        const hasNumber = /\d/.test(newPassword);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(newPassword);
        const isValid = hasNumber && hasSpecialChar && newPassword.length >= 4;

        if (!isValid) {
            markValidation(newPasswordInput, false);
            updateErrorMessage('Password must have at least\n 1 number, 1 special character,\n 4 characters long.');
        } else {
            markValidation(newPasswordInput, true);
            updateErrorMessage('');
        }
    }, 1000);
}

function validateNewPasswordMatch() {
    setTimeout(function () {
        const newPassword = newPasswordInput.value;
        const currentPassword = currentPasswordInput.value;
        const condition = arePasswordsSame(repeatNewPasswordInput.value, newPassword);

        if (!condition) {
            markValidation(repeatNewPasswordInput, false);
            updateErrorMessage('The new passwords are not identical.');
        } else if (currentPassword === newPassword) {
            markValidation(repeatNewPasswordInput, false);
            updateErrorMessage('New password and current\n password are identical.');
        } else {
            markValidation(repeatNewPasswordInput, true);
            updateErrorMessage('');
        }
    }, 500);
}

function validateAllFields() {
    const fields = [currentPasswordInput, newPasswordInput, repeatNewPasswordInput];

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

    await Promise.all([validatePassword(), validateNewPasswordMatch()]);

    if (document.querySelectorAll('.no-valid').length === 0) {
        form.submit();
    }
});