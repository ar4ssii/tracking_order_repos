<!-- Modal -->
<div class="modal fade" id="seeOrderItemsModal_<?= $order['order_id'] ?>" tabindex="-1" aria-labelledby="seeOrderItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="seeOrderItemsModalLabel">Order Items</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <h6>Order Items</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalAmount = 0;
                            $index = 1;
                            mysqli_data_seek($result, 0); // Reset result pointer
                            while ($orderItem = mysqli_fetch_assoc($result)) {
                                $subtotal = $orderItem['product_price'] * $orderItem['quantity_ordered'];
                                $totalAmount += $subtotal;
                            ?>
                                <tr>
                                    <td><?= $index++ ?></td>
                                    <td><?= $orderItem['product_name'] ?></td>
                                    <td>₱<?= number_format($orderItem['product_price'], 2) ?></td>
                                    <td><?= $orderItem['quantity_ordered'] ?></td>
                                    <td>₱ <?= number_format($subtotal, 2) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>