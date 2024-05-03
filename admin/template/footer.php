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

    // progress bar --------------------------------------------------------------------------------------
    
</script>
</body>

</html>