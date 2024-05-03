<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
include 'dbcon_db_order.php';

$sql = "SELECT o.OrderID, o.CustomerID, o.OrderDate,
        oi.OrderItemID, oi.ProductID, oi.Qty,
        p.ProductName, p.ProductPrice
        FROM tbl_order o
        JOIN tbl_orderitems oi ON o.OrderID = oi.OrderID
        JOIN tbl_products p ON oi.ProductID = p.ProductID";

$result = $conn->query($sql);


$OrderInformations = [];

while ($row = $result->fetch_assoc()) {
    $orderID = $row['OrderID'];
    
    // Check if the order already exists in the $OrderInformations array
    if (!isset($OrderInformations[$orderID])) {
        // If the order doesn't exist, create a new entry for it
        $orderInfo = [
            "OrderID" => $orderID,
            "CustomerID" => $row['CustomerID'],
            "OrderDate" => $row['OrderDate'],
            "OrderItems" => []
        ];
        $OrderInformations[$orderID] = ["orderInfo" => $orderInfo];
    }

    // Add the item to the OrderItems list of the corresponding order
    $OrderInformations[$orderID]["orderInfo"]["OrderItems"][] = [
        "OrderItemID" => $row['OrderItemID'],
        "ProductID" => $row['ProductID'],
        "ProductName" => $row['ProductName'],
        "Qty" => $row['Qty'],
        "ProductPrice" => $row['ProductPrice']
    ];
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($OrderInformations);
}
