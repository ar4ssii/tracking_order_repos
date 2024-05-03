<?php
// API URL
$apiUrl = 'http://localhost/tracking_order/config/ralfh_api.php';

// Fetch data from the API
$data = file_get_contents($apiUrl);

// Check if data was fetched successfully
if ($data === false) {
    // Handle error
    echo "Failed to fetch data from the API.";
} else {
    // Convert JSON data to PHP array
    $dataArray = json_decode($data, true);

    // Check if JSON decoding was successful
    if ($dataArray === null) {
        // Handle JSON decoding error
        echo "Failed to decode JSON data.";
    } else {
        // Data fetched successfully, process it
        // var_dump($dataArray); // Display the data
    }
}
?>
