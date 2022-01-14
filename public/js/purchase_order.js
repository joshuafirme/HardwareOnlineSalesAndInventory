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
    $('#description').val(description); console.log(price)
    $('#selling-price').val(price);
    $('#qty').val(qty);
    $('#qty_order').val('');
    $('#total').text('')
  }); 
  
$(document).on('click', '.btn-confirm-order', function(){
    var product_code  = $('#product_code').val();
    var qty_order     = $('#qty_order').val();
    var total         = $('#total').text().slice(1);
    
    $.ajax({
        url: '/purchase-order/add-order',
        type: 'POST',
        data: {
            product_code    :product_code,
            qty_order       :qty_order,
            amount          :total,
        },
        beforeSend:function(){
            $('.btn-confirm-order').text('Please wait...');
        },
        
        success:function(data){ console.log(data)
            setTimeout(function(){
                $('.btn-confirm-order').text('Add order');
                $('#purchase-order-modal').modal('hide');
                $.toast({
                    text: $('#description').val()+' was successfully added to orders.',
                    showHideTransition: 'plain',
                    hideAfter: 5000, 
                });
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

       $(document).on('change','#ro_supplier', function(){
            var supplier_id = $(this).val();
            $('.tbl-reorder').DataTable().destroy();
            fetchReorderProducts(supplier_id);
    
        });
 
}

async function fetchPurchasedOrders(supplier_id, date_from, date_to){
    $('#purchased-order-table').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/purchased-order",
            type:"GET",
            data:{
                supplier_id :supplier_id,
                date_from   :date_from,
                date_to     :date_to,
            }
        },
   
        columnDefs: [{
          targets: 0,
          searchable: true,
          orderable: false,
          changeLength: false
       }],
       order: [[0, 'desc']],
            
        columns:[       
            {data: 'po_num', name: 'po_num'},
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},   
            {data: 'supplier', name: 'supplier'},     
            {data: 'category', name: 'category'}, 
            {data: 'unit', name: 'unit'},  
            {data: 'qty_order', name: 'qty_order'},
            {data: 'amount', name: 'amount'},
            {data: 'date_order', name: 'date_order'},
            {data: 'remarks', name: 'remarks',orderable: false},
        ]
       });
}


$(document).on('change','#ord_supplier', async function(){

    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#ord_supplier').val();
    $('#purchased-order-table').DataTable().destroy();
    await fetchPurchasedOrders(supplier_id, date_from, date_to);

  });

  $(document).on('change','#date_from', async function(){

    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#ord_supplier').val();
    console.log(date_from);
    $('#purchased-order-table').DataTable().destroy();
    fetchPurchasedOrders(supplier_id, date_from, date_to);
  });

  $(document).on('change','#date_to', async function(){

    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#ord_supplier').val();
    console.log(date_to);
    $('#purchased-order-table').DataTable().destroy();
    await fetchPurchasedOrders(supplier_id, date_from, date_to);
  });

// compute total amount
$(document).on('keyup','#qty_order',function(){
    var qty = $(this).val();
    
    var price = $('#selling-price').val();
    var amount = qty * price;
    $('#total').text('₱'+amount);
});
  


async function onClick() {
    
    $(document).on('click','#btn-show-request-orders',async function(){
        var supplier_id = $('#ro_supplier').val();
        var supplier_name = $('#ro_supplier option:selected').text();
        $('.supplier-name').text(supplier_name);
        await fetchRequestOrderBySupplier(supplier_id);
    });

    $(document).on('click','.btn-remove', async function(){
        var id = $(this).attr('data-id');
        var supplier_id = $('#ro_supplier').val();
        $.ajax({
            url: '/request-order/remove',
            type: 'POST',
            data: {
                id : id
            }, 
            success:async function(data){
                console.log(data)
                await fetchRequestOrderBySupplier(supplier_id);
                $.toast({
                    text: 'Product was successfully removed.',
                    showHideTransition: 'plain',
                    hideAfter: 5000, 
                });
            }
        });
    });

    $(document).on('click','#btn-purchase-order', async function(){

        var arr = [];
        $("#order-request-table tbody tr").each(function(){
            arr.push($(this).find("td:first").text());
        });
        
        $.ajax({
            url: '/purchase-order',
            type: 'POST',
            data: {
                product_codes : arr.slice(0, arr.length -1)
            }, 
            beforeSend:function(){
                $('#btn-purchase-order').text('Please wait...');
            },
            success:async function(data){
                $('#purchased-order-table').DataTable().ajax.reload();
                var supplier_id = $('#ro_supplier').val();
                await fetchRequestOrderBySupplier(supplier_id);
                $('#btn-purchase-order').text('Purchase Order');
                $.toast({
                    text: 'Products was successfully recorded to Purchased Orders.',
                    showHideTransition: 'plain',
                    hideAfter: 7000, 
                });
            }
        });
      
    });

    $(document).on('click','#orders-tab', function(){
        $('#purchased-order-table').DataTable().ajax.reload();
    });
    $(document).on('click','#reorder-tab', function(){
        $('.tbl-reorder').DataTable().ajax.reload();
    });

    $(document).on('click','.btn-preview', function(){ console.log('sdsa')
        window.open("/preview-request-order");
    });

    $(document).on('click','.btn-download', function(){
        window.open("/download-request-order");
    });
   
}

async function fetchRequestOrderBySupplier(supplier_id) {
    $('.lds-default').show();
    $('#order-request-table tbody').html('');
    $('#order-request-modal .modal-body .no-data').html('');
    $.ajax({
        url: '/request-order',
        type: 'GET',
        data: {
            supplier_id : supplier_id
        },
        success:function(data){
            setTimeout(function() {

                var html = "";
                
                if (data.length > 0) {
                    data_storage = data;
                    var total = 0
                    for (var i = 0; i < data_storage.length; i++) {
                        if (typeof data_storage[i] != 'undefined')         
                        html += getItems(data_storage[i]);
                        total =  parseFloat(data_storage[i].amount) + parseFloat(total);
                    }
                    html += '<tr>';
                    html += '<td></td>';
                    html += '<td></td>';
                    html += '<td></td>';
                    html += '<td></td>';
                    html += '<td></td>';
                    html += '<td>Total</td>';
                    html += '<td style="text-align:right;">₱'+ formatNumber(total) +'</td>';
                    html += '<td></td>';
                    html += '</tr>';
                    $('.lds-default').hide();
                    $('#order-request-table tbody').append(html);
                    document.getElementById("btn-purchase-order").disabled = false;
                }
                else {
                    html += '<p class="text-center no-data">No data found.</p>';
                    $('#order-request-modal .modal-body').append(html);
                    $('.lds-default').hide();
                    document.getElementById("btn-purchase-order").disabled = true;
                }
            },300)

        }
    });
}

function getItems (data) {
    var html = "";
    html += '<tr>';
    html += '<td>'+ data.product_code +'</td>';
    html += '<td>'+ data.description +'</td>';
    html += '<td>'+ data.unit +'</td>';
    html += '<td>'+ data.category +'</td>';
    html += '<td>'+ data.supplier +'</td>';
    html += '<td>'+ data.qty_order +'</td>';
    html += '<td style="text-align:right;">₱'+ formatNumber(data.amount) +'</td>';
    html += '<td><a class="btn btn-sm btn-remove" data-id='+ data.id +'><i class="fa fa-trash"></i></a></td>'
    html += '</tr>';
    return html;
}

function formatNumber(value)
{
  var decimal = (Math.round(value * 100) / 100).toFixed(2);
  return parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
  
async function render() {
    var supplier_id = $('#ro_supplier').val();
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    await fetchReorderProducts(supplier_id);
    await onClick();
    await fetchPurchasedOrders($('#ord_supplier').val(), date_from, date_to);
}

render();