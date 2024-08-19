// Get the form elements
const form = document.querySelector('form');
const username = document.getElementById('username');
const email = document.getElementById('email');
const rollno = document.getElementById('rollno');
const password = document.getElementById('password');
const faculty = document.getElementById('faculty');

// Listen for form submission
form.addEventListener('submit', e => {
    // Prevent form submission
    e.preventDefault();

    // Validate form fields
    if (validateForm()) {
        // Form is valid, submit the form
        form.submit();
    }
});

// Validate the form fields
function validateForm() {
    // Check if the username is empty
    if (username.value.trim() === '') {
        alert('Please enter a username');
        return false;
    }

    // Check if the email is valid
    if (!validateEmail(email.value)) {
        alert('Please enter a valid email address');
        return false;
    }

    // Check if the roll number is a number
    if (isNaN(rollno.value)) {
        alert('Please enter a valid roll number');
        return false;
    }

    // Check if the password is at least 8 characters long
    if (password.value.length < 8) {
        alert('Please enter a password that is at least 8 characters long');
        return false;
    }

    // Check if the faculty is selected
    if (faculty.value === '') {
        alert('Please select a faculty');
        return false;
    }

    // Form is valid, return true
    return true;
}

// Validate the email address
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}