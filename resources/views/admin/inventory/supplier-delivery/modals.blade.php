<div class="modal fade" id="delivery-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Delivery</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
  
            <div class="row">
  
              <div class="col-md-4 mb-2">
                <label class="col-form-label">Purchase Order #</label><br>
                <div class="form-control" id="po_no"></div>
              </div>
  
              <div class="col-md-4 mb-2">
                <label class="col-form-label">Product Code</label><br>
                <div class="form-control" id="po_product_code"></div>
              </div>
  
              <div class="col-md-4 mb-2">
                <label class="col-form-label">Name</label><br>
                <div class="form-control" id="po_description"></div>
              </div>
  
              <div class="col-md-4 mb-2">
                <label class="col-form-label">Supplier</label><br>
                <div class="form-control" id="supplier"></div>
              </div>
  
              <div class="col-md-4 mb-2">
                <label class="col-form-label">Unit</label><br>
                <div class="form-control" id="unit"></div>
              </div>
  
              <div class="col-md-4 mb-2">
                <label class="col-form-label">Quantity Ordered</label>
                <div class="form-control" id="qty_ordered"></div>
              </div>
  
              <div class="col-md-4">
                <label class="col-form-label">Quantity Delivered</label>
                <input type="number" min="1" max="1000" class="form-control" id="qty_delivered">
              </div>
  
              <div class="col-md-4">
                <label class="col-form-label">Date Delivered</label>
              <input type="date" class="form-control" id="date_recieved" value="{{ date('Y-m-d') }}">
              </div>
          </div>  
  
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary" id="btn-add">Add delivery</button>
  
        </div>
      </form>
      </div>
    </div>
  </div>