$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

async function fetchSales(){
    $('#sales-archive-table').DataTable({
       processing: true,
       serverSide: true,
       ajax:{
        url: "/archive/sales",
        type:"GET",
        },
       columns:[       
        {data: 'invoice_no', name: 'invoice_no'},
        {data: 'product_code', name: 'product_code'},
        {data: 'description', name: 'description'},  
        {data: 'unit', name: 'unit'}, 
        {data: 'selling_price', name: 'selling_price'},
        {data: 'qty', name: 'qty'},
        {data: 'amount', name: 'amount'},
        {data: 'payment_method', name: 'payment_method'},
        {data: 'order_from', name: 'order_from'},
        {data: 'updated_at', name: 'updated_at'},
       ]
      });
}


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

async function fetchUser(date_from, date_to){
    $('#user-archive-table').DataTable({
       processing: true,
       serverSide: true,
       ajax:{
        url: "/archive/users",
        type:"GET",
        data:{
            date_from   :date_from,
            date_to     :date_to
            }
        },
       columns:[       
        {data: 'name', name: 'name',orderable: true},
        {data: 'email', name: 'email'},
        {data: 'access_level', name: 'access_level'},
        {data: 'updated_at',name: 'updated_at'},   
        {data: 'action', name: 'action',orderable: false},
       ]
      });
}

var product_id;
$(document).on('click', '.btn-restore', function(){
  product_id = $(this).attr('data-id');
  var row = $(this).closest("tr");
  var name = row.find("td:eq(1)").text();
  $('#restoreModal').modal('show');
  $('.delete-success').hide();
  $('.delete-message').html('Are you sure do you want to restore <b>'+ name +'</b>?');
}); 

$(document).on('click', '.btn-confirm-restore', function(){
    var object = ""
    if ($('.nav-item').find('.active').attr('aria-controls') == 'pending') {
        object = "product";
    }
    else {
        object = "user";
    } 
    $.ajax({
        url: '/archive/restore/'+ product_id,
        type: 'POST',
        data: {
            object : object
        },      
        beforeSend:function(){
            $('.btn-confirm-restore').text('Please wait...');
        },
        
        success:async function(){
  
                $('.btn-confirm-restore').text('Yes');
        //        $('#'+object+'-archive-table').DataTable().destroy();
                
                if (object == 'product') {
                    $('#product-archive-table').DataTable().ajax.reload();
                }
                else {
                    $('#user-archive-table').DataTable().ajax.reload();
                }
                $('#restoreModal').modal('hide');
                $.toast({
                    text: object+' was successfully restored.',
                    showHideTransition: 'plain'
                })
        }
    });

});
  
$(document).on('change','#date_from', async function(){
 
    var date_from = $(this).val();
    var date_to = $('#date_to').val();

    $('#product-archive-table').DataTable().destroy();
    if ($('.nav-item').find('.active').attr('aria-controls') == 'pending') {
        await fetchProduct(date_from, date_to);
    }
    else {
        await fetchUser(date_from, date_to);
    }
});

$(document).on('change','#date_to', async function(){

    var date_to = $(this).val();
    var date_from = $('#date_from').val();

    $('#product-archive-table').DataTable().destroy();
    if ($('.nav-item').find('.active').attr('aria-controls') == 'pending') {
        await fetchProduct(date_from, date_to);
    }
    else {
        await fetchUser(date_from, date_to);
    }
});

$(document).on('click','.nav-item', async function(){

    var date_to = $('#date_to').val();
    var date_from = $('#date_from').val();

    if ($('.nav-item').find('.active').attr('aria-controls') == 'pending') {
        $('#product-archive-table').DataTable().destroy();
        await fetchProduct(date_from, date_to);
    }
    else {
        $('#user-archive-table').DataTable().destroy();
        await fetchUser(date_from, date_to);
    }
    $('#sales-archive-table').DataTable().destroy();
        await fetchSales();
});

  async function render() {
    await fetchSales();
  }

  render();