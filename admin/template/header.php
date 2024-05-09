<?php
session_start();
include 'config/dbcon.php';
if (isset($_SESSION['auth']) && $_SESSION['user_info']['role'] == 4) {
    header("Location: ..\index.php");
    exit();
}
if (!isset($_SESSION['auth'])) {
    header("Location: ..\index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

    <!-- bootstrap 5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- icons -->
    <script src="https://kit.fontawesome.com/1a87f9db42.js" crossorigin="anonymous"></script>

    <!-- custom css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<?php
// Execute query to count occurrences of each status
$sql_countStatus = "SELECT ts.Status, COUNT(*) AS count FROM tbl_trackinginformation tti
                            INNER JOIN tbl_trackingstatus ts ON tti.TrackingStatusID = ts.TrackingStatusID
                            GROUP BY ts.Status";
$result_countStatus = mysqli_query($conn, $sql_countStatus);

// Associative array to store counts of each status
$statusCounts = array();

// Populate status counts array
if (mysqli_num_rows($result_countStatus) > 0) {
    while ($row = mysqli_fetch_assoc($result_countStatus)) {
        $statusCounts[$row['Status']] = $row['count'];
    }
}
// Function to get count of a status from the status counts array
function getStatusCount($status)
{
    global $statusCounts;
    return isset($statusCounts[$status]) ? $statusCounts[$status] : 0;
}
?>

<body>