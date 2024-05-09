document.addEventListener('DOMContentLoaded', function () {
    // Get references to the birthdate and age input fields
    const birthdateInput = document.getElementById('birthdate');
    const ageInput = document.getElementById('age');

    // Add event listener to the birthdate input field
    birthdateInput.addEventListener('input', function () {
        // Get the selected birthdate
        const birthdate = new Date(this.value);

        // Calculate the age based on the birthdate
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }

        // Update the age input field with the calculated age
        ageInput.value = age.toString(); // Convert age to string before assigning
    });
});
