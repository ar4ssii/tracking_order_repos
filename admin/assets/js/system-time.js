// Function to update system time
function updateSystemTime() {
    var systemTimeElement = document.getElementById('system-time');
    var now = new Date();
    var timeNow = { hour: 'numeric', minute: 'numeric', second: 'numeric'};
    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    var formattedTime = now.toLocaleTimeString('en-US', timeNow);
    var formattedDate = now.toLocaleDateString('en-US', options);
    
    // Set time and date in separate elements
    systemTimeElement.innerHTML = '<h1 style="margin-bottom:-20px;">' + formattedTime + '</h1><br>' + formattedDate;
}

// Update system time every second
setInterval(updateSystemTime, 1000);

// Initial call to update system time
updateSystemTime();
