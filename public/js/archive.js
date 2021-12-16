$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

async function fetchProduct(date_from, date_to){
    $('#product-archive-table').DataTable({
       processing: true,
       serverSide: true,
       ajax:{
        url: "/archive/products",
        type:"GET",
        data:{
            date_from   :date_from,
            date_to     :date_to
            }
        },
       columns:[       
        {data: 'product_code', name: 'product_code',orderable: true},
        {data: 'description', name: 'description'},
        {data: 'qty', name: 'qty'},
        {data: 'reorder', name: 'reorder'},
        {data: 'unit', name: 'unit'},
        {data: 'category', name: 'category'},
        {data: 'supplier', name: 'supplier'},
        {data: 'orig_price',name: 'orig_price'},
        {data: 'selling_price',name: 'selling_price'}, 
        {data: 'updated_at',name: 'updated_at'},    
        {data: 'action', name: 'action',orderable: false},
       ]
      });
}

var product_id;
$(document).on('click', '.btn-restore-product', function(){
  product_id = $(this).attr('data-id');
  var row = $(this).closest("tr");
  var name = row.find("td:eq(1)").text();
  $('#restoreModal').modal('show');
  $('.delete-success').hide();
  $('.delete-message').html('Are you sure do you want to restore <b>'+ name +'</b>?');
}); 

$(document).on('click', '.btn-confirm-restore', function(){
  $.ajax({
      url: '/archive/restore/'+ product_id,
      type: 'POST',
    
      beforeSend:function(){
          $('.btn-confirm-restore').text('Please wait...');
      },
      
      success:function(){
          setTimeout(function(){

              $('.btn-confirm-restore').text('Yes');
              $('#product-archive-table').DataTable().ajax.reload();
              $('#restoreModal').modal('hide');
              $.toast({
                  text: 'Product was successfully restored.',
                  showHideTransition: 'plain'
              })
          }, 1000);
      }
  });

});
  
$(document).on('change','#date_from', async function(){
 
    var date_from = $(this).val();
    var date_to = $('#date_to').val();

    $('#product-archive-table').DataTable().destroy();

    await fetchData(date_from, date_to);
});

$(document).on('change','#date_to', async function(){

    var date_to = $(this).val();
    var date_from = $('#date_from').val();

    $('#product-archive-table').DataTable().destroy();

    await fetchProduct(date_from, date_to);
});

  async function render() {
    var date_to = $('#date_to').val();
    var date_from = $('#date_from').val();

    await fetchProduct(date_from, date_to);
  }

  render();