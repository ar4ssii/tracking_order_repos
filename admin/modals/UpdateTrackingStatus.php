<!-- Modal -->
<div class="modal fade" id="updateStatusModal_<?= $row['TrackingID'] ?>" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="updateStatusModalLabel">Update the Status of <?= $row['TrackingNumber'] ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="config/Controller_UpdateTrackingStatus.php" method="post">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <input type="hidden" name="hiddenID" value="<?= $row['TrackingID'] ?>">
                                <td class="tr-title">Set Status to: </td>
                                <td>
                                    <select class="form-select" name="UpdatedStatus" aria-label="">
                                        <option selected disabled value="<?= $row['TrackingStatusID'] ?>"><?= $row['Status'] ?></option>
                                        <?php
                                        $keyTrackingStatusID = $row['TrackingStatusID'];
                                        $sql_selectStatus = "SELECT * FROM tbl_trackingstatus WHERE TrackingStatusID != $keyTrackingStatusID";
                                        $result = mysqli_query($conn, $sql_selectStatus);
                                        while ($fetch = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?= $fetch['TrackingStatusID'] ?>"><?= $fetch['Status'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>

                            
                            <tr>
                                <td class="tr-title">
                                    You are from post:
                                </td>
                                <td>
                                    <select class="form-select" name="FromPost" aria-label="">
                                        <?php
                                        $sql_FromPost = "SELECT * FROM tbl_postlocations";
                                        $result = mysqli_query($conn, $sql_FromPost);
                                        while ($fetchPost = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?= $fetchPost['postLocationID'] ?>"><?= $fetchPost['PostName'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="tr-title">
                                    Will be going to:
                                </td>
                                <td>
                                    <select class="form-select" name="ToPost" aria-label="">
                                        <option selected value="<?= $row['DestinationPostID'] ?>"><?= $row['DestinationPostName'] ?></option>
                                        <?php
                                        $DestinationPostID = $row['DestinationPostID'];
                                        $sql_ToPost = "SELECT * FROM tbl_postlocations WHERE postLocationID != '$DestinationPostID'";
                                        $result = mysqli_query($conn, $sql_ToPost);
                                        while ($fetchPost_2 = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <option value="<?= $fetchPost_2['postLocationID'] ?>"><?= $fetchPost_2['PostName'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <td class="tr-title">
                                    Will be delivered by:
                                </td>
                                <td>
                                <select class="form-select" <?php echo ($row['TrackingStatusID'] != 4) ? 'disabled' : ''; ?> name="Rider" aria-label="">
                                        <option value="">Rider 1</option>
                                        <option value="">Rider 2</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="btn_updateStatus" class="btn btn-success">Save updates</button>
                </div>
            </form>
        </div>
    </div>
</div>