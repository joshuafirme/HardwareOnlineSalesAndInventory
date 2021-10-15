
<div class="modal fade bd-example-modal-lg" id="purchase-order-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Add to Request Order</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
                  <div class="row">
                      <input type="hidden" name="product_id" id="product_id">
                      <div class="col-sm-12 col-md-6 mt-2">
                          <label class="col-form-label">Product Code</label>
                          <input type="text" class="form-control" name="product_code" id="product_code" readonly>
                      </div>
                      
                      <div class="col-sm-12 col-md-6 mt-2">
                          <label class="col-form-label">Description</label>
                          <input type="text" class="form-control" name="description" id="description" readonly>
                      </div>
  
                      <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Price</label>
                        <input type="number" step=".01" class="form-control" name="price" id="price" readonly>
                      </div>
  
                      <div class="col-sm-12 col-md-6 mt-2">
                          <label class="col-form-label">Qty</label>
                          <input type="number" class="form-control" name="qty" id="qty" readonly>
                      </div>
  
                      <div class="col-sm-12 col-md-6 mt-2">
                          <label class="col-form-label">Qty order</label>
                          <input type="number" class="form-control" name="qty_order" id="qty_order">
                      </div>
  
                      <div class="col-sm-12 col-md-6 mt-2">
                        <label class="col-form-label">Total Amount</label>
                        <div class="form-control" name="total" id="total">
                      </div>
  
                  </div>
          </div>
          <div class="modal-footer mt-4">
              <button class="btn btn-sm btn-success btn-confirm-order" type="button">Add</button>
              <button class="btn btn-sm" data-dismiss="modal">Cancel</button>
          </div>
      </div>
    </div>
  </div>
</div>

  <div class="modal fade bd-example-modal-lg" id="order-request-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Purchase Order</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          
          <div class="col-12 mt-3">
            <a class="btn btn-sm btn-outline-dark btn-preview float-right m-1">Print Preview</a>
            <a class="btn btn-sm btn-outline-success btn-download float-right m-1"><i class="fas fa-download"></i> Download PDF</a>
          </div>

            <div class="modal-body">
                <h3 class="text-center mb-2 supplier-name"></h3>
                <table class="table table-bordered table-striped table-hover" id="order-request-table">
                    <thead>
                        <th>Product Code</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="loader-container">
                <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
            </div>

            <div class="modal-footer mt-4">
                <button class="btn btn-sm btn-success" id="btn-purchase-order" type="button">Purchase Order</button>
                <button class="btn btn-sm" data-dismiss="modal">Cancel</button>
            </div>

      </div>
    </div>
  </div>
  
