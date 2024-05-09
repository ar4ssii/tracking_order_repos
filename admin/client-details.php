<?php
include "template/header.php";
include 'validation/employee-validation.php';
include "page-includes/sidebar.php";
include "page-includes/navbar.php";
?>
<?php
$ClientKeyID = $_GET['id'];

$sql_fetch_client_info = "
SELECT * FROM customers
WHERE customer_id = $ClientKeyID;
";
$result_fetch_client_info = mysqli_query($conn, $sql_fetch_client_info);

if (mysqli_num_rows($result_fetch_client_info) > 0) {
    // Loop through each row of data
    while ($customer = mysqli_fetch_assoc($result_fetch_client_info)) {

?>

        <!-- Page content -->
        <div class="main">
            <div class="container-fluid bg-light p-3 border">
                <h3 class="text-center">Edit Client Information</h3>
                <div class="table-responsive">
                    <form action="config/edit_client_info.php" method="post">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="tr-title">Name:</td>
                                    <td><input type="text" class="form-control" name="name" value="<?= $customer['name'] ?>"></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Delivery Address:</td>
                                    <td><input type="text" class="form-control" name="address" value="<?= $customer['address'] ?>"></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Contact Number:</td>
                                    <td><input type="text" class="form-control" name="contact_information" value="<?= $customer['contact_information'] ?>"></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Username:</td>
                                    <td><input type="text" class="form-control" name="username" value="<?= $customer['username'] ?>"></td>
                                </tr>
                                <tr>
                                    <td class="tr-title">Password:</td>
                                    <td><input type="password" class="form-control" name="password" value="<?= $customer['password'] ?>"></td>
                                </tr>

                            </tbody>
                        </table>

                        <div class="col d-flex justify-content-end">
                            <input type="hidden" name="ClientHiddenKey" value="<?= $_GET['id'] ?>">
                            <button class="btn btn-info" name="btn_edit_client" type="submit">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

<?php }
} ?>
<?php
include "template/footer.php"; ?>