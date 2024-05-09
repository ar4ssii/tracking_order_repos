<script>
    // tracking button js --------------------------------------------------------------------------
    const trackButton = document.getElementById('trackButton');
    const trackAccordion = document.getElementById('trackAccordion');

    // Add click event listener to the button
    trackButton.addEventListener('click', function() {
        // Toggle the display property of the accordion body
        if (trackAccordion.style.display === 'block') {
            trackAccordion.style.display = 'none';
        } else {
            trackAccordion.style.display = 'block';
        }
    });

    // \\order button js --------------------------------------------------------------------------
    const orderButton = document.getElementById('orderButton');
    const orderAccordion = document.getElementById('orderAccordion');

    // Add click event listener to the button
    orderButton.addEventListener('click', function() {
        // Toggle the display property of the accordion body
        if (orderAccordion.style.display === 'block') {
            orderAccordion.style.display = 'none';
        } else {
            orderAccordion.style.display = 'block';
        }
    });

     // \\user button js --------------------------------------------------------------------------
     const userButton = document.getElementById('userButton');
    const userAccordion = document.getElementById('userAccordion');

    // Add click event listener to the button
    userButton.addEventListener('click', function() {
        // Toggle the display property of the accordion body
        if (userAccordion.style.display === 'block') {
            userAccordion.style.display = 'none';
        } else {
            userAccordion.style.display = 'block';
        }
    });
    
    // \\user button js --------------------------------------------------------------------------
    const financeButton = document.getElementById('financeButton');
    const financeAccordion = document.getElementById('financeAccordion');

    // Add click event listener to the button
    financeButton.addEventListener('click', function() {
        // Toggle the display property of the accordion body
        if (financeAccordion.style.display === 'block') {
            financeAccordion.style.display = 'none';
        } else {
            financeAccordion.style.display = 'block';
        }
    });
    
</script>
</body>

</html>