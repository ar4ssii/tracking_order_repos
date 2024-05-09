<?php
session_start(); // Include necessary files and initialize session
include '..\..\admin\config\dbcon.php';


// Check if the form is submitted
if (isset($_POST['btn_place_order'])) {
    $hiddenCustomerId = $_POST['hiddenCustomerId'];
    $customer_address = $_SESSION['user_info']['address'];
    $customer_name = $_SESSION['user_info']['name'];
    $order_date = $_POST['order_date'];
    $order_amount = $_POST['order_amount'];

    // Get the cart items from the session
    $cart = $_SESSION['cart'];

    // // Insert customer information into the customers table
    // $sql_customer = "INSERT INTO customers (name, contact_information, address) VALUES (?, ?, ?)";
    // $stmt_customer = $conn->prepare($sql_customer);
    // $stmt_customer->bind_param("sss", $customer_name, $contact_number, $customer_address);
    // $stmt_customer->execute();

    // // Get the newly inserted customer ID
    // $customer_id = $stmt_customer->insert_id;

    // Insert order details into the orders table
    $sql_order = "INSERT INTO orders (customer_id, order_date,delivery_address) VALUES (?, ?, ?)";
    $stmt_order = $conn->prepare($sql_order);
    $stmt_order->bind_param("iss", $hiddenCustomerId, $order_date, $customer_address);
    $stmt_order->execute();

    // Get the newly inserted order ID
    $order_id = $stmt_order->insert_id;


    foreach ($cart as $product_id => $quantity) {
        // Fetch product details from the database based on $product_id
        $product_details = getProductDetailsById($product_id, $conn);
        $product_price = $product_details['price'];

        // Decrement the stock count of the product in the database
        $updated_stock = $product_details['quantity_in_stock'] - $quantity;

        // Update the stock count in the products table
        $sql_update_stock = "UPDATE product SET quantity_in_stock = ? WHERE product_id = ?";
        $stmt_update_stock = $conn->prepare($sql_update_stock);
        $stmt_update_stock->bind_param("ii", $updated_stock, $product_id);
        $stmt_update_stock->execute();

        // Insert order item details into the order_items table
        $sql_order_item = "INSERT INTO order_item (order_id, product_id, quantity_ordered, price_at_order_time) VALUES (?, ?, ?, ?)";
        $stmt_order_item = $conn->prepare($sql_order_item);
        $stmt_order_item->bind_param("iiii", $order_id, $product_id, $quantity, $product_price);
        $stmt_order_item->execute();
    }


    // Set session variables for alert
    if ($stmt_order) {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-success";
        $_SESSION['AlertMsg'] = "Placing order success!";

        date_default_timezone_set('Asia/Manila');
        // Generate tracking number and other data
        $TrackingNumber =  'TN' . date('md') . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        $TrackingStatusID = 1;
        $PostLocationID = 1;
        $InitialDate = date('Y-m-d H:i:s');

        // Insert tracking information
        $sql_EnableTracking = "INSERT INTO tbl_trackinginformation (TrackingNumber, OrderID, TrackingStatusID, PostLocationID, InitialDate) 
                                VALUES ('$TrackingNumber', $order_id, $TrackingStatusID, $PostLocationID, '$InitialDate')";
        $result = $conn->query($sql_EnableTracking);
        if ($result === true) {
            $_SESSION['ActivateAlert'] = true;
            $_SESSION['AlertColor'] = "alert-success";
            $_SESSION['AlertMsg'] = "Placing order success!";
        } else {
            $_SESSION['ActivateAlert'] = true;
            $_SESSION['AlertColor'] = "alert-danger";
            $_SESSION['AlertMsg'] = "Failed to place order.";
        }


        // Insert data into the payment_method table
        $sql_payment_method = "INSERT INTO payment_method (name, order_id, Amount,transaction_fee, Type) VALUES (?,?, ?,?, ?)";
        $stmt_payment_method = $conn->prepare($sql_payment_method);

        // Assuming you have a placeholder for the amount and type, you can set them to NULL initially
        $transaction_fee = $_POST['transaction_fee']; // Set this to the appropriate amount if you have it
        $type = $_POST['PaymentType']; // Set this to the appropriate type

        $stmt_payment_method->bind_param("sidds", $customer_name, $order_id, $order_amount,$transaction_fee, $type);
        $stmt_payment_method->execute();

        // Check if the payment method insertion was successful
        if ($stmt_payment_method) {
            // Payment method inserted successfully
            // You can add additional logic here if needed
        } else {
            // Payment method insertion failed
            // You can handle this situation accordingly
        }
    } else {
        $_SESSION['ActivateAlert'] = true;
        $_SESSION['AlertColor'] = "alert-danger";
        $_SESSION['AlertMsg'] = "Placing order failed";
    }
    // Clear the cart after processing the order
    unset($_SESSION['cart']);

    // Redirect to a success page or perform any other actions
    header("Location: ../transaction.php");
    exit();
}

// Function to get product details by ID
function getProductDetailsById($product_id, $conn)
{
    // Prepare and execute a query to fetch product details from the database based on the provided product_id
    $sql = "SELECT * FROM product WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        // Fetch the product details as an associative array
        $product_details = $result->fetch_assoc();
        return $product_details;
    } else {
        // If no product found with the given ID, return null or handle the situation accordingly
        return null;
    }
}


// Close database connection
$conn->close();
