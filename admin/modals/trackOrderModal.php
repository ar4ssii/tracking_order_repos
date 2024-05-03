<!-- Modal -->
<div class="modal fade" id="trackOrderModal_<?= $order['orderInfo']['OrderID'] ?>" tabindex="-1" aria-labelledby="trackOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="trackOrderModalLabel">Track Order Now</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure to enable the tracking for order <?= 'ORN'. $order['orderInfo']['OrderID'] ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="config/Controller_trackOrder.php" method="post">
                    <input type="hidden" name="keyID" value="<?= $order['orderInfo']['OrderID'] ?>">
                    <button type="submit" name="btn_trackOrderEnabled" class="btn btn-primary">Enable Tracking</button>
                </form>
            </div>
        </div>
    </div>
</div>