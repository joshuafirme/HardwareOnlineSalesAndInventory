async function fetchSales(date_from, date_to, order_from, payment_method){
    $('.tbl-sales').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/product-return-read-sales",
            type:"GET",
            data:{
                date_from        :date_from,
                date_to          :date_to,
                payment_method   :payment_method,
                order_from       :order_from,
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
            {data: 'invoice_no', name: 'invoice_no'},
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},  
            {data: 'unit', name: 'unit'}, 
            {data: 'selling_price', name: 'selling_price'},
            {data: 'qty', name: 'qty'},
            {data: 'amount', name: 'amount'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'order_from', name: 'order_from'},
            {data: 'date_time', name: 'date_time'},
            {data: 'action', name: 'action', orderable:false},
        ]
       });
}


async function on_Change() {
    $(document).on('change','#date_from', async function(){

        var date_from = $(this).val();
        var date_to = $('#date_to').val();
        var order_from = $('#order_from').val()
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);
    });
    
    $(document).on('change','#date_to', async function(){
    
        var date_to = $(this).val();
        var date_from = $('#date_from').val();
        var order_from = $('#order_from').val();
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);
    });

    $(document).on('change','#order_from', async function(){

        var date_to = $('#date_to').val();
        var date_from = $('#date_from').val();
        var order_from = $('#order_from').val();
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);
    });

    $(document).on('change','#payment_method', async function(){

        var date_to = $('#date_to').val();
        var date_from = $('#date_from').val();
        var order_from = $('#order_from').val();
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);
    });

    $(document).on('change','#qty_return', async function(){

        var qty = $(this).val();
        var selling_price = $('#selling_price').val();
        var amount = qty * selling_price; 
        $('#amount').val(amount.toFixed(2));
    });
    
}

var product_id;

$(document).on('click', '.btn-return', function(){

    $('#productReturnModal').modal('show');
    var row             = $(this).closest("tr");
    var invoice_no      = row.find("td:eq(0)").text();
    var product_code    = row.find("td:eq(1)").text();
    var description     = row.find("td:eq(2)").text();
    var selling_price   = row.find("td:eq(4)").text();
    var qty_order       = row.find("td:eq(5)").text();
    var amount          = row.find("td:eq(6)").text();

    $('#invoice_no').val(invoice_no);
    $('#product_code').val(product_code);
    $('#description').val(description);
    $('#selling_price').val(selling_price);
    $('#qty_purchased').val(qty_order);
    $('#amount_purchased').val(amount);
    //$("#qty_return")[0].trigger('focus');
  }); 
  
$(document).on('click', '.btn-confirm-return', function(){
    var invoice_no      = $('#invoice_no').val();
    var product_code    = $('#product_code').val();
    var selling_price   = $('#selling_price').val();
    var qty_return      = $('#qty_return').val();
    var qty_purchased   = $('#qty_purchased').val();
    var reason          = $('#reason').val();
    $.ajax({
        url: '/return',
        type: 'POST',
        data:{
            invoice_no      :invoice_no,
            product_code    :product_code,
            selling_price   :selling_price,
            qty_return      :qty_return,
            qty_purchased   :qty_purchased,
            reason          :reason
        },
        beforeSend:function(){
            $('.btn-confirm-return').text('Please wait...');
        },
        
        success:function(){
            setTimeout(function(){

                $('.btn-confirm-return').text('Return');
                $('#productReturnModal').modal('hide');
                $.toast({
                    text: 'Product was successfully returned.',
                    showHideTransition: 'plain',
                    hideAfter: 4500, 
                })
            }, 1000);
        }
    });
  
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

async function renderComponents() {
    
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    var order_from = $('#order_from').val()
    var payment_method = $('#payment_method').val();

    await fetchSales(date_from, date_to, order_from, payment_method);

    await on_Change();
}

renderComponents();