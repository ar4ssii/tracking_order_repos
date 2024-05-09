<?php
include 'customer-template/header.php';
include 'customer-validation/customer-validation.php';
include 'customer-template/navbar.php';
?>


<div class="container-fluid py-5 bg-light">

    <h1 class="text-center">Ordering System - Client</h1>

    <?php
    date_default_timezone_set('Asia/Manila');
    $DateNow = date('Y-m-d H:i:s');
    $EstimatedApprovalDate = date('Y-m-d H:i:s', strtotime($DateNow . ' +1 days'));
    $EstimatedDeliveryDate = date('Y-m-d H:i:s', strtotime($DateNow . ' +4 days'));
    ?>

    <div class="container col-lg-12 col-sm-12">
        <form action="customer-config/process_order.php" method="post">
            <div class="container shadow bg-white p-3 mb-3 text-center">
                <h6>Schedules:</h6>
                <div class="row">
                    <div class="col">
                        <p class="text-muted mb-0">estimated approval date of order</p>
                        <p class="fw-bold pickup-date"><?= date('F j, Y', strtotime($EstimatedApprovalDate)) ?></p>

                    </div>
                    <div class="col">
                        <p class="text-muted mb-0">estimated delivery date of order</p>
                        <p class="fw-bold delivery-date"><?= date('F j, Y', strtotime($EstimatedDeliveryDate)) ?></p>
                    </div>
                </div>
            </div>

            <div class="accordion bg-white shadow p-3 mb-3" id="accordionExample">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            <span class="bg-info rounded-circle px-2 py-1 text-white fw-bold mx-1">1</span> Place Order
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php
                            //dbconn included

                            $sql_FetchProducts = "SELECT * FROM product";
                            $result = $conn->query($sql_FetchProducts);
                            if ($result->num_rows > 0) {
                                // Fetch all products into an array
                                $products = $result->fetch_all(MYSQLI_ASSOC);
                            ?>
                                <input type="text" name="search" class="form-control" placeholder="Search Product" id="search">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-width">
                                        <tbody id="productTable">
                                            <?php foreach ($products as $row) {
                                                $quantityAvailableAfterAddition = 0;
                                                if (!empty($_SESSION['cart']) && isset($_SESSION['cart'][$row['product_id']])) {
                                                    // Calculate quantity available after addition
                                                    $quantityAvailableAfterAddition = max(0, $row['quantity_in_stock'] - $_SESSION['cart'][$row['product_id']]);
                                                } else {
                                                    // If cart is empty or product not in cart, set default quantity available
                                                    $quantityAvailableAfterAddition = $row['quantity_in_stock'];
                                                }
                                            ?>
                                                <tr>
                                                    <td class="table-product text">
                                                        <p><?= $row['name'] ?> </p>
                                                        <p class="text-muted">x1</p>
                                                    </td>
                                                    <td>
                                                        <p><?= '₱ ' . $row['price'] ?> </p>

                                                    </td>
                                                    <td>
                                                        <?php if ($row['quantity_in_stock'] > 0) { ?>
                                                            <button class="btn btn-info add-to-cart-btn" data-quantity-in-stock="<?= $quantityAvailableAfterAddition ?>" data-product-id="<?= $row['product_id'] ?>">Add Product</button>
                                                        <?php } else { ?>
                                                            <button class="btn btn-info" disabled>Out of Stock</button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            } ?>

                            <!-- Placeholder for "No product found" message -->
                            <div id="noProductFound" style="display: none;">No product found.</div>
                        </div>
                        <?php include 'customer-config/getProductDetailsById.php'; ?>
                        <script src="customer-assets/js/search_product.js"></script>
                        <script src="customer-assets/js/add_to_cart.js"></script>

                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button bg-secondary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <span class="bg-info rounded-circle px-2 py-1 text-white fw-bold mx-1">2</span>Customer Information
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <?php if (isset($_SESSION['auth'])) { ?>
                                <label for="" class="text-capitalize">Customer's Name</label>
                                <input type="hidden" name="hiddenCustomerId" value="<?= $_SESSION['user_info']['id'];?>">
                                <input type="text" aria-label="Name" required name="customer_name" readonly value="<?= $_SESSION['user_info']['name'];?>" placeholder="Enter your full name" class="form-control">

                                <label for="" class="text-capitalize">Customer's Mobile Number</label>

                                <div class="input-group">
                                    <span class="input-group-text" id="contact-number">+63</span>
                                    <input type="text" class="form-control" readonly required aria-describedby="customer_contact_information" value="<?= $_SESSION['user_info']['contact_information'];?>" name="customer_contact_information">
                                </div>

                                <label for="" class="text-capitalize">customer address</label>
                                <input type="text" class="form-control" require name="customer_address" readonly value="<?= $_SESSION['user_info']['address'];?>" placeholder="Enter your address">
                                <p style="font-size: small; margin:0px;" class="text-center">Note: Your address will be the pick-up address</p>
                            <?php } ?>

                        </div>
                    </div>
                </div>



            </div>
            <div class="container shadow p-3 mb-3 bg-white">
                <p class="fw-bold text-uppercase">fees and breakdown<small></small></p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr class="fw-bold">
                                <td>#</td>
                                <td>Products</td>
                                <td>Qty</td>
                                <td>Price</td>
                                <td style="width: 250px;">Action</td>
                            </tr>

                            <?php
                            $order_amount = 0;
                            $transaction_fee = 0;
                            if (!empty($_SESSION['cart'])) {
                                $count = 1;
                                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                    // Fetch product details from the database based on $product_id
                                    // Replace this with your database query
                                    $product_details = getProductDetailsById($product_id, $conn);

                                    // Calculate total price for this product (price * quantity)
                                    $subtotal = $product_details['price'] * $quantity;
                                    $order_amount += $subtotal;

                                    // calculate transaction fee
                                    $transaction_fee_subtotal = $product_details['net_weight_in_kg'] * $quantity;
                                    $transaction_fee += $transaction_fee_subtotal;
                                    
                            ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= $product_details['name'] ?></td>
                                        <td><?= $quantity ?></td>
                                        <td><?= '₱ ' . $product_details['price'] ?></td>
                                        <td>
                                            <button class="btn btn-danger remove-from-cart-btn" data-product-id="<?= $product_id ?>" type="button">Remove </button>
                                            <script src="customer-assets/js/remove_to_cart.js"></script>
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center">No products on cart. Please select products to add on 'Place Order'</td>
                                </tr>
                            <?php  }

                            ?>
                            <tr class="fw-bold">
                                <td class="text-end" colspan="3">Order Amount:</td>
                                <td colspan="3"><?= '₱ ' . $order_amount ?></td>
                            </tr>
                            <tr class="fw-bold">
                                <td class="text-end" colspan="3">Transaction Fee:</td>
                                <td colspan="3"><?= '₱ ' . TransactionFee($transaction_fee) ?></td>
                            </tr>
                            <tr class="fw-bold">
                                <td class="text-end" colspan="3">Total Amount:</td>
                                <td colspan="3"><?= '₱ ' . ($order_amount + TransactionFee($transaction_fee)) ?></td>
                            </tr>
                            <tr class="fw-bold">
                                <td class="text-end" colspan="3">Select Payment Method</td>
                                <td colspan="3">
                                    <select name="PaymentType" id="" class="form-select">
                                        <option value="COD">CASH ON DELIVERY</option>
                                        
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <input type="hidden" name="order_amount" value="<?= $order_amount ?>" id="">
                    <input type="hidden" name="transaction_fee" value="<?= TransactionFee($transaction_fee) ?>" id="">
                    <input type="hidden" name="order_date" value="<?= $DateNow ?>">
                    <button class="btn btn-warning <?php if (empty($_SESSION['cart'])) {
                                                        echo "disabled";
                                                    } ?>" name="btn_place_order" type="submit">Place Order</button>
                </div>
            </div>



        </form>
    </div>


</div>

<?php 
function TransactionFee($transaction_fee)
{
    $equivalent_fee = 0;
    
    if($transaction_fee == 0){
        $equivalent_fee = 0;
    }
    elseif ($transaction_fee > 0 && $transaction_fee <= 3.0) {
        $equivalent_fee = 80.00;
    } elseif ($transaction_fee > 3.0 && $transaction_fee <= 5.0) {
        $equivalent_fee = 100.00;
    } elseif ($transaction_fee > 5.0 && $transaction_fee <= 10.0) {
        $equivalent_fee = 120.00;
    } elseif ($transaction_fee > 10.0 && $transaction_fee <= 20.0) {
        $equivalent_fee = 400.00;
    } else {
        $equivalent_fee = 0;
    }
    return $equivalent_fee;
}

?>

<?php include 'customer-template/footer.php'; ?>