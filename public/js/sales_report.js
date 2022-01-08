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
            url: "/read-sales",
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
            {data: 'action', name: 'action'},
        ]
       });
}

async function fetchTotalSales(date_from, date_to, order_from, payment_method) {
    $('#txt-total-sales').html('<i class="fas fa-spinner fa-spin"></i>');
    $.ajax({
        url: '/compute-total-sales',
        type: 'GET',
        data: {
            date_from        :date_from,
            date_to          :date_to,
            payment_method   :payment_method,
            order_from       :order_from,
        },
        success:async function(total_sales){
            
            total_sales = parseFloat(total_sales)
            $('#txt-total-sales').html(formatNumber(total_sales));
        }
    });
}

function formatNumber(total)
{
  var decimal = (Math.round(total * 100) / 100).toFixed(2);
  return money_format = parseFloat(decimal).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$(document).on('click','.btn-preview-sales', async function(){
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var order_from = $('#order_from').val()
    var payment_method = $('#payment_method').val();
    window.open("/reports/preview-sales/"+date_from+"/"+date_to+"/"+order_from+"/"+payment_method);
});

$(document).on('click','.btn-download-sales', async function(){
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var order_from = $('#order_from').val()
    var payment_method = $('#payment_method').val();
    window.open("/reports/download-sales/"+date_from+"/"+date_to+"/"+order_from+"/"+payment_method);
});


async function on_Change() {
    $(document).on('change','#date_from', async function(){

        var date_from = $(this).val();
        var date_to = $('#date_to').val();
        var order_from = $('#order_from').val()
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);

        await fetchTotalSales(date_from, date_to, order_from, payment_method);
    });
    
    $(document).on('change','#date_to', async function(){
    
        var date_to = $(this).val();
        var date_from = $('#date_from').val();
        var order_from = $('#order_from').val();
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);

        await fetchTotalSales(date_from, date_to, order_from, payment_method);
    });

    $(document).on('change','#order_from', async function(){

        var date_to = $('#date_to').val();
        var date_from = $('#date_from').val();
        var order_from = $('#order_from').val();
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);

        await fetchTotalSales(date_from, date_to, order_from, payment_method);
    });

    $(document).on('change','#payment_method', async function(){

        var date_to = $('#date_to').val();
        var date_from = $('#date_from').val();
        var order_from = $('#order_from').val();
        var payment_method = $('#payment_method').val();

        $('.tbl-sales').DataTable().destroy();

        await fetchSales(date_from, date_to, order_from, payment_method);

        await fetchTotalSales(date_from, date_to, order_from, payment_method);
    });
}

var product_id;
$(document).on('click', '.btn-archive', function(){ console.log('test')
  product_id = $(this).attr('data-id');
  var row = $(this).closest("tr"); console.log(product_id)
  var name = row.find("td:eq(2)").text();
  var invoice = row.find("td:eq(0)").text();
  $('#confirmModal').modal('show');
  $('.delete-success').hide();
  $('.delete-message').html('Are you sure do you want to archive <b>'+ name +'</b> with invoice <b>#'+invoice+'</b>?');
}); 

$(document).on('click', '.btn-confirm-archive', function(){
  $.ajax({
      url: '/reports/archive/'+ product_id,
      type: 'POST',
    
      beforeSend:function(){
          $('.btn-confirm-archive').text('Please wait...');
      },
      
      success:function(){
          setTimeout(function(){

              $('.btn-confirm-archive').text('Yes');
              $('.tbl-sales').DataTable().ajax.reload();
              $('#confirmModal').modal('hide');
              $.toast({
                  text: 'Data was successfully archived.',
                  showHideTransition: 'plain'
              })
          }, 1000);
      }
  });

});

async function renderComponents() {
    
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    var order_from = $('#order_from').val()
    var payment_method = $('#payment_method').val();

    await fetchSales(date_from, date_to, order_from, payment_method);

    await fetchTotalSales(date_from, date_to, order_from, payment_method);

    await on_Change();
}

renderComponents();