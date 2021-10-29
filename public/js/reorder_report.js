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
            url: "/reports/reorder",
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
        ]
       });

       $(document).on('change','#supplier', function(){
            var supplier_id = $(this).val();
            $('.tbl-reorder').DataTable().destroy(); 
            fetchReorderProducts(supplier_id);
    
        });
 
}


async function onClick() {
    $(document).on('click','.btn-preview', function(){
        var supplier_id = $('#supplier').val();
        window.open("/reorder/preview/" + supplier_id);
    });

    $(document).on('click','.btn-download', function(){
        var supplier_id = $('#supplier').val();
        window.open("/reorder/download/" + supplier_id);
    });
   
}
  
async function render() {
    var supplier_id = $('#supplier').val();
    await fetchReorderProducts(supplier_id);
    await onClick();
}

render();