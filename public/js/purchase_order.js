$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

var product_id;
$(document).on('click', '.btn-add-to-order', function(){
    $('#purchase-order-modal').modal('show');
    product_id          = $(this).attr('data-id');
    var row             = $(this).closest("tr");
    var product_code    = row.find("td:eq(0)").text();
    var description     = row.find("td:eq(1)").text();
    var price           = row.find("td:eq(5)").text();
    var qty             = row.find("td:eq(6)").text();
    $('#product_id').val(product_id);
    $('#product_code').val(product_code);
    $('#description').val(description);
    $('#price').val(price);
    $('#qty').val(qty);
  }); 
  
$(document).on('click', '.btn-confirm-order', function(){
    var product_code  = $('#product_code').val();
    var qty_order     = $('#qty_order').val();
    var total         = $('#total').text().slice(1);
    console.log(total)
    $.ajax({
        url: '/purchase-ordsader/add-order',
        type: 'POST',
        data: {
            product_code    :product_code,
            qty_order       :qty_order,
            amount          :total,
        },
        beforeSend:function(){
            $('.btn-confirm-order').text('Please wait...');
        },
        
        success:function(){
            setTimeout(function(){

                $('.btn-confirm-adjust').text('Add order');
                $('#purchase-order-modal').modal('hide');
                $.toast({
                    text: $('#description').val()+' was successfully added to orders.',
                    showHideTransition: 'plain',
                    timeOut: 6500
                })
            }, 1000);
        }
    });
  
});

async function fetchReorderProducts(supplier_id){
    $('.tbl-reorder').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/display-reorders",
            type:"GET",
            data:{
                supplier_id:supplier_id
            }
        },
   
        columnDefs: [{
          targets: 0,
          searchable: false,
          orderable: false,
          changeLength: false
       }],
       order: [[0, 'desc']],
            
        columns:[       
             {data: 'product_code', name: 'product_code',orderable: true},
             {data: 'description', name: 'description'},
             {data: 'unit', name: 'unit'},
             {data: 'category', name: 'category'},
             {data: 'supplier', name: 'supplier'}, 
             {data: 'orig_price', name: 'orig_price'},
             {data: 'qty', name: 'qty'},
             {data: 'reorder', name: 'reorder'},
             {data: 'action', name: 'action',orderable: false},
        ]
       });

       $(document).on('change','#ro_supplier',function(){
            var supplier_id = $(this).val();
            $('.tbl-reorder').DataTable().destroy();
            fetchReorderProducts(supplier_id);
    
        });
 
}

// compute total amount
$(document).on('change','#qty_order',function(){
    var qty = $(this).val();
    
    var price = $('#price').val();console.log(price)
    var amount = qty * price;
    $('#total').text('₱'+amount);
    
  
  });
  
  
async function render() {
    var supplier_id = $('#ro_supplier').val();
    await fetchReorderProducts(supplier_id);
}

render();