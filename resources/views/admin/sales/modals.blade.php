<div class="modal fade bd-example-modal-lg" id="void-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Void Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
                  <div class="row">
                      <input type="hidden" name="product_id" id="product_id">
                      <div class="col-sm-12">
                          <label class="col-form-label">Admin username</label>
                          <input type="text" class="form-control" name="username" id="username">
                      </div>
                      <div class="col-sm-12 mt-2">
                        <label class="col-form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
  
                  </div>
          </div>
          <div class="modal-footer">
              <button class="btn btn-sm btn-danger" id="btn-confirm-void">Void</button>
              <button class="btn btn-sm" data-dismiss="modal">Cancel</button>
          </div>
      </div>
    </div>
  </div>