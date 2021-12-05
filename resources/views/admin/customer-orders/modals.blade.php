<div class="modal fade bd-example-modal-lg" id="show-orders-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Orders</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p id="order-no-text"></p>
              <div class="mt-3 mb-3" id="user-info-container"></div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="orders-container"></tbody>
            </table>

          </div>
          <div class="modal-footer">
          </div>
          <meta id="shipping-fee-value">
      </div>
    </div>
  </div>