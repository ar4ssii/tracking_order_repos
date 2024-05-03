<!-- Modal -->
<div class="modal fade" id="seeCustomerModal_<?= $order['order_id'] ?>" tabindex="-1" aria-labelledby="seeCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="seeCustomerModalLabel">Customer Information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <h6>Customer Information</h6>
                    <table class="table table-bordered">
                        <tr>
                            <td>Name:</td>
                            <td><?= $order['customer_name'] ?></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><?= $order['customer_address'] ?></td>
                        </tr>
                        <tr>
                            <td>Contact Information:</td>
                            <td><?= $order['contact_information'] ?></td>
                        </tr>


                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>