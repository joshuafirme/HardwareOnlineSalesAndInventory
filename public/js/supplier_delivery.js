async function fetchPurchasedOrders(supplier_id, date_from, date_to){
    $('#po-table').DataTable({
    
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

async function readSupplierDelivery(supplier_id, date_from, date_to){
    $('#sd-table').DataTable({
    
        processing: true,
        serverSide: true,
        ajax: '/path/to/script',
        scrollY: 470,
        scroller: {
            loadingIndicator: true
        },

        ajax:{
            url: "/read-supplier-delivery",
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
            {data: 'del_no', name: 'del_no'},     
            {data: 'po_no', name: 'po_no'},
            {data: 'product_code', name: 'product_code'},
            {data: 'description', name: 'description'},   
            {data: 'supplier', name: 'supplier'},   
            {data: 'unit', name: 'unit'},  
            {data: 'qty_order', name: 'qty_order'},
            {data: 'qty_delivered', name: 'qty_delivered'},
            {data: 'date_delivered', name: 'date_delivered'},
            {data: 'remarks', name: 'remarks',orderable: false}
        ]
       });
}

 

async function on_Click() {

    $(document).on('click', '#po-tab', function(){
        $('#po-table').DataTable().ajax.reload();
        var tab_object = 'po';
        on_Change(tab_object);
    });
    $(document).on('click', '#delivered-tab', function(){
        $('#sd-table').DataTable().ajax.reload();
        var tab_object = 'sd';
        on_Change(tab_object);
    });

    $(document).on('click', '.btn-show-order', function(){
        var $this = $(this);
        var row             = $this.closest("tr");

        localStorage.setItem('data-id', $this.attr('data-id'));

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
        var data_id = localStorage.getItem('data-id');
        var po_no           = $('#po_no').text();
        var product_code    = $('#po_product_code').text();
        var qty_delivered   = $('#qty_delivered').val();
        var date_recieved   = $('#date_recieved').val();
        $.ajax({
            url: '/create-delivery',
            type: 'POST',
            data:{
                data_id         :data_id,
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
                    btn.text('Add deliver');
                    $('#po-table').DataTable().ajax.reload();
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

async function renderDataTables(tab_object, supplier_id, date_from, date_to) {
    if (tab_object == 'po') {
        await fetchPurchasedOrders(supplier_id, date_from, date_to);
    }
    else {
        await readSupplierDelivery(supplier_id, date_from, date_to);
    }
}

async function on_Change(tab_object = 'po'){

    $(document).on('change','#'+ tab_object +'_supplier', async function(){

        var date_from   = $('#'+ tab_object +'_date_from').val()
        var date_to     = $('#'+ tab_object +'_date_to').val();
        var supplier_id = $('#'+ tab_object +'_supplier').val();

        $('#'+ tab_object +'-table').DataTable().destroy();
       
        renderDataTables(tab_object, supplier_id, date_from, date_to);
      });
    
      $(document).on('change','#'+ tab_object +'_date_from', async function(){
    
        var date_from   = $('#'+ tab_object +'_date_from').val()
        var date_to     = $('#'+ tab_object +'_date_to').val();
        var supplier_id = $('#'+ tab_object +'_supplier').val();

        $('#'+ tab_object +'-table').DataTable().destroy();

        renderDataTables(tab_object, supplier_id, date_from, date_to);
      });
    
      $(document).on('change','#'+ tab_object +'_date_to', async function(){
    
        var date_from   = $('#'+ tab_object +'_date_from').val()
        var date_to     = $('#'+ tab_object +'_date_to').val();
        var supplier_id = $('#'+ tab_object +'_supplier').val();

        $('#'+ tab_object +'-table').DataTable().destroy();

        renderDataTables(tab_object, supplier_id, date_from, date_to);
      });

}

async function renderComponents() {
    var po_supplier_id  = $('#po_supplier').val();
    var po_date_from    = $('#po_date_from').val()
    var po_date_to      = $('#po_date_to').val();
    var sd_supplier_id  = $('#sd_supplier').val();
    var sd_date_from    = $('#sd_date_from').val()
    var sd_date_to      = $('#sd_date_to').val();

    await CSRF_TOKEN();

    await on_Change();

    await on_Click();

    await fetchPurchasedOrders(po_supplier_id, po_date_from, po_date_to);

    await readSupplierDelivery(sd_supplier_id, sd_date_from, sd_date_to);
}

async function CSRF_TOKEN() {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
}

renderComponents();
