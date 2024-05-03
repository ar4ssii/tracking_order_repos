<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
include 'dbcon.php';

$sql = "SELECT ti.*, ts.Status, pl.PostName AS PostLocationName, IFNULL(dp.PostName, 'N/A') AS DestinationPostName
        FROM `tbl_trackinginformation` ti
        INNER JOIN `tbl_trackingstatus` ts ON ti.`TrackingStatusID` = ts.`TrackingStatusID`
        INNER JOIN `tbl_postlocations` pl ON ti.`PostLocationID` = pl.`postLocationID`
        LEFT JOIN `tbl_postlocations` dp ON ti.`DestinationPostID` = dp.`postLocationID`";

$result = $conn->query($sql);
$trackingInformations = [];
while ($row = $result->fetch_assoc()) {
    $trackingInfo = [
        "TrackingID" => $row['TrackingID'],
        "TrackingNumber" => $row['TrackingNumber'],
        "OrderID" => $row['OrderID'],
        "PostLocationID" => $row['PostLocationID'],
        "PostLocationName" => $row['PostLocationName'], // Add PostLocationName
        "DestinationPostID" => $row['DestinationPostID'],
        "DestinationPostName" => $row['DestinationPostName'], // Add DestinationPostName
        "InitialDate" => $row['InitialDate'],
        "trackingStatus" => [
            "Status" => $row['Status']
        ]
    ];
    $trackingInformations[] = ["trackingInfo" => $trackingInfo];
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($trackingInformations);
}
?>
