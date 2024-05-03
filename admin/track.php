<?php
include "template/header.php";
include "page-includes/sidebar.php";
include "page-includes/navbar.php";

// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

// Fetch data from database
$sql_FetchTracks = "SELECT tti.*, ts.Status 
FROM tbl_trackinginformation tti
INNER JOIN tbl_trackingstatus ts ON tti.TrackingStatusID = ts.TrackingStatusID 
";
$result = mysqli_query($conn, $sql_FetchTracks);
?>

<!-- Page content -->
<div class="main">
    <div class="container-fluid bg-light p-3 border">
        <h3 class="text-center">Tracking System</h3>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-sm-12 col-md-10">
                <form method="GET" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="search" placeholder="Enter Tracking Number" aria-label="Enter Tracking Number" aria-describedby="button-search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-search" name="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid bg-light p-3 border">
        <div class="row">
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Tracking Number</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $RowCount = 0;
                    if (isset($_GET['submit'])) {
                        // Search logic
                        $search = sanitizeInput($_GET['search']);
                        $sql_FetchTracks .= " WHERE tti.TrackingNumber LIKE '%$search%'
                                            OR ts.Status LIKE '%$search%'
                                            OR tti.InitialDate LIKE '%$search%' ORDER BY tti.InitialDate DESC "; // Add more columns as needed
                    }
                    $result = mysqli_query($conn, $sql_FetchTracks);

                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row of data
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?= ++$RowCount ?></td>
                                <td><?= date('m/d/Y H:i', strtotime($row['InitialDate'])) ?></td>
                                <td><?= $row['TrackingNumber'] ?></td>
                                <td><?= $row['Status'] ?></td>
                                <td><a type="button" href="track-details.php?id=<?= $row['TrackingID'] ?>" class="btn btn-info text-white">View</a></td>
                            </tr>
                    <?php }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No tracking information found.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php
include "template/footer.php";
?>