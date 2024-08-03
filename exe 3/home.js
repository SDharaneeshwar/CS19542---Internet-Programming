// validation.js
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');

    form.addEventListener('submit', function(event) {
        // Get form elements
        const email = document.getElementById('email').value;
        const pin = document.getElementById('pin').value;
        let valid = true;

        // Email validation
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            valid = false;
        }

        // Pincode validation (assuming 6 digits for pincode)
        const pinPattern = /^\d{6}$/;
        if (!pinPattern.test(pin)) {
            alert('Please enter a valid pincode (6 digits).');
            valid = false;
        }

        // Prevent form submission if invalid
        if (!valid) {
            event.preventDefault();
        }
    });
});
