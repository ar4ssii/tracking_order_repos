<!-- Modal -->
<div class="modal fade" id="deliverModal_<?= $row['TrackingID'] ?>" tabindex="-1" aria-labelledby="deliverModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deliverModalLabel">Update Status to</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="config/Controller_UpdateTrackingStatus.php" method="post">
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <input type="text" name="KeyID" value="<?= $row['TrackingID'] ?>">
                                <td class="tr-title">Set Status to: </td>
                                <td>
                                    <select class="form-select" name="deliverUpdatedStatus" aria-label="">
                                        <option selected value="<?= $row['TrackingStatusID'] ?>"><?= $row['Status'] ?></option>
                                        <?php
                                        $keyTrackingStatusID = $row['TrackingStatusID'];
                                        $sql_selectStatus = "SELECT * FROM tbl_trackingstatus WHERE TrackingStatusID > $keyTrackingStatusID";
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
                                    Will be delivered by:
                                </td>
                                <td>
                                    <select class="form-select" disabled name="Rider" aria-label="">
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
                    <button type="submit" name="btn_deliver" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>