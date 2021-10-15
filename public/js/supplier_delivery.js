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
            {data: 'unit', name: 'unit'},  
            {data: 'qty_order', name: 'qty_order'},
            {data: 'amount', name: 'amount'},
            {data: 'date_order', name: 'date_order'},
            {data: 'remarks', name: 'remarks',orderable: false},
            {data: 'action', name: 'action',orderable: false},
        ]
       });
}

 

async function on_Click() {

    $(document).on('click', '.btn-show-order', function(){

        var row             = $(this).closest("tr");

        var po_no           = row.find("td:eq(0)").text();
        var product_code    = row.find("td:eq(1)").text();
        var description     = row.find("td:eq(2)").text();
        var supplier        = row.find("td:eq(3)").text();
        var unit            = row.find("td:eq(4)").text();
        var qty_order       = row.find("td:eq(5)").text();

        $('#po_no').text(po_no);
        $('#po_product_code').text(product_code);
        $('#po_description').text(description);
        $('#supplier').text(supplier);
        $('#unit').text(unit);
        $('#qty_ordered').text(qty_order);
    });

    $(document).on('click', '#btn-add', function(){
        var btn = $(this);
        var po_no           = $('#po_no').text();
        var product_code    = $('#po_product_code').text();
        var qty_delivered   = $('#qty_delivered').val();
        var date_recieved   = $('#date_recieved').val();
        $.ajax({
            url: '/create-delivery',
            type: 'POST',
            data:{
                po_no           :po_no,
                product_code    :product_code,
                qty_delivered   :qty_delivered,
                date_recieved   :date_recieved
            },
            beforeSend:function(){
                btn.text('Please wait...');
            },
            
            success:function(data){
                console.log(data)
                setTimeout(function(){
                    btn.text('Adjust');
                    $('#purchased-order-table').DataTable().ajax.reload();
                    $('#delivery-modal').modal('hide');
                    $.toast({
                        text:'Delivery was successfully added.',
                        showHideTransition: 'plain',
                        hideAfter: 5000, 
                    })
                }, 500);
            }
        });
    });

}
async function on_Change(){

    $(document).on('change','#po_supplier', async function(){

        var date_from = $('#po_date_from').val()
        var date_to = $('#po_date_to').val();
        var supplier_id = $('#po_supplier').val();
        $('#purchased-order-table').DataTable().destroy();
        await fetchPurchasedOrders(supplier_id, date_from, date_to);
    
      });
    
      $(document).on('change','#po_date_from', async function(){
    
        var date_from = $('#po_date_from').val()
        var date_to = $('#po_date_to').val();
        var supplier_id = $('#po_supplier').val();
        console.log(date_from);
        $('#purchased-order-table').DataTable().destroy();
        fetchPurchasedOrders(supplier_id, date_from, date_to);
      });
    
      $(document).on('change','#po_date_to', async function(){
    
        var date_from = $('#date_from').val()
        var date_to = $('#po_date_to').val();
        var supplier_id = $('#po_supplier').val();
        console.log(date_to);
        $('#purchased-order-table').DataTable().destroy();
        await fetchPurchasedOrders(supplier_id, date_from, date_to);
      });
}

async function render() {
    var po_supplier_id = $('#po_supplier').val();
    var date_from = $('#po_date_from').val()
    var date_to = $('#po_date_to').val();


    await CSRF_TOKEN();

    await on_Change();

    await on_Click();

    await fetchPurchasedOrders(po_supplier_id, date_from, date_to);
}

async function CSRF_TOKEN() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
}

render();
