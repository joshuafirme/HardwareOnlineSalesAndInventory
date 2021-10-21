
async function fetchPurchasedOrders(supplier_id, date_from, date_to){
    $('.tbl-purchased-order-report').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/reports/purchased-order",
            type:"GET",
            data:{
                supplier_id :supplier_id,
                date_from   :date_from,
                date_to     :date_to
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
            {data: 'unit', name: 'unit'},  
            {data: 'qty_order', name: 'qty_order'},
            {data: 'amount', name: 'amount'},
            {data: 'date_order', name: 'date_order'},
        ]
       });
}

$(document).on('change','#supplier', async function(){

    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#supplier').val();
    $('.tbl-purchased-order-report').DataTable().destroy();
    await fetchPurchasedOrders(supplier_id, date_from, date_to);

  });

  $(document).on('change','#date_from', async function(){

    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#supplier').val();
    $('.tbl-purchased-order-report').DataTable().destroy();
    await fetchPurchasedOrders(supplier_id, date_from, date_to);
  });

  $(document).on('change','#date_to', async function(){

    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#supplier').val();
    $('.tbl-purchased-order-report').DataTable().destroy();
    await fetchPurchasedOrders(supplier_id, date_from, date_to);
  });
  
  $(document).on('click','.btn-preview-purchased-order-report', async function(){
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#supplier').val();
    window.open("/purchased-order/preview/"+supplier_id+"/"+date_from+"/"+date_to);
  });

  $(document).on('click','.btn-download-purchased-order-report', async function(){
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();
    var supplier_id = $('#supplier').val();
    window.open("/purchased-order/download/"+supplier_id+"/"+date_from+"/"+date_to);
  });

async function render() 
{

    var supplier_id = $('#supplier').val();
    var date_from = $('#date_from').val()
    var date_to = $('#date_to').val();

    await fetchPurchasedOrders(supplier_id, date_from, date_to);
}

render();